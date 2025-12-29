<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Illuminate\Http\Request $request) {
    $query = auth()->user()->videoJobs()->latest();

    if ($request->has('date')) {
        $query->whereDate('created_at', $request->date);
    }

    $jobs = $query->paginate(10);

    return view('dashboard', compact('jobs'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Video routes
    Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
    Route::post('/videos/upload', [VideoController::class, 'upload'])->name('videos.upload');
    Route::get('/videos/{videoJob}/status', [VideoController::class, 'status'])->name('videos.status');
    Route::get('/videos/{videoJob}/download', [VideoController::class, 'download'])->name('videos.download');
    Route::get('/videos/{videoJob}/stream', [VideoController::class, 'stream'])->name('videos.stream');
    Route::delete('/videos/{videoJob}', [VideoController::class, 'destroy'])->name('videos.destroy');
});

require __DIR__.'/auth.php';
