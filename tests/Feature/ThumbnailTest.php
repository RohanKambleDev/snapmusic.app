<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VideoJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ThumbnailTest extends TestCase
{
    use RefreshDatabase;

    public function test_thumbnail_route_returns_image_for_completed_job()
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a dummy thumbnail file
        $thumbnailPath = 'videos/thumbnails/test_thumb.jpg';
        Storage::put($thumbnailPath, 'dummy image content');

        $videoJob = VideoJob::create([
            'user_id' => $user->id,
            'image_path' => 'uploads/test.jpg',
            'audio_path' => 'uploads/test.mp3',
            'video_path' => 'videos/test.mp4',
            'thumbnail_path' => $thumbnailPath,
            'status' => 'completed',
        ]);

        $response = $this->get(route('make-a-video.thumbnail', $videoJob));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type'); // Should identify as a file
    }

    public function test_thumbnail_route_returns_404_if_thumbnail_missing()
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $this->actingAs($user);

        $videoJob = VideoJob::create([
            'user_id' => $user->id,
            'image_path' => 'uploads/test.jpg',
            'audio_path' => 'uploads/test.mp3',
            'status' => 'completed',
            // No thumbnail path
        ]);

        $response = $this->get(route('make-a-video.thumbnail', $videoJob));

        $response->assertStatus(404);
    }

    public function test_cannot_access_others_thumbnail()
    {
        Storage::fake('local');

        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $thumbnailPath = 'videos/thumbnails/test_thumb.jpg';
        Storage::put($thumbnailPath, 'dummy image content');

        $videoJob = VideoJob::create([
            'user_id' => $owner->id,
            'image_path' => 'uploads/test.jpg',
            'audio_path' => 'uploads/test.mp3',
            'thumbnail_path' => $thumbnailPath,
            'status' => 'completed',
        ]);

        $this->actingAs($otherUser);

        $response = $this->get(route('make-a-video.thumbnail', $videoJob));

        $response->assertStatus(403);
    }
}
