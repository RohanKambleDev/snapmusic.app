<?php

namespace Tests\Feature;

use App\Jobs\ProcessVideoJob;
use App\Models\User;
use App\Models\VideoJob;
use App\Services\VideoProcessingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LoggingTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_processing_failure_is_logged_to_snapmusic_channel(): void
    {
        Storage::fake('local');
        
        // We need to spy on the log to ensure it's called
        Log::shouldReceive('channel')->with('snapmusic')->andReturnSelf();
        Log::shouldReceive('info')->andReturnNull(); // Ignore info logs
        Log::shouldReceive('error')->once()->withArgs(function ($message, $context) {
            return $message === 'FFMPEG_PROC_ERR: Video processing failed' &&
                   $context['error'] === 'Processing failed';
        });

        $user = User::factory()->create();
        $videoJob = VideoJob::create([
            'user_id' => $user->id,
            'image_path' => 'test.jpg',
            'audio_path' => 'test.mp3',
            'status' => 'pending',
        ]);

        $mockService = \Mockery::mock(VideoProcessingService::class);
        $mockService->shouldReceive('getAudioDuration')->andReturn(10);
        $mockService->shouldReceive('generateVideo')->andThrow(new \Exception('Processing failed'));
        // We don't expect deleteSourceFiles to be called on failure in the current logic?
        // Wait, looking at the code:
        // catch block happens before deleteSourceFiles.
        
        $job = new ProcessVideoJob($videoJob);
        
        try {
            $job->handle($mockService);
        } catch (\Exception $e) {
            // Expected
        }
    }

    public function test_job_permanent_failure_is_logged_to_snapmusic_channel(): void
    {
        Log::shouldReceive('channel')->with('snapmusic')->andReturnSelf();
        Log::shouldReceive('error')->once()->withArgs(function ($message, $context) {
            return str_contains($message, 'JOB_FAILED');
        });

        $user = User::factory()->create();
        $videoJob = VideoJob::create([
            'user_id' => $user->id,
            'image_path' => 'test.jpg',
            'audio_path' => 'test.mp3',
            'status' => 'pending',
        ]);

        $job = new ProcessVideoJob($videoJob);
        $job->failed(new \Exception('Permanent failure'));
    }
}
