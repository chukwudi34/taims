<?php

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

Route::middleware('auth:sanctum')->prefix('chat')->group(function () {
    Route::get('/messages', [\App\Http\Controllers\ChatController::class, 'index']);
    Route::post('/send', [\App\Http\Controllers\ChatController::class, 'store']);
    Route::get('/unread-count', [\App\Http\Controllers\ChatController::class, 'unreadCount']);
    Route::get('/contacts', [\App\Http\Controllers\ChatController::class, 'contacts']);
});
