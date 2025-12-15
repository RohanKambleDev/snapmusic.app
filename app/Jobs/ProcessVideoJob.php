<?php

namespace App\Jobs;

use App\Models\VideoJob;
use App\Services\VideoProcessingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessVideoJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 600; // 10 minutes timeout
    public $tries = 3; // Retry 3 times if failed

    /**
     * Create a new job instance.
     */
    public function __construct(
        public VideoJob $videoJob
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(VideoProcessingService $videoProcessor): void
    {
        try {
            // Mark job as processing
            $this->videoJob->markAsProcessing();

            Log::channel('snapmusic')->info('Starting video processing', [
                'video_job_id' => $this->videoJob->id,
                'user_id' => $this->videoJob->user_id,
            ]);

            // Get absolute paths for source files
            $imagePath = Storage::path($this->videoJob->image_path);
            $audioPath = Storage::path($this->videoJob->audio_path);

            // Generate unique filename for output video
            $videoFileName = 'video_' . $this->videoJob->id . '_' . time() . '.mp4';
            $videoPath = 'videos/' . $videoFileName;
            $absoluteVideoPath = Storage::path($videoPath);

            // Ensure videos directory exists
            Storage::makeDirectory('videos');

            // Get audio duration before processing
            $duration = $videoProcessor->getAudioDuration($audioPath);
            $this->videoJob->update(['duration' => (int) $duration]);

            // Process video
            $videoProcessor->generateVideo($imagePath, $audioPath, $absoluteVideoPath);

            // Mark job as completed
            $this->videoJob->markAsCompleted($videoPath);

            Log::channel('snapmusic')->info('Video processing completed', [
                'video_job_id' => $this->videoJob->id,
                'output_path' => $videoPath,
            ]);

            // Delete source files after successful processing
            $videoProcessor->deleteSourceFiles($imagePath, $audioPath);

        } catch (\Exception $e) {
            // Mark job as failed
            $this->videoJob->markAsFailed($e->getMessage());

            Log::channel('snapmusic')->error('FFMPEG_PROC_ERR: Video processing failed', [
                'video_job_id' => $this->videoJob->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Re-throw the exception to trigger job retry
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        // This method is called when all retry attempts have been exhausted
        $this->videoJob->markAsFailed(
            'Video processing failed after ' . $this->tries . ' attempts: ' . $exception->getMessage()
        );

        Log::channel('snapmusic')->error('JOB_FAILED: Video job permanently failed', [
            'video_job_id' => $this->videoJob->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
