<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Jobs\ProcessVideoJob;

class VideoUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class);
    }

    public function test_user_can_upload_video_assets()
    {
        Storage::fake('local');
        Queue::fake();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/make-a-video/upload', [
            'image' => UploadedFile::fake()->image('image.jpg'),
            'audio' => UploadedFile::fake()->create('audio.mp3', 1000, 'audio/mpeg'),
        ]);

        $response->assertRedirect(route('make-a-video.index'));
        $response->assertSessionHas('success');

        // Assert job was pushed to queue
        Queue::assertPushed(ProcessVideoJob::class);

        // Assert files were stored
        // Note: The actual path will vary because of hashing, so we check if *any* file exists in the directory
        // or check the database record.
        $this->assertDatabaseHas('video_jobs', [
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
    }

    public function test_upload_validates_file_types()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/make-a-video/upload', [
            'image' => UploadedFile::fake()->create('document.pdf', 100),
            'audio' => UploadedFile::fake()->image('image.jpg'),
        ]);

        $response->assertSessionHasErrors(['image', 'audio']);
    }
}