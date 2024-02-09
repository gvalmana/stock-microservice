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

Route::prefix('orders/')->group(function () {
    Route::post('get-order', ReciveOrderController::class)->name('order.get');
});

Route::prefix('marketplace/')->group(function () {
    Route::get('history', MarkePlaceController::class)->name('history.marketplace.index');
});

Route::get('/healtcheck', function() {
    return response()->json([
        'status' => true,
        'message' => 'OK, I am healthy!'
    ]);
})->name('healtcheck');
