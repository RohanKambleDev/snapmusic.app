<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessVideoJob;
use App\Models\VideoJob;
use App\Services\VideoProcessingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VideoController extends Controller
{
    /**
     * Display the wizard or upload form
     */
    public function index()
    {
        // Handle upload errors redirected from exception handler
        if (request()->has('upload_error') && request()->get('upload_error') == '413') {
            return redirect()->route('make-a-video.index')
                ->with('error', 'The uploaded files are too large. Maximum total size is ' . ini_get('post_max_size') . '.');
        }

        $jobs = null;
        $processingJobs = '[]';

        if (auth()->check()) {
            $jobs = auth()->user()->videoJobs()
                ->latest()
                ->paginate(10);

            if (isset($jobs)) {
                $processingJobs = json_encode($jobs->whereIn('status', ['pending', 'processing'])->pluck('id')->toArray());
            }
        }

        // Check for immediately failed/completed job from session
        if (session()->has('latest_job_id')) {
            $latestJob = VideoJob::find(session('latest_job_id'));
            if ($latestJob) {
                if ($latestJob->status === 'failed') {
                    session()->forget('latest_job_id');
                    session()->forget('success');
                } elseif ($latestJob->status === 'completed') {
                    session()->flash('video_completed', [
                        'id' => $latestJob->id,
                        'download_url' => route('make-a-video.download', $latestJob),
                        'stream_url' => route('make-a-video.stream', $latestJob),
                    ]);
                    session()->forget('latest_job_id');
                    session()->forget('success');
                }
            } else {
                session()->forget('latest_job_id');
            }
        }

        $wizardData = session('wizard', []);

        return view('make-a-video.index', compact('jobs', 'processingJobs', 'wizardData'));
    }

    /**
     * Step 1: Upload Image
     */
    public function storeStep1(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            $sessionId = session()->getId();
            $path = $request->file('image')->store("temp/{$sessionId}/images");
            
            session()->put('wizard.image', $path);
            session()->put('wizard.image_name', $request->file('image')->getClientOriginalName());
            session()->put('wizard.step', 2);

            return response()->json(['success' => true, 'path' => $path]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Step 2: Upload Audio
     */
    public function storeStep2(Request $request)
    {
        $request->validate([
            'audio' => 'required|mimes:mp3,wav|max:10240',
        ]);

        try {
            $sessionId = session()->getId();
            $path = $request->file('audio')->store("temp/{$sessionId}/audio");
            
            session()->put('wizard.audio', $path);
            session()->put('wizard.audio_name', $request->file('audio')->getClientOriginalName());
            session()->put('wizard.step', 3);

            return response()->json(['success' => true, 'path' => $path]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Step 2 (Alternative): Process YouTube Audio
     */
    public function storeYoutubeAudio(Request $request, VideoProcessingService $videoProcessor)
    {
        $request->validate([
            'url' => 'required|url',
            'start_time' => 'required|integer|min:0',
        ]);

        try {
            $sessionId = session()->getId();
            // Create temp directory if not exists
            $tempDir = "temp/{$sessionId}/audio";
            Storage::makeDirectory($tempDir);
            
            $filename = 'youtube_' . time() . '.mp3';
            $relativePath = $tempDir . '/' . $filename;
            $absolutePath = Storage::path($relativePath);

            // Duration is fixed at 30 seconds
            $duration = 30;

            // Download and trim
            $videoProcessor->downloadYoutubeAudio(
                $request->url, 
                $request->start_time, 
                $duration, 
                $absolutePath
            );
            
            session()->put('wizard.audio', $relativePath);
            session()->put('wizard.audio_name', 'YouTube Audio (' . gmdate('i:s', $request->start_time) . '-' . gmdate('i:s', $request->start_time + $duration) . ')');
            session()->put('wizard.step', 3);

            return response()->json([
                'success' => true, 
                'path' => $relativePath,
                'filename' => session('wizard.audio_name')
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::channel('snapmusic')->error('YOUTUBE_ERR: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Serve the temporary image preview
     */
    public function previewImage()
    {
        $path = session('wizard.image');

        if (!$path || !Storage::exists($path)) {
            abort(404);
        }

        return response()->file(Storage::path($path));
    }

    /**
     * Final Step: Process Video
     */
    public function process(Request $request)
    {
        $user = auth()->user();
        
        $imagePath = session('wizard.image');
        $audioPath = session('wizard.audio');

        if (!$imagePath || !$audioPath || !Storage::exists($imagePath) || !Storage::exists($audioPath)) {
             return response()->json(['success' => false, 'message' => 'Session expired or files missing. Please start over.'], 400);
        }

        try {
            // Move files to permanent location
            $newImagePath = 'uploads/images/' . basename($imagePath);
            $newAudioPath = 'uploads/audio/' . basename($audioPath);
            
            // Ensure directories exist
            Storage::makeDirectory('uploads/images');
            Storage::makeDirectory('uploads/audio');

            Storage::move($imagePath, $newImagePath);
            Storage::move($audioPath, $newAudioPath);

            // Create a new video job record
            $videoJob = VideoJob::create([
                'user_id' => $user->id,
                'image_path' => $newImagePath,
                'audio_path' => $newAudioPath,
                'status' => 'pending',
            ]);

            // Dispatch the job to the queue
            ProcessVideoJob::dispatch($videoJob);

            // Track this job
            session()->put('latest_job_id', $videoJob->id);
            session()->forget('wizard');

            // Cleanup temp directory
            $parts = explode('/', $imagePath);
            if (count($parts) >= 2 && $parts[0] === 'temp') {
                $tempSessionId = $parts[1];
                if (preg_match('/^[a-zA-Z0-9,-]+$/', $tempSessionId)) {
                    Storage::deleteDirectory("temp/{$tempSessionId}");
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'SnapMusic processing started',
                'job_id' => $videoJob->id,
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::channel('snapmusic')->error('PROCESS_ERR: Job creation failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }

    /**
     * Set a session flash message for a completed job
     */
    public function notifyCompletion(VideoJob $videoJob)
    {
        if ($videoJob->user_id !== auth()->id()) {
            abort(403);
        }

        if ($videoJob->status === 'completed') {
            session()->flash('video_completed', [
                'id' => $videoJob->id,
                'download_url' => route('make-a-video.download', $videoJob),
                'stream_url' => route('make-a-video.stream', $videoJob),
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Show the status of a specific video job
     */
    public function status(VideoJob $videoJob)
    {
        // Ensure user can only view their own jobs
        if ($videoJob->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return response()->json([
            'id' => $videoJob->id,
            'status' => $videoJob->status,
            'error_message' => $videoJob->error_message,
            'video_path' => $videoJob->video_path,
            'duration' => $videoJob->duration,
            'created_at' => $videoJob->created_at,
            'updated_at' => $videoJob->updated_at,
        ]);
    }

    /**
     * Serve the video thumbnail
     */
    public function thumbnail(VideoJob $videoJob)
    {
        // Ensure user can only view their own thumbnails
        if ($videoJob->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        if (!$videoJob->thumbnail_path || !Storage::exists($videoJob->thumbnail_path)) {
            // Return a default placeholder or 404
            abort(404, 'Thumbnail not found');
        }

        return response()->file(Storage::path($videoJob->thumbnail_path));
    }

    /**
     * Download the generated video
     */
    public function download(VideoJob $videoJob)
    {
        // Ensure user can only download their own videos
        if ($videoJob->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Ensure video is completed
        if (!$videoJob->isCompleted() || !$videoJob->video_path) {
            abort(404, 'Video not found or not ready yet');
        }

        // Check if file exists
        if (!Storage::exists($videoJob->video_path)) {
            abort(404, 'Video file not found');
        }

        // Return download response
        return Storage::download(
            $videoJob->video_path,
            'video_' . $videoJob->id . '.mp4'
        );
    }

    /**
     * Stream the video for preview
     */
    public function stream(VideoJob $videoJob)
    {
        // Ensure user can only stream their own videos
        if ($videoJob->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Ensure video is completed
        if (!$videoJob->isCompleted() || !$videoJob->video_path) {
            abort(404, 'Video not found or not ready yet');
        }

        // Check if file exists
        if (!Storage::exists($videoJob->video_path)) {
            abort(404, 'Video file not found');
        }

        $path = Storage::path($videoJob->video_path);
        $stream = fopen($path, 'r');

        return response()->stream(
            function () use ($stream) {
                fpassthru($stream);
                fclose($stream);
            },
            200,
            [
                'Content-Type' => 'video/mp4',
                'Content-Length' => filesize($path),
            ]
        );
    }

    /**
     * Delete a video job and its associated files
     */
    public function destroy(VideoJob $videoJob)
    {
        // Ensure user can only delete their own videos
        if ($videoJob->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Delete the video file if it exists
        if ($videoJob->video_path && Storage::exists($videoJob->video_path)) {
            Storage::delete($videoJob->video_path);
        }

        // Delete source files if they still exist
        if ($videoJob->image_path && Storage::exists($videoJob->image_path)) {
            Storage::delete($videoJob->image_path);
        }

        if ($videoJob->audio_path && Storage::exists($videoJob->audio_path)) {
            Storage::delete($videoJob->audio_path);
        }

        // Delete the database record
        $videoJob->delete();

        return redirect()
            ->back()
            ->with('success', 'Video deleted successfully');
    }
}
