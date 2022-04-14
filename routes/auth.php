<?php

use App\Versions\V1\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Versions\V1\Http\Controllers\Api\Auth\LogoutController;
use App\Versions\V1\Http\Controllers\Api\Auth\RegisterController;
use App\Versions\V1\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Versions\V1\Http\Controllers\Api\Auth\VerificationController;

Route::post('logout', [LogoutController::class, 'logout']);

Route::post('register', [RegisterController::class, 'register']);

Route::get('verify-email/{id}/{hash}', [VerificationController::class, 'verify'])
    ->name('verification.verify');

Route::post('verify-email/resend', [VerificationController::class, 'resend'])
    ->name('verification.resend');

Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::post('reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.reset');
