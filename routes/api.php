<?php

use App\Enums\CommentableTypeEnum;
use App\Versions\V1\Http\Controllers\Api\BookmarksController;
use App\Versions\V1\Http\Controllers\Api\ChapterController;
use App\Versions\V1\Http\Controllers\Api\CommentController;
use App\Versions\V1\Http\Controllers\Api\MangaController;
use App\Versions\V1\Http\Controllers\Api\TeamableChapterController;
use App\Versions\V1\Http\Controllers\Api\TeamableController;
use App\Versions\V1\Http\Controllers\Api\TeamController;
use App\Versions\V1\Http\Controllers\Api\TeamInvitationController;
use App\Versions\V1\Http\Controllers\Api\TeamMemberController;
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


    /**
     * Teams
     */

    Route::get('/teams', [TeamController::class, 'index']);
    Route::post('/teams', [TeamController::class, 'store']);
    Route::get('/teams/{team}', [TeamController::class, 'show']);
    Route::put('/teams/{team}', [TeamController::class, 'update']);
    Route::delete('/teams/{team}', [TeamController::class, 'destroy']);
    Route::post('/teams/{team}/members/{user}', [TeamMemberController::class, 'store']);
    Route::put('/teams/{team}/members/{user}', [TeamMemberController::class, 'update']);
    Route::delete('/teams/{team}/members/{user}', [TeamMemberController::class, 'destroy']);

    Route::get('/team-invitations/{invitation}', [TeamInvitationController::class, 'accept']);

    Route::delete('/team-invitations/{invitation}', [TeamInvitationController::class, 'destroy']);

    /*
     * Manga
     */
    Route::apiResource('manga', MangaController::class);

    Route::get('/bookmarks', [BookmarksController::class, 'index']);

    /*
     * Chapter
     */
    Route::get('/manga/{manga}/chapter', [ChapterController::class, 'index']);
    Route::get('/manga/{manga}/chapter/{chapterOrder}', [ChapterController::class, 'show']);

    Route::get('/teams/{team}/teamable', [TeamableController::class, 'index']);
    Route::get('/teams/{team}/teamable/{model}/{id}', [TeamableController::class, 'show']);
    Route::post('/teams/{team}/teamable/{model}/{id}', [TeamableController::class, 'store']);
    Route::delete('/teams/{team}/teamable/{model}/{id}', [TeamableController::class, 'destroy']);

    Route::get('/teams/{team}/teamable/manga/{manga:id}/chapter', [TeamableChapterController::class, 'index']);
    Route::post('/teams/{team}/teamable/manga/{manga:id}/chapter', [TeamableChapterController::class, 'store']);
    Route::patch('/teams/{team}/teamable/manga/{manga:id}/chapter/{chapter}', [TeamableChapterController::class, 'update']);
    Route::delete('/teams/{team}/teamable/manga/{manga:id}/chapter/{chapter}', [TeamableChapterController::class, 'destroy']);

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
