<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\BomController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManufacturingOrderController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RequestForQuotationController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\QuotationTemplateController;
use App\Http\Controllers\SaleController;
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

Route::get('/get-vendor/{id}', [VendorController::class, 'getVendor'])->name('get-vendor');
Route::get('/get-customer/{id}', [CustomerController::class, 'getCustomer'])->name('get-customer');
Route::get('/get-template/{id}', [QuotationTemplateController::class, 'getTemplate'])->name('get-template');

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
    Route::get('/manufacturing-orders/{manufacturingOrder}/to-do', [ManufacturingOrderController::class, 'toDo'])->name('manufacturing-orders.todo');
    Route::get('/manufacturing-orders/{manufacturingOrder}/check', [ManufacturingOrderController::class, 'checkMaterial'])->name('manufacturing-orders.check-material');
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
    Route::get('/rfq/{purchase}/edit', [PurchaseController::class, 'rfqEdit'])->name('purchase.rfq.edit');
    Route::put('/rfq/{purchase}/update', [PurchaseController::class, 'rfqUpdate'])->name('purchase.rfq.update');
    Route::delete('/rfq/{purchase}/delete', [PurchaseController::class, 'rfqDestroy'])->name('purchase.rfq.destroy');
    Route::get('/rfq/{purchase}/confirm', [PurchaseController::class, 'rfqConfirm'])->name('purchase.rfq.confirm');
    Route::get('/purchase-order', [PurchaseController::class, 'index'])->name('purchase-order.index');
    Route::get('/purchase-order/{purchase}', [PurchaseController::class, 'show'])->name('purchase-order.show');
    Route::get('/purchase-order/{purchase}/receive', [PurchaseController::class, 'purchaseOrderReceive'])->name('purchase-order.receive');
    Route::get('/purchase-order/{purchase}/validate', [PurchaseController::class, 'purchaseOrderValidate'])->name('purchase-order.validate');
    Route::get('/purchase-order/{purchase}/create-bill', [PurchaseController::class, 'purchaseOrderCreateBill'])->name('purchase-order.bill.create');
    Route::post('/purchase-order/{purchase}/store-bill', [PurchaseController::class, 'purchaseOrderStoreBill'])->name('purchase-order.bill.store');
    Route::get('/purchase-order/{purchase}/post-bill', [PurchaseController::class, 'purchaseOrderPostBill'])->name('purchase-order.bill.post');
    Route::post('/purchase-order/{purchase}/store-payment', [PurchaseController::class, 'purchaseOrderStorePayment'])->name('purchase-order.payment.store');

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}/update', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}/delete', [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::get('/quotation-template', [QuotationTemplateController::class, 'index'])->name('quotation-template.index');
    Route::get('/quotation-template/create', [QuotationTemplateController::class, 'create'])->name('quotation-template.create');
    Route::post('/quotation-template/store', [QuotationTemplateController::class, 'store'])->name('quotation-template.store');
    Route::get('/quotation-template/{template}', [QuotationTemplateController::class, 'show'])->name('quotation-template.show');
    Route::get('/quotation-template/{template}/edit', [QuotationTemplateController::class, 'edit'])->name('quotation-template.edit');
    Route::put('/quotation-template/{template}/update', [QuotationTemplateController::class, 'update'])->name('quotation-template.update');
    Route::delete('/quotation-template/{template}/delete', [QuotationTemplateController::class, 'destroy'])->name('quotation-template.destroy');

    Route::get('/quotation', [SaleController::class, 'index'])->name('sale.index');
    Route::get('/quotation/create', [SaleController::class, 'quotationCreate'])->name('sale.quotation.create');
    Route::post('/quotation/store', [SaleController::class, 'quotationStore'])->name('sale.quotation.store');
    Route::get('/quotation/{sale}', [SaleController::class, 'quotationShow'])->name('sale.quotation.show');
    Route::get('/quotation/{sale}/edit', [SaleController::class, 'quotationEdit'])->name('sale.quotation.edit');
    Route::put('/quotation/{sale}/update', [SaleController::class, 'quotationUpdate'])->name('sale.quotation.update');
    Route::delete('/quotation/{sale}/delete', [SaleController::class, 'destroy'])->name('sale.quotation.destroy');
    Route::get('/quotation/{sale}/confirm', [SaleController::class, 'quotationConfirm'])->name('sale.quotation.confirm');
    Route::get('/quotation/{sale}/invoice', [SaleController::class, 'createInvoice'])->name('sale.quotation.create.invoice');
    Route::get('/quotation/{sale}/confirm-invoice', [SaleController::class, 'confirmInvoice'])->name('sale.invoice.confirm');
    Route::post('/quotation/{sale}/store-payment', [SaleController::class, 'saleStorePayment'])->name('sale.invoice.payment');
    Route::get('/quotation/{sale}/deliver-product', [SaleController::class, 'deliverProduct'])->name('sale.deliver-product');

    Route::get('/send-quotation/{sale}', [SaleController::class, 'sendQuotation'])->name('sale.send-quotation');
    Route::get('/send-invoice/{sale}', [SaleController::class, 'sendInvoice'])->name('sale.send-invoice');

    Route::get('/tes-quotation/{sale}',[SaleController::class, 'print'])->name('sale.tes-quotation');
    Route::get('/print-invoice/{sale}',[SaleController::class, 'printInvoice'])->name('sale.print-invoice');

    Route::get('/accounting', [AccountingController::class, 'index'])->name('accounting.index');
});


