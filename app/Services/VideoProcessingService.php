<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class VideoProcessingService
{
    private string $ytDlpBinary = 'yt-dlp';
    private string $ffmpegBinary = 'ffmpeg';

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

        // Define watermark path
        $watermarkPath = storage_path('app/public/watermark.png');
        $hasWatermark = file_exists($watermarkPath);

        // Build FFmpeg command
        $command = [
            $this->ffmpegBinary,
            '-loop', '1',
            '-i', $imagePath,
            '-i', $audioPath,
        ];

        if ($hasWatermark) {
            $command[] = '-i';
            $command[] = $watermarkPath;

            // Complex filter for watermark
            // [0:v] Scale main video to even dimensions [bg]
            // [2:v][bg] Scale watermark to 20% of background width [wm][bg_ref]
            // [wm] Set opacity to 0.5 [wm_trans]
            // [bg_ref][wm_trans] Overlay at bottom-right with 10px padding
            $filterComplex = '[0:v]scale=trunc(iw/2)*2:trunc(ih/2)*2[bg];' .
                             '[2:v][bg]scale2ref=w=iw*0.2:h=-1[wm][bg_ref];' .
                             '[wm]format=rgba,colorchannelmixer=aa=0.5[wm_trans];' .
                             '[bg_ref][wm_trans]overlay=W-w-10:H-h-10:format=auto';
            
            $command[] = '-filter_complex';
            $command[] = $filterComplex;
        } else {
            // Original simple filter
            $command[] = '-vf';
            $command[] = 'scale=trunc(iw/2)*2:trunc(ih/2)*2';
        }

        // Common output options
        array_push($command,
            '-c:v', 'libx264',
            '-tune', 'stillimage',
            '-c:a', 'aac',
            '-b:a', '192k',
            '-pix_fmt', 'yuv420p',
            '-shortest',
            '-y',
            $outputPath
        );

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
                Log::error('Video file not created despite success exit code', [
                    'output' => $process->getOutput(),
                    'error' => $process->getErrorOutput(),
                    'command' => $process->getCommandLine(),
                ]);
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
            $this->ffmpegBinary,
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
                    $this->ffmpegBinary,
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
     * Split audio file into smaller chunks
     *
     * @param string $audioPath Absolute path to the audio file
     * @param int $segmentDuration Duration of each segment in seconds
     * @param string $outputDir Directory to store segments
     * @return array List of absolute paths to the audio segments
     * @throws \Exception
     */
    public function splitAudio(string $audioPath, int $segmentDuration, string $outputDir): array
    {
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $extension = pathinfo($audioPath, PATHINFO_EXTENSION) ?: 'mp3';

        // Output filename pattern
        $outputPattern = $outputDir . '/audio_part_%03d.' . $extension;

        // ffmpeg -i input.ext -f segment -segment_time 60 -c copy out%03d.ext
        $command = [
            $this->ffmpegBinary,
            '-i', $audioPath,
            '-f', 'segment',
            '-segment_time', (string) $segmentDuration,
            '-c', 'copy',
            $outputPattern,
        ];

        try {
            $process = new Process($command);
            $process->setTimeout(600);
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error('Audio splitting failed', [
                    'error' => $process->getErrorOutput(),
                ]);
                throw new ProcessFailedException($process);
            }

            // Get generated files
            $files = glob($outputDir . '/audio_part_*.' . $extension);
            sort($files); // Ensure correct order

            return $files;
        } catch (ProcessFailedException $e) {
            throw new \Exception('Audio splitting failed: ' . $e->getMessage());
        }
    }

    /**
     * Concatenate multiple video files into one
     *
     * @param array $videoPaths List of absolute paths to video files
     * @param string $outputPath Absolute path for the output video
     * @return bool Success status
     * @throws \Exception
     */
    public function concatVideos(array $videoPaths, string $outputPath): bool
    {
        if (empty($videoPaths)) {
            throw new \Exception('No videos to concatenate');
        }

        // Create a temporary list file for ffmpeg concat demuxer
        $listContent = '';
        foreach ($videoPaths as $path) {
            $listContent .= "file '" . $path . "'\n";
        }

        $listFile = sys_get_temp_dir() . '/ffmpeg_concat_list_' . uniqid() . '.txt';
        file_put_contents($listFile, $listContent);

        // ffmpeg -f concat -safe 0 -i list.txt -c copy output.mp4
        $command = [
            $this->ffmpegBinary,
            '-f', 'concat',
            '-safe', '0',
            '-i', $listFile,
            '-c', 'copy',
            '-y',
            $outputPath,
        ];

        try {
            $process = new Process($command);
            $process->setTimeout(600);
            $process->run();

            // Clean up list file
            if (file_exists($listFile)) {
                unlink($listFile);
            }

            if (!$process->isSuccessful()) {
                Log::error('Video concatenation failed', [
                    'error' => $process->getErrorOutput(),
                ]);
                throw new ProcessFailedException($process);
            }

            return file_exists($outputPath);
        } catch (ProcessFailedException $e) {
            // Clean up list file
            if (file_exists($listFile)) {
                unlink($listFile);
            }
            throw new \Exception('Video concatenation failed: ' . $e->getMessage());
        }
    }

    /**
     * Resize image to a manageable size (e.g. 1920x1080)
     *
     * @param string $imagePath
     * @param string $outputPath
     * @return bool
     */
    public function resizeImage(string $imagePath, string $outputPath): bool
    {
        // ffmpeg -i input.jpg -vf "scale=iw*min(1920/iw\,1080/ih):ih*min(1920/iw\,1080/ih)" output.jpg
        // actually just scale to fit 1920x1080 while keeping aspect ratio
        $command = [
            $this->ffmpegBinary,
            '-i', $imagePath,
            '-vf', 'scale=\'min(1920,iw)\':\'min(1080,ih)\':force_original_aspect_ratio=decrease',
            '-y',
            $outputPath,
        ];

        try {
            $process = new Process($command);
            $process->run();

            return $process->isSuccessful() && file_exists($outputPath);
        } catch (\Exception $e) {
            Log::error('Image resizing failed', ['error' => $e->getMessage()]);
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
        $possiblePaths = [
            'ffmpeg',
            '/opt/homebrew/bin/ffmpeg',
            '/usr/local/bin/ffmpeg',
            '/usr/bin/ffmpeg'
        ];

        foreach ($possiblePaths as $path) {
            try {
                $process = new Process([$path, '-version']);
                $process->run();
                
                if ($process->isSuccessful()) {
                    $this->ffmpegBinary = $path;
                    return true;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return false;
    }

    /**
     * Check if yt-dlp is installed and available
     *
     * @return bool
     */
    public function isYtDlpInstalled(): bool
    {
        $possiblePaths = [
            'yt-dlp',
            '/opt/homebrew/bin/yt-dlp',
            '/usr/local/bin/yt-dlp',
            '/usr/bin/yt-dlp'
        ];

        foreach ($possiblePaths as $path) {
            try {
                $process = new Process([$path, '--version']);
                $process->run();
                
                if ($process->isSuccessful()) {
                    $this->ytDlpBinary = $path;
                    return true;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return false;
    }

    /**
     * Download and trim audio from YouTube
     *
     * @param string $url YouTube URL
     * @param int $startTime Start time in seconds
     * @param int $duration Duration in seconds
     * @param string $outputPath Path to save the audio file
     * @return bool Success status
     * @throws \Exception
     */
    public function downloadYoutubeAudio(string $url, int $startTime, int $duration, string $outputPath): bool
    {
        if (!$this->isYtDlpInstalled()) {
            throw new \Exception('yt-dlp is not installed on this system.');
        }

        if (!$this->isFfmpegInstalled()) {
            throw new \Exception('FFmpeg is not installed on this system.');
        }

        // Get the direct stream URL
        $getUrlProcess = new Process([$this->ytDlpBinary, '-f', 'bestaudio', '-g', $url]);
        $getUrlProcess->setTimeout(60);
        $getUrlProcess->run();

        if (!$getUrlProcess->isSuccessful()) {
            Log::error('yt-dlp failed to get URL', [
                'error' => $getUrlProcess->getErrorOutput(),
                'url' => $url,
                'binary' => $this->ytDlpBinary
            ]);
            throw new \Exception('Failed to fetch YouTube audio stream. Please check the URL.');
        }

        $streamUrl = trim($getUrlProcess->getOutput());

        if (empty($streamUrl)) {
            throw new \Exception('Could not retrieve audio stream URL from YouTube.');
        }

        // Download and trim using ffmpeg
        // -ss before -i is faster (input seeking)
        $command = [
            $this->ffmpegBinary,
            '-ss', (string) $startTime,
            '-i', $streamUrl,
            '-t', (string) $duration,
            '-c:a', 'libmp3lame', // Force MP3 encoding
            '-b:a', '192k',
            '-y',
            $outputPath
        ];

        try {
            $process = new Process($command);
            $process->setTimeout(300); // 5 minutes
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error('FFmpeg failed to download/trim YouTube audio', [
                    'error' => $process->getErrorOutput(),
                    'command' => $process->getCommandLine()
                ]);
                throw new ProcessFailedException($process);
            }

            return file_exists($outputPath);
        } catch (ProcessFailedException $e) {
            throw new \Exception('Failed to process YouTube audio: ' . $e->getMessage());
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
