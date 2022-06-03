<?php

use App\Http\Controllers\PostsController;
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
