<?php

use App\Http\Controllers\GraficController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::get('/cart', [CartController::class, 'index']);

Route::post('/users/authenticate', [UserController::class, 'authenticate']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout']);

    Route::resources([
        'addresses' => AddressController::class,
        'grafics' => GraficController::class,
        'orders' => OrderController::class,
    ]);
});
