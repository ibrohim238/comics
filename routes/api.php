<?php

use App\Versions\V1\Http\Controllers\Api\ChapterCommentController;
use App\Versions\V1\Http\Controllers\Api\ChapterController;
use App\Versions\V1\Http\Controllers\Api\CommentController;
use App\Versions\V1\Http\Controllers\Api\MangaCommentController;
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

    /* Comments */
    Route::patch('/comments/{comments}', [CommentController::class, 'update']);
    Route::delete('/comments/{comments}', [CommentController::class, 'destroy']);

    Route::group(['prefix' => '/manga/{manga}'], function () {
        /* MangaComments */
        Route::get('/comments', [MangaCommentController::class, 'index']);
        Route::post('/comments', [MangaCommentController::class, 'store']);
        Route::group(['prefix' => '/chapter/{chapter}'], function () {
            /* ChapterComments */
            Route::get('/comments', [ChapterCommentController::class, 'index']);
            Route::post('/comments', [ChapterCommentController::class, 'store']);
        });
    });

    /*
     * Chapter
     */
    Route::apiResource('manga.chapter', ChapterController::class);




});
