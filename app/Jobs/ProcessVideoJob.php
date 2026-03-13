<?php

namespace App\Jobs;

use App\Models\VideoJob;
use App\Services\VideoProcessingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessVideoJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 1800; // Increase timeout to 30 minutes for large files
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

            // Check if source files exist and are readable
            if (!File::exists($imagePath)) {
                throw new \Exception("Image source file not found: {$imagePath}");
            }
            if (!is_readable($imagePath)) {
                throw new \Exception("Image source file not readable: {$imagePath}");
            }

            if (!File::exists($audioPath)) {
                throw new \Exception("Audio source file not found: {$audioPath}");
            }
            if (!is_readable($audioPath)) {
                throw new \Exception("Audio source file not readable: {$audioPath}");
            }

            // Generate unique filename for output video
            $videoFileName = 'video_' . $this->videoJob->id . '_' . time() . '.mp4';
            $videoPath = 'videos/' . $videoFileName;
            $absoluteVideoPath = Storage::path($videoPath);

            // Ensure videos directory exists
            Storage::makeDirectory('videos');

            // Get audio duration before processing
            $duration = $videoProcessor->getAudioDuration($audioPath);
            $this->videoJob->update(['duration' => (int) $duration]);

            // Check file sizes for chunking (2MB = 2097152 bytes)
            $isLargeFile = filesize($audioPath) > 2097152 || filesize($imagePath) > 2097152;
            
            if ($isLargeFile) {
                Log::channel('snapmusic')->info('Processing large file(s)', [
                    'video_job_id' => $this->videoJob->id,
                    'audio_size' => filesize($audioPath),
                    'image_size' => filesize($imagePath),
                ]);

                // 1. Handle large image resizing
                if (filesize($imagePath) > 2097152) {
                    $resizedImageName = 'resized_' . basename($imagePath);
                    $resizedImagePath = dirname($imagePath) . '/' . $resizedImageName;
                    
                    if ($videoProcessor->resizeImage($imagePath, $resizedImagePath)) {
                        Log::channel('snapmusic')->info('Image resized', ['path' => $resizedImagePath]);
                        $imagePath = $resizedImagePath; // Use resized image
                    } else {
                        Log::channel('snapmusic')->warning('Image resize failed, using original');
                    }
                }

                // 2. Handle large audio splitting
                if (filesize($audioPath) > 2097152) {
                    $chunkDir = dirname($audioPath) . '/chunks_' . $this->videoJob->id;
                    
                    try {
                        // Split audio into 60s chunks
                        $audioChunks = $videoProcessor->splitAudio($audioPath, 60, $chunkDir);
                        
                        $videoChunks = [];
                        $totalChunks = count($audioChunks);

                        foreach ($audioChunks as $index => $chunkPath) {
                            $chunkNumber = $index + 1;
                            $chunkVideoPath = $chunkDir . '/video_part_' . sprintf('%03d', $index) . '.mp4';
                            
                            Log::channel('snapmusic')->info("Processing chunk {$chunkNumber}/{$totalChunks}", [
                                'video_job_id' => $this->videoJob->id
                            ]);

                            // Generate video segment
                            $videoProcessor->generateVideo($imagePath, $chunkPath, $chunkVideoPath);
                            $videoChunks[] = $chunkVideoPath;
                        }

                        // Concatenate video segments
                        Log::channel('snapmusic')->info('Concatenating video segments', [
                            'video_job_id' => $this->videoJob->id
                        ]);
                        $videoProcessor->concatVideos($videoChunks, $absoluteVideoPath);

                    } catch (\Exception $e) {
                        Log::channel('snapmusic')->error('Chunk processing failed', ['error' => $e->getMessage()]);
                        throw $e;
                    } finally {
                        // Cleanup chunks directory
                        if (isset($chunkDir) && File::exists($chunkDir)) {
                            File::deleteDirectory($chunkDir);
                        }
                        // Cleanup resized image if it exists
                        if (strpos($imagePath, 'resized_') !== false && file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                } else {
                    // Large image but small audio, process normally
                    $videoProcessor->generateVideo($imagePath, $audioPath, $absoluteVideoPath);
                    
                    // Cleanup resized image
                    if (strpos($imagePath, 'resized_') !== false && file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            } else {
                // Normal processing for small files
                $videoProcessor->generateVideo($imagePath, $audioPath, $absoluteVideoPath);
            }

            // Generate Thumbnail
            // Since the video is just a static image with audio, we can simply copy the original uploaded image.
            // This avoids FFmpeg frame extraction errors on certain servers and is significantly faster.
            $originalExtension = File::extension($this->videoJob->image_path) ?: 'jpg';
            $thumbnailFileName = 'thumb_' . $this->videoJob->id . '_' . time() . '.' . $originalExtension;
            $thumbnailPath = 'videos/thumbnails/' . $thumbnailFileName;
            $absoluteThumbnailPath = Storage::path($thumbnailPath);
            
            // Ensure thumbnails directory exists
            Storage::makeDirectory('videos/thumbnails');

            try {
                $originalImageSrc = Storage::path($this->videoJob->image_path);
                
                // For a true thumbnail we could resize, but for SnapMusic just copying the original is fine 
                // and avoids memory/FFmpeg issues entirely.
                File::copy($originalImageSrc, $absoluteThumbnailPath);
                $this->videoJob->update(['thumbnail_path' => $thumbnailPath]);
                
            } catch (\Exception $e) {
                // Fallback to FFmpeg if copy fails for some unexpected reason
                Log::channel('snapmusic')->warning('Image copy failed, falling back to FFmpeg for thumbnail', [
                    'error' => $e->getMessage()
                ]);
                
                if ($videoProcessor->generateThumbnail($absoluteVideoPath, $absoluteThumbnailPath)) {
                    $this->videoJob->update(['thumbnail_path' => $thumbnailPath]);
                } else {
                    Log::channel('snapmusic')->warning('Thumbnail generation failed', [
                        'video_job_id' => $this->videoJob->id,
                    ]);
                }
            }

            // Mark job as completed
            $this->videoJob->markAsCompleted($videoPath);

            Log::channel('snapmusic')->info('Video processing completed', [
                'video_job_id' => $this->videoJob->id,
                'output_path' => $videoPath,
            ]);

            // Delete source files after successful processing (original files)
            // Note: $imagePath might be the resized one, so we need to ensure we delete the ORIGINAL source files
            // The logic below uses $this->videoJob->image_path which is stored in DB, so it's correct.
            $originalImagePath = Storage::path($this->videoJob->image_path);
            $originalAudioPath = Storage::path($this->videoJob->audio_path);
            $videoProcessor->deleteSourceFiles($originalImagePath, $originalAudioPath);

        } catch (\Exception $e) {
            // Mark job as failed
            $this->videoJob->markAsFailed('Something went wrong');

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
        $this->videoJob->markAsFailed('Something went wrong');

        Log::channel('snapmusic')->error('JOB_FAILED: Video job permanently failed', [
            'video_job_id' => $this->videoJob->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
