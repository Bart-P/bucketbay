<?php

use App\Http\Controllers\GraficController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AddressController;
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

Route::get('/', [ItemController::class, 'index']);
Route::get('/login', fn () => view('login'));

Route::get('/grafics', [GraficController::class, 'grafics']);

Route::resources([
    'addresses' => AddressController::class,
]);
