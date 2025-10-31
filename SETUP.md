# SnapMusic - Video Generator Setup Guide

A secure Laravel-based web application that allows authenticated users to upload media files (images and audio) and generates video content dynamically by merging them together.

## Features

- User authentication (Laravel Breeze)
- Upload image (JPG/PNG) and audio (MP3/WAV) files
- File validation (max 10MB each)
- Async video processing using Laravel Queues
- FFmpeg integration for video generation
- Real-time job status tracking
- Video download and streaming
- Automatic cleanup of source files after processing
- User-specific video management

## Tech Stack

- **Backend**: PHP 8.x + Laravel 11.x
- **Database**: SQLite
- **Media Processing**: FFmpeg
- **Queue System**: Database driver
- **Frontend**: Blade templates + Tailwind CSS
- **Authentication**: Laravel Breeze

## Prerequisites

Before you begin, ensure you have the following installed:

1. **PHP 8.1 or higher**
   ```bash
   php -v
   ```

2. **Composer**
   ```bash
   composer --version
   ```

3. **Node.js & NPM** (for asset compilation)
   ```bash
   node -v
   npm -v
   ```

4. **FFmpeg** (required for video processing)

   **macOS:**
   ```bash
   brew install ffmpeg
   ```

   **Ubuntu/Debian:**
   ```bash
   sudo apt update
   sudo apt install ffmpeg
   ```

   **Windows:**
   Download from https://ffmpeg.org/download.html

   **Verify installation:**
   ```bash
   ffmpeg -version
   ```

## Installation Steps

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Environment Configuration

The `.env` file is already configured with SQLite. Verify these settings:

```env
DB_CONNECTION=sqlite
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Run Migrations

```bash
php artisan migrate
```

This will create:
- Users table (from Breeze)
- Video jobs table
- Cache table
- Jobs queue table

### 5. Create Storage Link

```bash
php artisan storage:link
```

### 6. Build Frontend Assets

```bash
npm run build
# or for development with hot reload:
npm run dev
```

## Running the Application

### 1. Start the Development Server

```bash
php artisan serve
```

The application will be available at: http://localhost:8000

### 2. Start the Queue Worker

**IMPORTANT**: In a separate terminal, run the queue worker to process video jobs:

```bash
php artisan queue:work --tries=3
```

The queue worker processes video generation jobs asynchronously. Without it, uploaded videos will remain in "pending" status.

**For production**, consider using a process manager like Supervisor to keep the queue worker running.

## Usage

### 1. Register an Account

1. Navigate to http://localhost:8000
2. Click "Register"
3. Create your account

### 2. Upload Media Files

1. Click "Video Generator" in the navigation
2. Select an image file (JPG/PNG, max 10MB)
3. Select an audio file (MP3/WAV, max 10MB)
4. Click "Upload & Generate Video"

### 3. Track Progress

The page will automatically refresh every 10 seconds to show updated job status:
- **Pending**: Job is queued
- **Processing**: Video is being generated
- **Completed**: Video is ready for download
- **Failed**: An error occurred (hover over "Error" to see details)

### 4. Download/Preview Videos

Once a video is completed, you can:
- Click "Download" to save the MP4 file
- Click "Preview" to watch it in your browser
- Click "Delete" to remove the video

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── VideoController.php       # Handles upload, download, stream, delete
│   └── Requests/
│       └── UploadMediaRequest.php    # File upload validation
├── Jobs/
│   └── ProcessVideoJob.php          # Async video processing job
├── Models/
│   ├── User.php                      # User model with videoJobs relationship
│   └── VideoJob.php                  # Video job model
└── Services/
    └── VideoProcessingService.php    # FFmpeg wrapper service

database/
└── migrations/
    └── *_create_video_jobs_table.php # Video jobs schema

resources/
└── views/
    └── videos/
        └── index.blade.php           # Upload form + job list

routes/
└── web.php                           # Application routes
```

## Database Schema

### video_jobs table

| Column        | Type      | Description                           |
|---------------|-----------|---------------------------------------|
| id            | integer   | Primary key                           |
| user_id       | integer   | Foreign key to users table            |
| image_path    | string    | Storage path to uploaded image        |
| audio_path    | string    | Storage path to uploaded audio        |
| video_path    | string    | Storage path to generated video       |
| status        | enum      | pending/processing/completed/failed   |
| error_message | text      | Error details if failed               |
| duration      | integer   | Audio/video duration in seconds       |
| created_at    | timestamp | Job creation time                     |
| updated_at    | timestamp | Last update time                      |

## API Routes

All routes require authentication (`auth` middleware):

| Method | Route                      | Description                    |
|--------|----------------------------|--------------------------------|
| GET    | /videos                    | List user's video jobs         |
| POST   | /videos/upload             | Upload image + audio           |
| GET    | /videos/{id}/status        | Get job status (JSON)          |
| GET    | /videos/{id}/download      | Download generated video       |
| GET    | /videos/{id}/stream        | Stream video for preview       |
| DELETE | /videos/{id}               | Delete video and source files  |

## Queue Configuration

The application uses the database queue driver (configured in `.env`):

```env
QUEUE_CONNECTION=database
```

### Queue Worker Commands

**Start worker:**
```bash
php artisan queue:work
```

**Start worker with specific options:**
```bash
php artisan queue:work --tries=3 --timeout=600
```

**Failed jobs:**
```bash
# List failed jobs
php artisan queue:failed

# Retry all failed jobs
php artisan queue:retry all

# Retry specific job
php artisan queue:retry {job-id}
```

## Video Processing Details

The FFmpeg command used for video generation:

```bash
ffmpeg -loop 1 -i {image} -i {audio} \
  -c:v libx264 -tune stillimage \
  -c:a aac -b:a 192k \
  -pix_fmt yuv420p -shortest \
  -y {output.mp4}
```

**Parameters:**
- `-loop 1`: Loop the static image
- `-tune stillimage`: Optimize encoding for still images
- `-c:v libx264`: Use H.264 video codec
- `-c:a aac`: Use AAC audio codec
- `-b:a 192k`: Audio bitrate 192 kbps
- `-pix_fmt yuv420p`: Pixel format for broad compatibility
- `-shortest`: End video when audio ends

## Troubleshooting

### Videos stay in "Pending" status

**Solution**: Make sure the queue worker is running:
```bash
php artisan queue:work
```

### "FFmpeg is not installed" error

**Solution**: Install FFmpeg using the instructions in the Prerequisites section.

### File upload fails

**Possible causes:**
1. File size exceeds 10MB
2. Wrong file format
3. PHP upload limits too low

**Solution**: Check PHP configuration:
```bash
# Check current limits
php -i | grep upload_max_filesize
php -i | grep post_max_size

# Edit php.ini if needed:
upload_max_filesize = 10M
post_max_size = 10M
```

### Video generation fails

**Check logs:**
```bash
tail -f storage/logs/laravel.log
```

Common issues:
- FFmpeg not in PATH
- Insufficient disk space
- File permission issues

### Permission errors

**Solution**: Set proper permissions:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache  # Linux/Ubuntu
```

## Production Deployment

### 1. Environment Variables

Update `.env` for production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Use a stronger queue driver for production
QUEUE_CONNECTION=redis  # or database
```

### 2. Optimize Application

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
npm run build
```

### 3. Set Up Supervisor (Queue Worker)

Create `/etc/supervisor/conf.d/snapmusic-worker.conf`:

```ini
[program:snapmusic-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/snapmusic/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/snapmusic/storage/logs/worker.log
stopwaitsecs=3600
```

Reload supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start snapmusic-worker:*
```

### 4. Security Checklist

- [ ] Set strong `APP_KEY`
- [ ] Configure proper file permissions
- [ ] Enable HTTPS
- [ ] Set up CSRF protection (enabled by default)
- [ ] Configure rate limiting for uploads
- [ ] Set up regular backups
- [ ] Monitor disk space for uploaded files

## Optional Enhancements

The following features can be added in the future:

1. **Progress Bar**: Real-time job progress using WebSockets
2. **Email Notifications**: Notify users when video is ready
3. **Batch Uploads**: Allow multiple image/audio pairs at once
4. **Admin Dashboard**: View all uploads across users
5. **Cloud Storage**: S3/Cloudflare R2 integration
6. **Video Thumbnails**: Generate preview thumbnails
7. **Custom Video Settings**: Allow users to set resolution, bitrate, etc.

## Support

For issues or questions:
1. Check the troubleshooting section
2. Review Laravel logs: `storage/logs/laravel.log`
3. Check queue failed jobs: `php artisan queue:failed`

## License

This project is open-source software.
