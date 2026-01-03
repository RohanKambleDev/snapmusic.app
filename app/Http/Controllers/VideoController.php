<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadMediaRequest;
use App\Jobs\ProcessVideoJob;
use App\Models\VideoJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VideoController extends Controller
{
    /**
     * Display the upload form
     */
    public function index()
    {
        // Handle upload errors redirected from exception handler
        if (request()->has('upload_error') && request()->get('upload_error') == '413') {
            return redirect()->route('make-a-video.index')
                ->with('error', 'The uploaded files are too large. Maximum total size is ' . ini_get('post_max_size') . '.');
        }

        $jobs = auth()->user()->videoJobs()
            ->latest()
            ->paginate(10);

        return view('make-a-video.index', compact('jobs'));
    }

    /**
     * Handle the media file upload
     */
    public function upload(UploadMediaRequest $request)
    {
        $user = auth()->user();

        try {
            // Store the uploaded files
            $imagePath = $request->file('image')->store('uploads/images');
            if (!$imagePath) {
                throw new \Exception('Failed to store image file');
            }

            $audioPath = $request->file('audio')->store('uploads/audio');
            if (!$audioPath) {
                throw new \Exception('Failed to store audio file');
            }

            // Create a new video job record
            $videoJob = VideoJob::create([
                'user_id' => $user->id,
                'image_path' => $imagePath,
                'audio_path' => $audioPath,
                'status' => 'pending',
            ]);

            // Dispatch the job to the queue
            ProcessVideoJob::dispatch($videoJob);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Video processing started',
                    'job_id' => $videoJob->id,
                ]);
            }

            return redirect()
                ->route('make-a-video.index')
                ->with('success', 'Your video is being processed! You will see it here once it\'s ready.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::channel('snapmusic')->error('UPLOAD_ERR: File upload or job creation failed', [
                'user_id' => $user->id,
                'image_name' => $request->file('image')?->getClientOriginalName(),
                'audio_name' => $request->file('audio')?->getClientOriginalName(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing your request.',
                ], 500);
            }

            return back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while processing your upload. Please try again.']);
        }
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
            ->route('make-a-video.index')
            ->with('success', 'Video deleted successfully');
    }
}
