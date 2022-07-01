<?php

use App\Enums\BookmarkableTypeEnum;
use App\Enums\CommentableTypeEnum;
use App\Enums\RatesTypeEnum;
use App\Enums\TeamableTypeEnum;
use App\Versions\V1\Http\Controllers\Api\BookmarksController;
use App\Versions\V1\Http\Controllers\Api\ChapterController;
use App\Versions\V1\Http\Controllers\Api\ChapterTeamController;
use App\Versions\V1\Http\Controllers\Api\CommentController;
use App\Versions\V1\Http\Controllers\Api\FilterController;
use App\Versions\V1\Http\Controllers\Api\HistoryController;
use App\Versions\V1\Http\Controllers\Api\InvitationController;
use App\Versions\V1\Http\Controllers\Api\MangaController;
use App\Versions\V1\Http\Controllers\Api\NotificationController;
use App\Versions\V1\Http\Controllers\Api\RateableController;
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
    /* Admin */
    Route::prefix('panel')->middleware(['auth', 'permission:view admin panel'])->group(function () {
        require('admin.php');
    });

    /* Auth */
    require('auth.php');

    /* User */
    Route::get('user', [UserController::class, 'show']);

    Route::patch('user', [UserController::class, 'update']);

    Route::delete('user', [UserController::class, 'destroy']);

    /* Teams */
    Route::apiResource('team', TeamController::class);
    Route::apiResource('team.members', TeamMemberController::class)->parameter('members', 'user');
    Route::apiResource('team.invitation', TeamInvitationController::class);

    Route::get('user/{user}/invitations', [InvitationController::class, 'index'])->name('invitation');
    Route::get('user/{user}/invitations/{invitation}', [InvitationController::class, 'accept'])->name('invitation.accept');
    Route::delete('user/{user}/invitations/{invitation}', [InvitationController::class, 'reject'])->name('invitation.reject');

    Route::post('/team/{team}/{model}/{id}', [TeamableController::class, 'attach'])
        ->name('team.manga.attach')
        ->whereIn('model', TeamableTypeEnum::values())
        ->whereNumber('id');
    Route::delete('/team/{team}/{model}/{id}', [TeamableController::class, 'detach'])
        ->name('team.manga.detach')
        ->whereIn('model', TeamableTypeEnum::values())
        ->whereNumber('id');

    /* Manga */
    Route::get('/manga/random', [MangaController::class, 'random'])->name('manga.random');
    Route::apiResource('manga', MangaController::class);

    Route::where(['chapter' => '(\d+)-(\d+)'])->scopeBindings()->group(function () {
        Route::apiResource('manga.chapter', ChapterController::class);
        Route::apiResource('manga.chapter.chapter-team', ChapterTeamController::class)->except('store');
        Route::post('/manga/{manga}/chapter/{chapter}/chapter-team/{team_id}', [ChapterTeamController::class, 'store'])->name('manga.chapter.chapter-team.store');
    });

    Route::apiResource('filter', FilterController::class);

    Route::group(['middleware' => 'auth'], function () {
        foreach (RatesTypeEnum::values() as $type) {
            Route::post("/${type}/{model}/{id}", [RateableController::class, 'rate'])
                ->name("$type.rate")
                ->whereIn('model', RatesTypeEnum::tryFrom($type)->rateable())
                ->whereNumber('id');
            Route::delete("/${type}/{model}/{id}", [RateableController::class, 'unRate'])
                ->name("$type.un-rate")
                ->whereIn('model', RatesTypeEnum::tryFrom($type)->rateable())
                ->whereNumber('id');
        }

        /*Bookmarks*/
        Route::get('/bookmarks/{model}', [BookmarksController::class, 'index'])
            ->name('bookmarks.index')
            ->whereIn('model', BookmarkableTypeEnum::values());
        Route::post('/bookmarks/{model}/{id}', [BookmarksController::class, 'attach'])
            ->name('bookmarks.attach')
            ->whereIn('model', BookmarkableTypeEnum::values())
            ->whereNumber('id');
        Route::delete('/bookmarks/{model}/{id}', [BookmarksController::class, 'detach'])
            ->name('bookmarks.detach')
            ->whereIn('model', BookmarkableTypeEnum::values())
            ->whereNumber('id');
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

    /* Comments */
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
