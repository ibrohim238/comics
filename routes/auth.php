<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\VerificationController;

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::post('register', [LoginController::class, 'register'])->name('register');

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('email/verify/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

    Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    Route::get('user', [AuthenticationController::class, 'user'])->name('user');

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

});
