<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('add-more', [ProductController::class, 'index']);
Route::post('add-more', [ProductController::class, 'store'])->name('add-more.store');;

// testing for other method
Route::get('ptj/create', [PtjController::class, 'createPtj'])->name('createPtj');
Route::post('ptj/store', [PtjController::class, 'storePtj'])->name('storePtj');

Route::get('bahagian/create/{ptj_id}', [PtjController::class, 'createBahagian'])->name('createBahagian');
Route::post('bahagian/store/{ptj_id}', [PtjController::class, 'storeBahagian'])->name('storeBahagian');

Route::get('unit/create/{bahagian_id}', [PtjController::class, 'createUnit'])->name('createUnit');
Route::post('unit/store/{bahagian_id}', [PtjController::class, 'storeUnit'])->name('storeUnit');
