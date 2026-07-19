<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('public/products');
});

// ======================
// Product Routes
// ======================
use App\Http\Controllers\Product\ProductController;
Route::prefix('public')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/product/{sku}', [ProductController::class, 'showProduct']);
});



// ======================
// Sale Routes
// ======================
use App\Http\Controllers\Sale\SaleController;
Route::prefix('sale')->group(function () {
    Route::get('/', [SaleController::class, 'saleView'])->name('sale.index');
    Route::post('/add-sale-item', [SaleController::class, 'addSaleItem'])->name('add.sale.item');
    Route::delete('/sale-item-delete/{id}', [SaleController::class, 'deleteSaleItem'])->name('sale-items.destroy');

    // Confirm sale
    Route::post('/confirm', [SaleController::class, 'confirmSale'])->name('confirm.sale');
});


// ======================
// Customer Routes
// ======================
use App\Http\Controllers\Customer\CustomerController;
Route::prefix('customer')->group(function () {
    Route::get('/purchase', [CustomerController::class, 'purchaseHistory'])->name('customer');
    Route::get('/employee', [CustomerController::class, 'customerList'])->name('employee.list');

    Route::prefix('assign')->group(function () {
        Route::get('/list', [CustomerController::class, 'customerAssignList'])->name('customer-assign-list');
        Route::get('/customer-list/{employee_id}', [CustomerController::class, 'assignCustomer'])->name('customer-list');
        Route::get('/customer-assign/{customer_id}/{employee_id}', [CustomerController::class, 'assignCustomerToEmployee'])->name('assign');
        Route::delete('/delete/{id}', [CustomerController::class, 'assignDestroy'])->name('assignments.destroy');
    });

    Route::get('/{customer_id}', [CustomerController::class, 'customerPurchaseList'])->name('customer-purchase-list');
    Route::get('/sale-view/{invoice_no}', [CustomerController::class, 'showSale'])->name('sales.show');
});



// ======================
// Mail Routes
// ======================
use App\Http\Controllers\Mail\MailController;
Route::prefix('mail')->group(function () {
    Route::get('/', [MailController::class, 'index'])->name('user-mail');
    Route::post('/send-mail', [MailController::class, 'sendMail'])->name('send-mail');
});



// ======================
// Transaction Routes
// ======================
use App\Http\Controllers\Transaction\TransactionController;
Route::prefix('payment')->group(function () {
    Route::get('/history', [TransactionController::class, 'transactionHistory'])->name('transaction-history');
    Route::get('/{reg}', [TransactionController::class, 'index'])->name('payment.view');
    Route::post('/store', [TransactionController::class, 'store'])->name('payments.store');
});
