<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/suggestions', [UserController::class, 'getSuggestions']);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/connect', [UserController::class, 'connect'])->name('users.connect');
    Route::get('/users/sent-requests', [UserController::class, 'sentRequests'])->name('users.sent-requests');
    Route::post('/users/withdraw-request', [UserController::class, 'withdrawRequest'])->name('users.withdraw-request');
    Route::get('/users/received-requests', [UserController::class, 'receivedRequests'])->name('users.received-requests');
    Route::post('/users/accept-request', [UserController::class, 'acceptRequest'])->name('users.accept-request');
    Route::get('/users/connections', [UserController::class, 'connections'])->name('users.connections');
    Route::post('/users/remove-connection', [UserController::class, 'removeConnection'])->name('users.remove-connection');
});