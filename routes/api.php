<?php


use App\Enums\RateTypeEnum;
use App\Versions\V1\Http\Controllers\Api\BookmarkController;
use App\Versions\V1\Http\Controllers\Api\ChapterController;
use App\Versions\V1\Http\Controllers\Api\CommentController;
use App\Versions\V1\Http\Controllers\Api\HistoryController;
use App\Versions\V1\Http\Controllers\Api\InvitationController;
use App\Versions\V1\Http\Controllers\Api\LikeController;
use App\Versions\V1\Http\Controllers\Api\MangaController;
use App\Versions\V1\Http\Controllers\Api\NotificationController;
use App\Versions\V1\Http\Controllers\Api\RateableController;
use App\Versions\V1\Http\Controllers\Api\RatingController;
use App\Versions\V1\Http\Controllers\Api\TeamableController;
use App\Versions\V1\Http\Controllers\Api\TeamController;
use App\Versions\V1\Http\Controllers\Api\TeamInvitationController;
use App\Versions\V1\Http\Controllers\Api\TeamMemberController;
use App\Versions\V1\Http\Controllers\Api\UserController;
use App\Versions\V1\Http\Controllers\Api\TagController;
use App\Versions\V1\Http\Controllers\Api\VoteController;
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

    require('auth.php');

    /* User */
    Route::get('user', [UserController::class, 'show']);

    Route::patch('user', [UserController::class, 'update']);

    Route::delete('user', [UserController::class, 'destroy']);

    Route::get('user/{user}/invitations', [InvitationController::class, 'index'])->name('user.invitation.index');
    Route::post('user/{user}/invitations/{invitation}', [InvitationController::class, 'accept'])->name('user.invitation.accept');
    Route::delete('user/{user}/invitations/{invitation}', [InvitationController::class, 'reject'])->name('user.invitation.reject');


    /* Teams */
    Route::apiResource('team', TeamController::class);
    Route::apiResource('team.members', TeamMemberController::class)
        ->parameter('members', 'user')
        ->middleware('team_permission:manage user');
    Route::apiResource('team.invitation', TeamInvitationController::class)
        ->middleware('team_permission:manage invitation');

    Route::middleware(['auth', 'permission:manage teamable'])->group(function () {
        Route::post('/team/{team}/{model}/{id}', [TeamableController::class, 'attach'])->name('team.manga.attach');
        Route::delete('/team/{team}/{model}/{id}', [TeamableController::class, 'detach'])->name('team.manga.detach');
    });

    /* Manga */
    Route::apiResource('manga', MangaController::class);
    Route::get('/manga/random', [MangaController::class, 'random'])->name('manga.random');
    Route::apiResource('chapter', ChapterController::class);

    Route::apiResource('tags', TagController::class);

    Route::group(['middleware' => 'auth'], function () {
        Route::post("/rating/{model}/{id}", [RatingController::class, 'rate'])->name('rating.rate');
        Route::delete("/rating/{model}/{id}", [RatingController::class, 'unRate'])->name('rating.unRate');
        Route::post("/like/{model}/{id}", [LikeController::class, 'rate'])->name('like.rate');
        Route::delete("/like/{model}/{id}", [LikeController::class, 'unRate'])->name('like.unRate');
        Route::post("/vote/{model}/{id}", [VoteController::class, 'rate'])->name('vote.rate');
        Route::delete("/vote/{model}/{id}", [VoteController::class, 'unRate'])->name('vote.unRate');

        /* Bookmarks */
        Route::get('/bookmarks/manga', [BookmarkController::class, 'indexManga'])->name('bookmarks.index-manga');
        Route::post('/bookmarks/{model}/{id}', [BookmarkController::class, 'attach'])->name('bookmarks.attach');
        Route::delete('/bookmarks/{model}/{id}', [BookmarkController::class, 'detach'])->name('bookmarks.detach');
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
    Route::get('/comment/{parentId}', [CommentController::class, 'loadChild'])->name('comment.load-child');
    Route::post('/comment/{model}/{id}', [CommentController::class, 'store'])->name('comment.store');
    Route::patch('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
});
