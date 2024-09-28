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

// Test PTJ section
Route::get('/test', [TestController::class, 'index'])->name('test.index');
Route::post('/test/store', [TestController::class, 'store'])->name('test.store');
route::get('/ptj/{id}', [TestController::class, 'show'])->name('ptj.show');
route::delete('/ptj/{id}', [TestController::class, 'destroy'])->name('ptj.destroy');
Route::get('/ptj/{id}/edit', [TestController::class, 'edit']);
Route::put('/ptj/{id}', [TestController::class, 'update']);
Route::get('search', [TestController::class, 'search'])->name('search');
//Bahagian section
Route::get('/ptj/{id}/bahagian', [TestController::class, 'showBahagian'])->name('ptj.bahagian');
Route::post('/bahagian', [TestController::class, 'storeBahagian'])->name('bahagian.store');
Route::delete('/bahagian/{id}', [TestController::class, 'destroyBahagian'])->name('bahagian.destroy');
Route::get('/bahagian/{id}/edit', [TestController::class, 'editBahagian'])->name('test.bahagian.edit');
Route::put('/bahagian/{id}', [TestController::class, 'updateBahagian'])->name('test.bahagian.update');
