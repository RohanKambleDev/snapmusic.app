<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class VideoProcessingService
{
    /**
     * Generate a video by combining an image and audio file using FFmpeg
     *
     * @param string $imagePath Absolute path to the image file
     * @param string $audioPath Absolute path to the audio file
     * @param string $outputPath Absolute path for the output video
     * @return bool Success status
     * @throws \Exception
     */
    public function generateVideo(string $imagePath, string $audioPath, string $outputPath): bool
    {
        // Verify FFmpeg is installed
        if (!$this->isFfmpegInstalled()) {
            throw new \Exception('FFmpeg is not installed on this system. Please install FFmpeg to process videos.');
        }

        // Verify input files exist
        if (!file_exists($imagePath)) {
            throw new \Exception("Image file not found: {$imagePath}");
        }

        if (!file_exists($audioPath)) {
            throw new \Exception("Audio file not found: {$audioPath}");
        }

        // Get audio duration
        $duration = $this->getAudioDuration($audioPath);

        if ($duration <= 0) {
            throw new \Exception('Unable to determine audio duration');
        }

        // Build FFmpeg command
        // -loop 1: Loop the image
        // -i: Input file
        // -vf: Video filter to ensure dimensions are divisible by 2 (required by libx264)
        // -c:v libx264: Video codec
        // -tune stillimage: Optimize for still images
        // -c:a aac: Audio codec
        // -b:a 192k: Audio bitrate
        // -pix_fmt yuv420p: Pixel format for compatibility
        // -shortest: End video when audio ends
        // -y: Overwrite output file without asking
        $command = [
            'ffmpeg',
            '-loop', '1',
            '-i', $imagePath,
            '-i', $audioPath,
            '-vf', 'scale=trunc(iw/2)*2:trunc(ih/2)*2',
            '-c:v', 'libx264',
            '-tune', 'stillimage',
            '-c:a', 'aac',
            '-b:a', '192k',
            '-pix_fmt', 'yuv420p',
            '-shortest',
            '-y',
            $outputPath,
        ];

        try {
            $process = new Process($command);
            $process->setTimeout(600); // 10 minutes timeout
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error('FFmpeg process failed', [
                    'error' => $process->getErrorOutput(),
                    'output' => $process->getOutput(),
                ]);
                throw new ProcessFailedException($process);
            }

            // Verify output file was created
            if (!file_exists($outputPath)) {
                throw new \Exception('Video file was not created');
            }

            Log::info('Video generated successfully', [
                'output' => $outputPath,
                'duration' => $duration,
            ]);

            return true;
        } catch (ProcessFailedException $e) {
            Log::error('FFmpeg process failed', [
                'exception' => $e->getMessage(),
            ]);
            throw new \Exception('Video generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate a thumbnail image from the video
     *
     * @param string $videoPath Absolute path to the video file
     * @param string $thumbnailPath Absolute path for the output thumbnail
     * @return bool Success status
     */
    public function generateThumbnail(string $videoPath, string $thumbnailPath): bool
    {
        // Extract frame at 1 second mark (or start if video is shorter)
        // -ss 00:00:01: Seek to 1 second
        // -vframes 1: Output only 1 frame
        $command = [
            'ffmpeg',
            '-y',
            '-i', $videoPath,
            '-ss', '00:00:01',
            '-vframes', '1',
            $thumbnailPath,
        ];

        try {
            $process = new Process($command);
            $process->run();

            if (!$process->isSuccessful()) {
                // If seeking failed (maybe video is < 1s), try grabbing the first frame
                $fallbackCommand = [
                    'ffmpeg',
                    '-y',
                    '-i', $videoPath,
                    '-vframes', '1',
                    $thumbnailPath,
                ];
                $fallbackProcess = new Process($fallbackCommand);
                $fallbackProcess->run();

                if (!$fallbackProcess->isSuccessful()) {
                    Log::error('Thumbnail generation failed', [
                        'error' => $fallbackProcess->getErrorOutput(),
                        'video' => $videoPath,
                    ]);
                    return false;
                }
            }

            return file_exists($thumbnailPath);
        } catch (\Exception $e) {
            Log::error('Thumbnail generation exception', [
                'exception' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Get the duration of an audio file in seconds
     *
     * @param string $audioPath Absolute path to the audio file
     * @return float Duration in seconds
     */
    public function getAudioDuration(string $audioPath): float
    {
        $command = [
            'ffprobe',
            '-v', 'error',
            '-show_entries', 'format=duration',
            '-of', 'default=noprint_wrappers=1:nokey=1',
            $audioPath,
        ];

        try {
            $process = new Process($command);
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error('FFprobe process failed', [
                    'error' => $process->getErrorOutput(),
                ]);
                return 0;
            }

            return (float) trim($process->getOutput());
        } catch (\Exception $e) {
            Log::error('Failed to get audio duration', [
                'exception' => $e->getMessage(),
            ]);
            return 0;
        }
    }

    /**
     * Check if FFmpeg is installed and available
     *
     * @return bool
     */
    public function isFfmpegInstalled(): bool
    {
        try {
            $process = new Process(['ffmpeg', '-version']);
            $process->run();
            return $process->isSuccessful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Delete source files (image and audio)
     *
     * @param string $imagePath
     * @param string $audioPath
     * @return void
     */
    public function deleteSourceFiles(string $imagePath, string $audioPath): void
    {
        try {
            if (file_exists($imagePath)) {
                unlink($imagePath);
                Log::info('Deleted source image', ['path' => $imagePath]);
            }

            if (file_exists($audioPath)) {
                unlink($audioPath);
                Log::info('Deleted source audio', ['path' => $audioPath]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to delete source files', [
                'exception' => $e->getMessage(),
                'image' => $imagePath,
                'audio' => $audioPath,
            ]);
        }
    }
}
