# SnapMusic Project Context

## Project Overview
**SnapMusic** is a Laravel-based web application designed to transform static images and audio files into MP4 videos. It leverages a robust queue-based architecture to handle resource-intensive video processing asynchronously using FFmpeg.

**Key Technologies:**
-   **Backend:** PHP 8.2+, Laravel 12
-   **Database:** SQLite (default)
-   **Frontend:** Blade Templates, Tailwind CSS, Alpine.js, Vite
-   **Video Engine:** FFmpeg (via `symfony/process`)
-   **Queue System:** Database driver (default), expandable to Redis

## Architecture & Workflow

1.  **User Interaction:** Users upload an image (JPG/PNG) and an audio file (MP3/WAV).
2.  **Job Dispatch:** The application creates a `VideoJob` record (status: `pending`) and pushes a `ProcessVideoJob` to the queue.
3.  **Async Processing:**
    -   A background worker picks up the job.
    -   `VideoProcessingService` invokes FFmpeg.
    -   **Logic:** The image is resized to have even dimensions (required by H.264) and looped to match the audio's duration.
    -   **Output:** An MP4 file is generated in `storage/app/videos`.
    -   **Cleanup:** Original source files are deleted to save space.
4.  **Real-Time Feedback:** The frontend polls the status endpoint (`/videos/{id}/status`) every 3 seconds to update the UI (Pending -> Processing -> Completed).

## Building and Running

### Prerequisites
-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   FFmpeg (Must be installed and accessible in system PATH)

### Setup Commands
```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
```

### Development Server
The application requires three concurrent processes to function correctly:

1.  **Web Server:** `php artisan serve`
2.  **Queue Worker:** `php artisan queue:work --tries=3` (CRITICAL: Videos will stay "pending" without this)
3.  **Frontend Build:** `npm run dev`

*Convenience Command:* `composer dev` (Runs all the above + logs)

## Directory Structure Highlights

-   `app/Http/Controllers/VideoController.php`: Handles uploads, status polling, and file delivery.
-   `app/Jobs/ProcessVideoJob.php`: Orchestrates the video generation lifecycle.
-   `app/Services/VideoProcessingService.php`: Contains the FFmpeg command construction and execution logic.
-   `app/Models/VideoJob.php`: Eloquent model for video tasks.
-   `storage/screenshots/`: Contains reference images for the UI design (`home.jpg`, `how-it-works.png`, etc.).
-   `storage/app/`: Stores private uploads and generated videos.

## Development Conventions

-   **Code Style:** Follow PSR-12 and standard Laravel conventions.
-   **Authorization:** Always verify resource ownership. Example:
    ```php
    if ($videoJob->user_id !== auth()->id()) {
        abort(403);
    }
    ```
-   **FFmpeg Logic:** When modifying video parameters, ensure the `scale` filter handles odd dimensions to prevent encoding failures: `trunc(iw/2)*2:trunc(ih/2)*2`.
-   **Testing:** Run `composer test` for PHPUnit tests. Monitor `php artisan queue:failed` for background job issues.
