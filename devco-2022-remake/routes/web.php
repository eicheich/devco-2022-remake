<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RepostController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\SearchController;
use App\Models\Update;

Route::get('/', function () {
    $updates = Update::latest()->take(2)->get();
    return view('welcome', compact('updates'));
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [RegistrationController::class, 'showEmailForm'])->name('register.email');
Route::post('/register/send-otp', [RegistrationController::class, 'sendOtp'])->name('register.send-otp');
Route::get('/register/verify', [RegistrationController::class, 'showVerifyForm'])->name('register.verify');
Route::post('/register/verify', [RegistrationController::class, 'verifyOtp']);
Route::get('/register/password', [RegistrationController::class, 'showPasswordForm'])->name('register.password');
Route::post('/register/complete', [RegistrationController::class, 'completeRegistration'])->name('register.complete');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password routes (tidak perlu login)
Route::get('/forgot-password', [PasswordController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/forgot-password/send-otp', [PasswordController::class, 'sendResetOtp'])->name('password.reset.send-otp');
Route::get('/forgot-password/verify', [PasswordController::class, 'showResetVerifyForm'])->name('password.reset.verify');
Route::post('/forgot-password/verify', [PasswordController::class, 'verifyResetOtp']);
Route::get('/forgot-password/new', [PasswordController::class, 'showResetNewForm'])->name('password.reset.new');
Route::post('/forgot-password/update', [PasswordController::class, 'resetPassword'])->name('password.reset.update');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::resource('posts', PostController::class)->only(['store', 'edit', 'update', 'destroy']);
    Route::get('/updates', [UpdateController::class, 'index'])->name('updates.index');
    Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user}', [FollowController::class, 'destroy'])->name('follow.destroy');
    Route::post('/likes/{post}', [LikeController::class, 'toggle'])->name('likes.toggle');
    Route::post('/comments/{post}', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/reposts/{post}', [RepostController::class, 'store'])->name('reposts.store');
    Route::post('/notifications/mark-read', function () {
        \App\Models\Notification::where('user_id', auth()->id())->unread()->update(['read_at' => now()]);
        return back();
    })->name('notifications.markRead');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

    // Change Password routes (perlu login)
    Route::get('/change-password', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/change-password/send-otp', [PasswordController::class, 'sendChangeOtp'])->name('password.change.send-otp');
    Route::get('/change-password/verify', [PasswordController::class, 'showChangeVerifyForm'])->name('password.change.verify');
    Route::post('/change-password/verify', [PasswordController::class, 'verifyChangeOtp'])->name('password.change.verify');
    Route::get('/change-password/new', [PasswordController::class, 'showChangeNewForm'])->name('password.change.new');
    Route::post('/change-password/update', [PasswordController::class, 'updatePassword'])->name('password.change.update');
});

// Admin-only routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('updates', UpdateController::class)->except(['index']);
});
