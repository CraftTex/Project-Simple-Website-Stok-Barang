<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StockController;
use App\Models\Barang;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index',[
        'title' => 'Home',
    ]);
})->middleware('auth');

Route::get('home', function () {
    return view('index',[
        'title' => 'Home',
    ]);
})->middleware('auth');


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class,'index']);
Route::post('/register', [RegisterController::class,'store']);


Route::get('/barang/getSlug', [BarangController::class, 'getSlug']);
Route::get('/barang/items', [BarangController::class, 'getDataTables']);
Route::resource('/barang', BarangController::class)->middleware('auth');

Route::get('/stock/getTable', [StockController::class, 'getDataTables']);
Route::resource('/stock', StockController::class)->middleware('auth');