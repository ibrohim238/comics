<?php

use App\Enums\CommentableTypeEnum;
use App\Versions\V1\Http\Controllers\Api\ChapterController;
use App\Versions\V1\Http\Controllers\Api\CommentController;
use App\Versions\V1\Http\Controllers\Api\MangaController;
use App\Versions\V1\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    /*
     * Auth
     */
    require ('auth.php');

    /*
     * User
     */
    Route::get('user', [UserController::class, 'show']);

    Route::patch('user', [UserController::class, 'update']);

    Route::delete('user', [UserController::class, 'destroy']);


    /*
     * Manga
     */
    Route::apiResource('manga', MangaController::class);

    /*
     * Chapter
     */
    Route::apiResource('manga.chapter', ChapterController::class);

    /*
     * Comments
     */
    Route::get('/comment/{model}/{id}', [CommentController::class, 'index'])
        ->whereIn('model', CommentableTypeEnum::values())
        ->whereNumber('id');
    Route::post('/comment/{model}/{id}', [CommentController::class, 'store'])
        ->whereIn('model', CommentableTypeEnum::values())
        ->whereNumber('id');

    Route::patch('/comment/{comment}', [CommentController::class, 'update']);
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy']);


});
