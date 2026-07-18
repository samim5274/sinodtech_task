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
    Route::post('/confimr', [SaleController::class, 'confirmSale'])->name('confirm.sale');
});
