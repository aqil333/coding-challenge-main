<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuggestionsController;
use App\Http\Controllers\ConnectionsController;
use App\Http\Controllers\CommonConnectionsController;
use App\Http\Controllers\SentRequestsController;
use App\Http\Controllers\ReceivedRequestsController;

/* |-------------------------------------------------------------------------- | API Routes |-------------------------------------------------------------------------- | | Here is where you can register API routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | is assigned the "api" middleware group. Enjoy building your API! | */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/suggestions', [SuggestionsController::class , 'index']);

Route::get('/users/sent-requests', [SentRequestsController::class, 'index']);
Route::post('/users/{id}/withdraw-request', [SentRequestsController::class, 'destory']);

Route::get('/users/received-requests', [ReceivedRequestsController::class, 'index']);
Route::post('/users/{id}/accept-request', [ReceivedRequestsController::class, 'store']);

Route::get('/users/connections', [ConnectionsController::class, 'index']);
Route::post('/users/{id}/connect', [ConnectionsController::class, 'store']);
Route::post('/users/{id}/remove-connection', [ConnectionsController::class, 'destory']);

Route::get('/users/{id}/common-connections', [CommonConnectionsController::class, 'index']);






