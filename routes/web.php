<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PtjController;
use App\Http\Controllers\TestController;
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
Route::prefix('ptj')->group(function () {
    Route::get('create', [PtjController::class, 'createPtj'])->name('createPtj');
    Route::post('store', [PtjController::class, 'storePtj'])->name('storePtj');

    Route::prefix('{ptj}')->group(function () {
        Route::get('bahagian/create', [PtjController::class, 'createBahagian'])->name('createBahagian');
        Route::post('bahagian/store', [PtjController::class, 'storeBahagian'])->name('storeBahagian');
    });
});

Route::prefix('bahagian/{bahagian}')->group(function () {
    Route::get('unit/create', [PtjController::class, 'createUnit'])->name('createUnit');
    Route::post('unit/store', [PtjController::class, 'storeUnit'])->name('storeUnit');
});


Route::get('/test', [App\Http\Controllers\TestController::class, 'index'])->name('test.index');
Route::post('/test/store', [App\Http\Controllers\TestController::class, 'store'])->name('test.store');

