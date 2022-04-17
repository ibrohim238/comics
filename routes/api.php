<?php

use App\Versions\V1\Http\Controllers\Api\ChapterController;
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
    Route::group(['prefix' => '/manga/{manga}', 'controller' => ChapterController::class], function() {
        Route::post('/', 'store');
        Route::get('/{chapter}', 'show');
        Route::patch('/{chapter}', 'update');
        Route::delete('/{chapter}', 'destroy');
    });



});
