# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

SnapMusic is a Laravel-based web application that generates videos by combining static images with audio files using FFmpeg. Users upload an image (JPG/PNG) and audio file (MP3/WAV), and the system asynchronously generates an MP4 video where the image is displayed for the duration of the audio.

**Tech Stack**: Laravel 12, PHP 8.2+, SQLite, FFmpeg, Tailwind CSS, Alpine.js, Vite

## Development Commands

### Initial Setup
```bash
# Install dependencies and set up the project
composer install
npm install

# Set up environment and database
php artisan key:generate
php artisan migrate
php artisan storage:link

# Build frontend assets
npm run build          # Production
npm run dev            # Development with hot reload
```

### Running the Application

**CRITICAL**: The queue worker MUST be running for video processing to work. Without it, jobs remain in "pending" status forever.

```bash
# Start development server, queue worker, logs, and Vite in parallel
composer dev

# Or manually in separate terminals:
php artisan serve                    # Web server (localhost:8000)
php artisan queue:work --tries=3     # Queue worker (REQUIRED)
npm run dev                          # Frontend assets
```

### Testing
```bash
composer test                        # Run PHPUnit tests
php artisan queue:failed             # List failed jobs
php artisan queue:retry all          # Retry all failed jobs
```

## Architecture

### Request Flow

**Video Upload Flow**:
1. User uploads files via `POST /videos/upload` → `VideoController@upload`
2. Files validated by `UploadMediaRequest` (max 10MB each, specific MIME types)
3. Files stored in `storage/app/uploads/{images|audio}/`
4. `VideoJob` model created with status "pending"
5. `ProcessVideoJob` dispatched to queue
6. Worker picks up job, marks as "processing"
7. `VideoProcessingService` calls FFmpeg to generate video
8. On success: status → "completed", source files deleted, video saved to `storage/app/videos/`
9. On failure: status → "failed", error message stored, job retried (up to 3 attempts)

**Real-Time Status Updates**:
- Frontend polls `GET /videos/{id}/status` every 3 seconds via AJAX
- Returns JSON with current job status
- UI updates dynamically without page refresh
- Polling stops when job completes or fails

### Key Components

**VideoController** (`app/Http/Controllers/VideoController.php`):
- Handles all video operations (upload, status, download, stream, delete)
- Authorization: Users can only access their own videos
- Route model binding used for automatic VideoJob lookup

**ProcessVideoJob** (`app/Jobs/ProcessVideoJob.php`):
- Queued job that processes video generation
- Timeout: 10 minutes
- Retries: 3 attempts on failure
- Automatically deletes source files after successful processing
- Status transitions: pending → processing → completed/failed

**VideoProcessingService** (`app/Services/VideoProcessingService.php`):
- Wrapper for FFmpeg operations
- Main method: `generateVideo($imagePath, $audioPath, $outputPath)`
- Uses `ffprobe` to get audio duration
- Verifies FFmpeg installation before processing

**VideoJob Model** (`app/Models/VideoJob.php`):
- Represents a video generation job
- Belongs to User
- Status helpers: `isPending()`, `isProcessing()`, `isCompleted()`, `isFailed()`
- State changers: `markAsProcessing()`, `markAsCompleted($path)`, `markAsFailed($error)`

### FFmpeg Command

The core FFmpeg command (from `VideoProcessingService.php:55`):

```bash
ffmpeg -loop 1 -i {image} -i {audio} \
  -vf "scale=trunc(iw/2)*2:trunc(ih/2)*2" \
  -c:v libx264 -tune stillimage \
  -c:a aac -b:a 192k \
  -pix_fmt yuv420p \
  -shortest -y {output.mp4}
```

**Critical filter**: `-vf "scale=trunc(iw/2)*2:trunc(ih/2)*2"` ensures dimensions are divisible by 2 (required by H.264 encoder). This handles images with odd dimensions automatically.

### Database Schema

**video_jobs table**:
- `id`: Primary key
- `user_id`: Foreign key to users
- `image_path`: Storage path to uploaded image
- `audio_path`: Storage path to uploaded audio
- `video_path`: Storage path to generated video (null until completed)
- `status`: Enum (pending, processing, completed, failed)
- `error_message`: Error details if failed
- `duration`: Audio/video duration in seconds
- `created_at`, `updated_at`: Timestamps

**Indexes**:
- `idx_video_jobs_user_id` on user_id
- `idx_video_jobs_status` on status

### File Storage Structure

```
storage/app/
├── uploads/
│   ├── images/          # Uploaded images (deleted after processing)
│   └── audio/           # Uploaded audio (deleted after processing)
└── videos/              # Generated videos (kept until user deletes)
```

**Storage disk**: Local filesystem (configurable via `FILESYSTEM_DISK` in .env)

## Common Development Tasks

### Adding New Video Processing Options

To modify FFmpeg parameters, edit `app/Services/VideoProcessingService.php:55`. Key parameters:
- `-c:v libx264`: Video codec (H.264)
- `-tune stillimage`: Optimization for static images
- `-c:a aac`: Audio codec
- `-b:a 192k`: Audio bitrate (192kbps)
- `-pix_fmt yuv420p`: Pixel format for compatibility

### Debugging Queue Jobs

```bash
# View Laravel logs (includes FFmpeg output)
tail -f storage/logs/laravel.log

# Check failed jobs
php artisan queue:failed

# Retry specific failed job
php artisan queue:retry {job-id}

# Clear all failed jobs
php artisan queue:flush
```

### Testing FFmpeg Integration

Verify FFmpeg is installed and accessible:
```bash
ffmpeg -version    # Should show version 8.0+
ffprobe -version   # Should show ffprobe version
```

### Authorization Pattern

All video operations verify ownership:
```php
if ($videoJob->user_id !== auth()->id()) {
    abort(403, 'Unauthorized access');
}
```

This pattern is used in: `status()`, `download()`, `stream()`, `destroy()`

## Important Notes

- **Queue Worker**: The queue worker must be running for any video processing to occur. Use `composer dev` or run `php artisan queue:work --tries=3` in a separate terminal.

- **FFmpeg Dependency**: The application will not work without FFmpeg installed. The service checks for FFmpeg availability before processing.

- **File Cleanup**: Source files (image and audio) are automatically deleted after successful video generation to save disk space. Only the final video is retained.

- **Real-Time Updates**: The frontend uses JavaScript polling (every 3 seconds) to update job status. This is implemented in `resources/views/videos/index.blade.php` (lines 186-288). Consider WebSockets for true real-time updates in the future.

- **Security**: File upload validation is handled by `UploadMediaRequest`. MIME type checking prevents malicious uploads. Files are stored in private storage and served through authenticated routes.

- **Status Endpoint**: The `/videos/{id}/status` endpoint returns JSON and is designed for AJAX polling. It's separate from the main view to enable efficient status checking.

- **Composer Scripts**: The project includes custom composer scripts:
  - `composer dev`: Runs server, queue, logs, and Vite concurrently
  - `composer setup`: Full setup from scratch
  - `composer test`: Run PHPUnit tests
