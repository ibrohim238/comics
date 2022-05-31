<?php

use App\Enums\CommentableTypeEnum;
use App\Enums\LikeableTypeEnum;
use App\Enums\RatingableTypeEnum;
use App\Versions\V1\Http\Controllers\Api\BookmarksController;
use App\Versions\V1\Http\Controllers\Api\ChapterController;
use App\Versions\V1\Http\Controllers\Api\LikeableController;
use App\Versions\V1\Http\Controllers\Api\CommentController;
use App\Versions\V1\Http\Controllers\Api\HistoryController;
use App\Versions\V1\Http\Controllers\Api\FilterableController;
use App\Versions\V1\Http\Controllers\Api\FilterController;
use App\Versions\V1\Http\Controllers\Api\MangaController;
use App\Versions\V1\Http\Controllers\Api\NotificationController;
use App\Versions\V1\Http\Controllers\Api\RatingableController;
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
     * Admin
     */
    Route::prefix('panel')->middleware('permission:view admin panel')->group(function () {
        require('admin.php');
    });

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
    Route::apiResource('teams', TeamController::class);
    Route::post('/teams/{team}/members/{user}', [TeamMemberController::class, 'store'])->name('team-member.store');
    Route::put('/teams/{team}/members/{user}', [TeamMemberController::class, 'update'])->name('team-member.update');
    Route::delete('/teams/{team}/members/{user}', [TeamMemberController::class, 'destroy'])->name('team-member.destroy');

    Route::get('/team-invitations/{invitation}', [TeamInvitationController::class, 'accept'])->name('team-invitation.accept');

    Route::delete('/team-invitations/{invitation}', [TeamInvitationController::class, 'destroy'])->name('team-invitation.destroy');

    Route::post('/teams/{team}/attach/{model}/{id}', [TeamableController::class, 'attach'])->name('teamable.attach');
    Route::post('/teams/{team}/detach/{model}/{id}', [TeamableController::class, 'detach'])->name('teamable.detach');

    /*
     * Manga
     */
    Route::get('/mangas/random', [MangaController::class, 'random'])->name('manga.random');

    Route::apiResource('mangas', MangaController::class)->parameter('mangas', 'manga:slug');


    Route::apiResource('filters', FilterController::class);
    Route::post('/filters/{filter}/attach/{model}/{id}', [FilterableController::class, 'attach'])->name('filterable.attach');
    Route::post('/filters/{filter}/detach/{model}/{id', [FilterableController::class, 'detach'])->name('filterable.detach');

    Route::group(['middleware' => 'auth'], function () {
    /*
     * Like
     */
        Route::post('/like/{model}/{id}', [LikeableController::class, 'add'])
            ->name('likeable.add')
            ->whereIn('model', LikeableTypeEnum::values())
            ->whereNumber('id');
        Route::delete('/like/{model}/{id}', [LikeableController::class, 'delete'])
            ->name('likeable.delete')
            ->whereIn('model', LikeableTypeEnum::values())
            ->whereNumber('id');

        Route::post('/rating/{model}/{id}', [RatingableController::class, 'updateOrCreate'])
            ->name('raingable.add')
            ->whereIn('model', RatingableTypeEnum::values())
            ->whereNumber('id');
        Route::delete('/rating/{model}/{id}', [RatingableController::class, 'delete'])
            ->name('raingable.delete')
            ->whereIn('model', RatingableTypeEnum::values())
            ->whereNumber('id');

    /*
     * Bookmarks
     */
        Route::get('/bookmarks', [BookmarksController::class, 'index'])->name('bookmarks.index');
        Route::post('/bookmarks/{manga}', [BookmarksController::class, 'attach'])->name('bookmarks.attach');
        Route::delete('/bookmarks/{manga}', [BookmarksController::class, 'detach'])->name('bookmarks.detach');
    /*
     * Notifications
     */
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notification.index');
        Route::get('/notifications/more/{groupId}', [NotificationController::class, 'more'])->name('notification.more');
        Route::post('/notifications/read/{notification}', [NotificationController::class, 'read'])->name('notification.read');
        Route::post('/notifications/unread/{notification}', [NotificationController::class, 'unread'])->name('notification.unread');
        Route::post('/notifications/readSet/{ids}', [NotificationController::class, 'readSet'])->name('notifications.readSet');
        Route::post('/notifications/unReadSet/{ids}', [NotificationController::class, 'unReadSet'])->name('notifications.unReadSet');
        Route::post('/notifications/readAll', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    });

    Route::get('history', HistoryController::class);

    Route::scopeBindings()->group( function () {
        /*
         * Chapter
         */
        Route::get('/mangas/{manga:slug}/chapter', [ChapterController::class, 'index'])->name('chapter.index');
        Route::get('/mangas/{manga:slug}/chapter/{chapter:order}', [ChapterController::class, 'show'])->name('chapter.show');

        Route::get('/teams/{team}/manga/', [TeamMangaController::class, 'index'])->name('teams.manga.index');
        Route::get('/teams/{team}/manga/{manga}', [TeamMangaController::class, 'show'])->name('teams.manga.show');

        Route::apiResource('teams.manga.chapter', TeamMangaChapterController::class);
    });

    /*
     * Comments
     */
    Route::get('/comment/{model}/{id}', [CommentController::class, 'index'])
        ->name('comment.index')
        ->whereIn('model', CommentableTypeEnum::values())
        ->whereNumber('id');
    Route::post('/comment/{model}/{id}', [CommentController::class, 'store'])
        ->name('comment.store')
        ->whereIn('model', CommentableTypeEnum::values())
        ->whereNumber('id');

    Route::patch('/comment/{comment}', [CommentController::class, 'update'])
        ->name('comment.update');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])
        ->name('comment.destroy');
});
