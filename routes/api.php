<?php


use App\Enums\RatesTypeEnum;
use App\Versions\V1\Http\Controllers\Api\BookmarksController;
use App\Versions\V1\Http\Controllers\Api\ChapterController;
use App\Versions\V1\Http\Controllers\Api\CommentController;
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
use App\Versions\V1\Http\Controllers\Api\TagController;
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

    Route::get('user/{user}/invitations', [InvitationController::class, 'index'])->name('user.invitation.index');
    Route::post('user/{user}/invitations/{invitation}', [InvitationController::class, 'accept'])->name('user.invitation.accept');
    Route::delete('user/{user}/invitations/{invitation}', [InvitationController::class, 'reject'])->name('user.invitation.reject');


    /* Teams */
    Route::apiResource('team', TeamController::class)->middleware('role:owner');
    Route::apiResource('team.members', TeamMemberController::class)->parameter('members', 'user');
    Route::apiResource('team.invitation', TeamInvitationController::class);

    Route::post('/team/{team}/{model}/{id}', [TeamableController::class, 'attach'])->name('team.manga.attach');
    Route::delete('/team/{team}/{model}/{id}', [TeamableController::class, 'detach'])->name('team.manga.detach');

    /* Manga */
    Route::get('/manga/random', [MangaController::class, 'random'])->name('manga.random');
    Route::apiResource('manga', MangaController::class);

    Route::scopeBindings()->group(function () {
        Route::apiResource('team.manga.chapter', ChapterController::class);
    });

    Route::apiResource('tags', TagController::class);

    Route::group(['middleware' => 'auth'], function () {
        foreach (RatesTypeEnum::values() as $type) {
            Route::post("/${type}/{model}/{id}", [RateableController::class, 'rate'])
                ->name("$type.rate")
                ->whereIn('model', RatesTypeEnum::tryFrom($type)->rateable());
            Route::delete("/${type}/{model}/{id}", [RateableController::class, 'unRate'])
                ->name("$type.un-rate")
                ->whereIn('model', RatesTypeEnum::tryFrom($type)->rateable());
        }

        /* Bookmarks */
        Route::get('/bookmarks/manga', [BookmarksController::class, 'indexManga'])->name('bookmarks.index-manga');
        Route::post('/bookmarks/{model}/{id}', [BookmarksController::class, 'attach'])->name('bookmarks.attach');
        Route::delete('/bookmarks/{model}/{id}', [BookmarksController::class, 'detach'])->name('bookmarks.detach');
        /* Notifications */
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
    Route::get('/comment/{model}/{id}', [CommentController::class, 'index'])->name('comment.index');
    Route::post('/comment/{model}/{id}', [CommentController::class, 'store'])->name('comment.store');
    Route::patch('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
});
