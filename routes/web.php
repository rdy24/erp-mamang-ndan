<?php

use App\Http\Controllers\BomController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/', [LoginController::class, 'authenticate'])->name('login.authenticate')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout']);

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.','middleware' => 'auth'], function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
    
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials');
    Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
    Route::post('/materials/store', [MaterialController::class, 'store'])->name('materials.store');
    Route::get('/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
    Route::put('/materials/{material}/update', [MaterialController::class, 'update'])->name('materials.update');
    Route::delete('/materials/{material}/delete', [MaterialController::class, 'destroy'])->name('materials.destroy');

    Route::get('/bom', [BomController::class, 'index'])->name('bom');
    Route::get('/bom/create', [BomController::class, 'create'])->name('bom.create');
    Route::post('/bom/store', [BomController::class, 'store'])->name('bom.store');
    Route::get('/bom/{bom}', [BomController::class, 'show'])->name('bom.show');
    Route::get('/bom/{bom}/edit', [BomController::class, 'edit'])->name('bom.edit');
    Route::put('/bom/{bom}/update', [BomController::class, 'update'])->name('bom.update');
    Route::delete('/bom/{bom}/delete', [BomController::class, 'destroy'])->name('bom.destroy');
});


