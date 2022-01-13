<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Mail\Invitation;
// Route::post('/register', [AdminController::class, 'store']);
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth')->group(function () {
    Route::middleware('is_admin')->prefix('admin')->group(function () {
        Route::post('/send-invitation', [AdminController::class, 'sendInvitationToUser']);
    });
    Route::prefix('user')->group(function () {
        Route::patch('/profile', [UserController::class, 'update']);
        Route::get('/profile', [UserController::class, 'show']);
    });
});

Route::post('/register/{token}', [UserController::class, 'register']);
Route::post('/resend-verification', [UserController::class, 'resendVerification']);
Route::post('/verify', [UserController::class, 'verifyEmail']);



Route::get('test', function () {
    Mail::to('hdk2214@gmail.com')->send(new Invitation('It works!'));
});