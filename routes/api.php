<?php

use App\Http\Controllers\API;
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

Route::post('login', [API\UserController::class, 'login'])->name('login');

Route::get('user', [API\UserController::class, 'show'])->middleware('auth:sanctum')->name('user');

Route::group(['as' => 'events.', 'prefix' => 'events'], function () {
    Route::get('/', [API\EventController::class, 'index'])->name('index');
    Route::get('{id}', [API\EventController::class, 'show'])->name('show');
});

Route::group(['middleware' => 'auth:sanctum', 'as' => 'orders.', 'prefix' => 'orders'], function () {    
    Route::get('/', [API\OrderController::class, 'index'])->name('index');
    Route::post('event', [API\OrderController::class, 'create'])->name('create');

    Route::get('{id}', [API\OrderController::class, 'show'])->name('show');
    Route::post('{id}/confirm', [API\OrderController::class, 'confirm'])->name('confirm');
    Route::post('{id}/cancel', [API\OrderController::class, 'cancel'])->name('cancel');
    Route::get('{id}/tickets', [API\TicketController::class, 'getByOrderId'])->name('tickets');
});

Route::group(['middleware' => 'auth:sanctum', 'as' => 'tickets.', 'prefix' => 'tickets'], function () {
    Route::get('/', [API\TicketController::class, 'index'])->name('index');
    Route::get('{id}', [API\TicketController::class, 'show'])->name('show');
    Route::post('{id}/use', [API\TicketController::class, 'use'])->name('use');
});