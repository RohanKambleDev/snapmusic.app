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
        $jobs = auth()->user()->videoJobs()
            ->latest()
            ->paginate(10);

        return view('videos.index', compact('jobs'));
    }

    /**
     * Handle the media file upload
     */
    public function upload(UploadMediaRequest $request)
    {
        $user = auth()->user();

        // Store the uploaded files
        $imagePath = $request->file('image')->store('uploads/images');
        $audioPath = $request->file('audio')->store('uploads/audio');

        // Create a new video job record
        $videoJob = VideoJob::create([
            'user_id' => $user->id,
            'image_path' => $imagePath,
            'audio_path' => $audioPath,
            'status' => 'pending',
        ]);

        // Dispatch the job to the queue
        ProcessVideoJob::dispatch($videoJob);

        return redirect()
            ->route('videos.index')
            ->with('success', 'Your video is being processed! You will see it here once it\'s ready.');
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
            ->route('videos.index')
            ->with('success', 'Video deleted successfully');
    }
}
