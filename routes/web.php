<?php

use App\Http\Controllers\GraficController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\UserController;
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

Route::post('/users/authenticate', [UserController::class, 'authenticate']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/grafics', [GraficController::class, 'grafics']);
    Route::post('/grafics', [GraficController::class, 'store']);

    Route::resources([
        'addresses' => AddressController::class,
    ]);
});
