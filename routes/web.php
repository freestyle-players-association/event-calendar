<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index'])->name('home');
Route::resource('events', EventController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
Route::get('/events/{event}/{slug?}', [EventController::class, 'show'])
    ->name('events.show');

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin')
    ->middleware(AdminMiddleware::class);

Route::delete('/admin/events/{event}/destroy', [AdminController::class, 'destroy'])
    ->name('admin.events.destroy')
    ->middleware(AdminMiddleware::class);

Route::get('/test-email', function () {
    Mail::raw('This is a test email using our Exchange server.', function ($message) {
        // get email from get parameter
        $message->to(request('email'))->subject('Test Email');
    });

    return 'Test email sent!';
});

require __DIR__.'/auth.php';
