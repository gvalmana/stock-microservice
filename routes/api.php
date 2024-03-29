<?php

use App\Http\Controllers\MarkePlaceController;
use App\Http\Controllers\ReciveOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('orders/')->middleware(['log.http.requests','check.authorization.header'])->group(function () {
    Route::post('get-order', ReciveOrderController::class)->name('order.get');
});

Route::prefix('marketplace/')->group(function () {
    Route::get('history', MarkePlaceController::class)->name('history.marketplace.index');
});

Route::get('/healtcheck', function() {
    return response()->json([
        'status' => true,
        'message' => 'OK, My name is ' . env('APP_NAME') . ', I am healthy!'
    ]);
})->name('healtcheck');
