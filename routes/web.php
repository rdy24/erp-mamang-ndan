<?php

use App\Http\Controllers\BomController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManufacturingOrderController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RequestForQuotationController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\VendorController;
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

Route::get('/get-bom/{jumlah}/{id}', [ManufacturingOrderController::class, 'getBomDetail'])->name('get-bom');

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.','middleware' => 'auth'], function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}/delete', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
    Route::post('/materials/store', [MaterialController::class, 'store'])->name('materials.store');
    Route::get('/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
    Route::put('/materials/{material}/update', [MaterialController::class, 'update'])->name('materials.update');
    Route::delete('/materials/{material}/delete', [MaterialController::class, 'destroy'])->name('materials.destroy');

    Route::get('/bom', [BomController::class, 'index'])->name('bom.index');
    Route::get('/bom/create', [BomController::class, 'create'])->name('bom.create');
    Route::post('/bom/store', [BomController::class, 'store'])->name('bom.store');
    Route::get('/bom/{bom}', [BomController::class, 'show'])->name('bom.show');
    Route::get('/bom/{bom}/edit', [BomController::class, 'edit'])->name('bom.edit');
    Route::put('/bom/{bom}/update', [BomController::class, 'update'])->name('bom.update');
    Route::delete('/bom/{bom}/delete', [BomController::class, 'destroy'])->name('bom.destroy');
    Route::get('/bom/{bom}/print', [BomController::class, 'print'])->name('bom.print');

    Route::get('/manufacturing-orders', [ManufacturingOrderController::class, 'index'])->name('manufacturing-orders.index');
    Route::get('/manufacturing-orders/create', [ManufacturingOrderController::class, 'create'])->name('manufacturing-orders.create');
    Route::post('/manufacturing-orders/store', [ManufacturingOrderController::class, 'store'])->name('manufacturing-orders.store');
    Route::get('/manufacturing-orders/{manufacturingOrder}', [ManufacturingOrderController::class, 'show'])->name('manufacturing-orders.show');
    Route::get('/manufacturing-orders/{manufacturingOrder}/edit', [ManufacturingOrderController::class, 'edit'])->name('manufacturing-orders.edit');
    Route::put('/manufacturing-orders/{manufacturingOrder}/update', [ManufacturingOrderController::class, 'update'])->name('manufacturing-orders.update');
    Route::delete('/manufacturing-orders/{manufacturingOrder}/delete', [ManufacturingOrderController::class, 'destroy'])->name('manufacturing-orders.destroy');
    Route::get('/manufacturing-orders/{manufacturingOrder}/confirm', [ManufacturingOrderController::class, 'confirm'])->name('manufacturing-orders.confirm');
    Route::get('/manufacturing-orders/{manufacturingOrder}/progress', [ManufacturingOrderController::class, 'progress'])->name('manufacturing-orders.progress');
    Route::get('/manufacturing-orders/{manufacturingOrder}/done', [ManufacturingOrderController::class, 'done'])->name('manufacturing-orders.done');

    Route::get('/vendors', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('/vendors/create', [VendorController::class, 'create'])->name('vendors.create');
    Route::post('/vendors/store', [VendorController::class, 'store'])->name('vendors.store');
    Route::get('/vendors/{vendor}', [VendorController::class, 'show'])->name('vendors.show');
    Route::get('/vendors/{vendor}/edit', [VendorController::class, 'edit'])->name('vendors.edit');
    Route::put('/vendors/{vendor}/update', [VendorController::class, 'update'])->name('vendors.update');
    Route::delete('/vendors/{vendor}/delete', [VendorController::class, 'destroy'])->name('vendors.destroy');

    Route::get('/rfq', [PurchaseController::class, 'index'])->name('purchase.rfq');
    Route::get('/rfq/create', [PurchaseController::class, 'rfqCreate'])->name('purchase.rfq.create');
    Route::post('/rfq/store', [PurchaseController::class, 'rfqStore'])->name('purchase.rfq.store');
    Route::get('/rfq/{purchase}', [PurchaseController::class, 'show'])->name('purchase.rfq.show');
    Route::get('/rfq/{purchase}/confirm', [PurchaseController::class, 'rfqConfirm'])->name('purchase.rfq.confirm');
    Route::get('/purchase-order', [PurchaseController::class, 'index'])->name('purchase-order.index');
    Route::get('/purchase-order/{purchase}', [PurchaseController::class, 'show'])->name('purchase-order.show');
    Route::get('/purchase-order/{purchase}/receive', [PurchaseController::class, 'purchaseOrderReceive'])->name('purchase-order.receive');
    Route::get('/purchase-order/{purchase}/validate', [PurchaseController::class, 'purchaseOrderValidate'])->name('purchase-order.validate');
    Route::get('/purchase-order/{purchase}/create-bill', [PurchaseController::class, 'purchaseOrderCreateBill'])->name('purchase-order.bill.create');
    Route::post('/purchase-order/{purchase}/store-bill', [PurchaseController::class, 'purchaseOrderStoreBill'])->name('purchase-order.bill.store');
    Route::get('/purchase-order/{purchase}/post-bill', [PurchaseController::class, 'purchaseOrderPostBill'])->name('purchase-order.bill.post');

});


