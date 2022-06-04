<?php

use App\Http\Controllers\BansController;
use App\Http\Controllers\BlocksController;
use App\Http\Controllers\FollowersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ReactionsController;
use App\Http\Controllers\ReportsController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->prefix('posts')->group(function() {
    Route::get('/', [PostsController::class, 'index']);
    Route::get('/{post}', [PostsController::class, 'view']);
    Route::post('/store', [PostsController::class, 'store']);
    Route::put('/{post}', [PostsController::class, 'update']);
    Route::delete('/{post}', [PostsController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('bans')->group(function() {
    Route::get('/{user}', [BansController::class, 'view']);
    Route::post('/store', [BansController::class, 'store']);
    Route::delete('/{ban}', [BansController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('blocks')->group(function() {
    Route::get('/{user}', [BlocksController::class, 'view']);
    Route::post('/store', [BlocksController::class, 'store']);
    Route::delete('/{user}/{blocker}', [BlocksController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('followers')->group(function() {
    Route::get('/{user}', [FollowersController::class, 'view']);
    Route::post('/store', [FollowersController::class, 'store']);
    Route::delete('/{user}/{follower}', [FollowersController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('reactions')->group(function() {
    Route::get('/{user}', [ReactionsController::class, 'view']);
    Route::post('/store', [ReactionsController::class, 'store']);
    Route::delete('/{reaction}', [ReactionsController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('reports')->group(function() {
    Route::get('/view/{type}/{id}', [ReportsController::class, 'view']);
    Route::post('/store', [ReportsController::class, 'store']);
    Route::delete('/{report}', [ReportsController::class, 'delete']);
});
