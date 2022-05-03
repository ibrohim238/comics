<?php

use App\Versions\V1\Http\Controllers\Api\Admin\UserController;

Route::get('users', [UserController::class, 'index']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::post('users/{user}/update', [UserController::class, 'update']);
