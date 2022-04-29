<?php

use App\Enums\CommentableTypeEnum;
use App\Versions\V1\Http\Controllers\Api\BookmarksController;
use App\Versions\V1\Http\Controllers\Api\ChapterController;
use App\Versions\V1\Http\Controllers\Api\CommentController;
use App\Versions\V1\Http\Controllers\Api\FilterableController;
use App\Versions\V1\Http\Controllers\Api\FilterController;
use App\Versions\V1\Http\Controllers\Api\MangaController;
use App\Versions\V1\Http\Controllers\Api\TeamableController;
use App\Versions\V1\Http\Controllers\Api\TeamController;
use App\Versions\V1\Http\Controllers\Api\TeamInvitationController;
use App\Versions\V1\Http\Controllers\Api\TeamMangaChapterController;
use App\Versions\V1\Http\Controllers\Api\TeamMangaController;
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

    Route::post('/teams/{team}/attach/{model}/{id}', [TeamableController::class, 'attach']);
    Route::post('/teams/{team}/detach/{model}/{id}', [TeamableController::class, 'detach']);

    /*
     * Manga
     */
    Route::apiResource('manga', MangaController::class)->parameter('manga', 'manga:slug');

    Route::resource('filters', FilterController::class);
    Route::post('/filters/{filter}/attach/{model}/{id}', [FilterableController::class, 'attach']);
    Route::post('/filters/{filter}/detach/{model}/{id', [FilterableController::class, 'detach']);

    /*
     * Bookmarks
     */
    Route::get('/bookmarks', [BookmarksController::class, 'index']);
    Route::post('/bookmarks/attach/{manga}', [BookmarksController::class, 'attach']);
    Route::post('/bookmarks/detach/{manga}', [BookmarksController::class, 'detach']);

    Route::scopeBindings()->group( function () {
        Route::get('/manga/{manga:slug}/chapter', [ChapterController::class, 'index']);
        Route::get('/manga/{manga:slug}/chapter/{chapter:order_column}', [ChapterController::class, 'show']);

        Route::get('/teams/{team}/manga/', [TeamMangaController::class, 'index']);
        Route::get('/teams/{team}/manga/{manga}', [TeamMangaController::class, 'show']);

        Route::get('/teams/{team}/manga/{manga}/chapter', [TeamMangaChapterController::class, 'index']);
        Route::post('/teams/{team}/manga/{manga}/chapter', [TeamMangaChapterController::class, 'store']);
        Route::get('/teams/{team}/manga/{manga}/chapter/{chapter}', [TeamMangaChapterController::class, 'show']);
        Route::patch('/teams/{team}/manga/{manga}/chapter/{chapter}', [TeamMangaChapterController::class, 'update']);
        Route::delete('/teams/{team}/manga/{manga}/chapter/{chapter}', [TeamMangaChapterController::class, 'destroy']);
    });

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
