<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HowItWorksController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UseCaseController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/use-cases', [UseCaseController::class, 'index'])->name('use-case.index');
Route::get('/how-it-works', [HowItWorksController::class, 'index'])->name('how-it-works.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/{videoJob}', [DashboardController::class, 'show'])->name('dashboard.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Video routes
    Route::get('/make-a-video', [VideoController::class, 'index'])->name('make-a-video.index');
    Route::post('/make-a-video/upload', [VideoController::class, 'upload'])->name('make-a-video.upload');
    Route::get('/make-a-video/{videoJob}/status', [VideoController::class, 'status'])->name('make-a-video.status');
    Route::post('/make-a-video/{videoJob}/notify-completion', [VideoController::class, 'notifyCompletion'])->name('make-a-video.notify-completion');
    Route::get('/make-a-video/{videoJob}/download', [VideoController::class, 'download'])->name('make-a-video.download');
    Route::get('/make-a-video/{videoJob}/stream', [VideoController::class, 'stream'])->name('make-a-video.stream');
    Route::get('/make-a-video/{videoJob}/thumbnail', [VideoController::class, 'thumbnail'])->name('make-a-video.thumbnail');
    Route::delete('/make-a-video/{videoJob}', [VideoController::class, 'destroy'])->name('make-a-video.destroy');
});

require __DIR__ . '/auth.php';