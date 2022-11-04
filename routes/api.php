<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\VideoStatusController;
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

Route::controller(UsersController::class)->prefix('users')->group(function () {
    Route::post('/', "store")->name('users.store'); // Только гость
    Route::post('/login', 'login')->name('users.login'); // Только гости
    Route::post('/logout', 'logout')->name('users.logout'); // Только вошедшие
    Route::post('/change/status', 'changeStatusVideo')->name('users.change-status-video');
});

Route::controller(VideosController::class)->prefix('videos')->group(function () {
    Route::get('/', "index")->name('videos.index'); // Только админ
    Route::get('/ten', 'showTen')->name('videos.show-ten'); // Только гости
    Route::get('/my', 'showMy')->name('videos.show-my');
    Route::get('/{video}', "show")->name('videos.show'); // Только админ и пользователь
    Route::post('/', "store")->name('videos.store'); // Только гость
});

Route::controller(CategoryController::class)->prefix('category')->group(function () {
    Route::get('/', "index")->name('category.index'); // Только админ
});

Route::controller(VideoStatusController::class)->prefix('status')->group(function () {
    Route::get('/', "index")->name('status.index'); // Только админ
});

Route::controller(CommentController::class)->prefix('comment')->group(function () {
    Route::post('/', "store")->name('comment.store');
});
