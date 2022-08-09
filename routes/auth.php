<?php

use App\Versions\V1\Http\Controllers\Api\Auth\AuthController;
use App\Versions\V1\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Versions\V1\Http\Controllers\Api\Auth\LogoutController;
use App\Versions\V1\Http\Controllers\Api\Auth\RegisterController;
use App\Versions\V1\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Versions\V1\Http\Controllers\Api\Auth\VerificationController;
use App\Versions\V1\Http\Controllers\Api\ProfileController;

Route::get('profile', [ProfileController::class, 'show'])
    ->name('profile');

Route::post('login', [AuthController::class, 'login'])
    ->name('login');

Route::post('refresh', [AuthController::class, 'refresh'])
    ->name('refresh');

Route::post('register', [RegisterController::class, 'register'])
    ->name('register');

Route::post('logout', [LogoutController::class, 'logout'])
    ->name('logout');

Route::get('verify-email/{id}/{hash}', [VerificationController::class, 'verify'])
    ->name('verification.verify');

Route::post('verify-email/resend', [VerificationController::class, 'resend'])
    ->name('verification.resend');

Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::post('reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.reset');
