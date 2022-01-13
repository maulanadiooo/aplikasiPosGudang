<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resources([
    "home" => App\Http\Controllers\HomeController::class,
    "members" => App\Http\Controllers\MemberController::class,
    "suppliers" => App\Http\Controllers\SupplierController::class,
    "items" => App\Http\Controllers\ItemController::class,
    "transactions" => App\Http\Controllers\TransactionController::class,
]);

Route::get('/api/members', [App\Http\Controllers\MemberController::class, 'api']);
Route::get('/api/suppliers', [App\Http\Controllers\SupplierController::class, 'api']);
Route::get('/api/items', [App\Http\Controllers\ItemController::class, 'api']);
Route::get('/api/transactions', [App\Http\Controllers\TransactionController::class, 'api']);