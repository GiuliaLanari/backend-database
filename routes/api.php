<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ProductController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::name('api.')
    ->prefix('v1')
    ->group(function () {
    ////////////////// ROUTE PRODUCT /////////////////////
        Route::get('/products',            [ProductController::class, 'index'])->name('products.index');// http://127.0.0.1:8000/api/v1/products
        Route::get('/products/{product}',  [ProductController::class, 'show'])->name('products.show');//http://127.0.0.1:8000/api/v1/products/id


        Route::get('/products/add',     [ProductController::class, 'add'])->name('products.add');
        Route::put('/products/{id}',  [ProductController::class, 'update'])->name('products.edit');
        Route::delete('/products/{id}',    [ProductController::class, 'delete'])->name('products.delete');


//////////////////// ROUTE ORDER /////////////////////

        Route::get('/orders',            [OrderController::class, 'index'])->name('orders.index'); //http://127.0.0.1:8000/api/v1/orders
        Route::get('/orders/{order}',     [OrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/confirm',     [OrderController::class, 'confirm'])->name('orders.confirm');
        Route::delete('/products/{id}',    [ProductController::class, 'delete'])->name('products.delete');




//////////////////// ROUTE CART /////////////////////

        Route::get('/cart',            [CartController::class, 'index'])->name('cart');///carrello utente

        Route::get('/carts/add',       [CartController::class, 'create'])->name('carts.add');
        Route::delete('/carts/{id}',   [CartController::class, 'delete'])->name('carts.delete');
        Route::get('/carts/',          [CartController::class, 'buy'])->name('carts.buy');

//////////////////// ROUTE REVIEW /////////////////////

        Route::get('/reviews',            [ReviewController::class, 'index'])->name('reviews.index');
        Route::get('/reviews/add',       [ReviewController::class, 'add'])->name('reviews.add');
        Route::delete('/reviews/{id}',    [ReviewController::class, 'delete'])->name('reviews.delete');

//////////////////// ROUTE TYPE USER /////////////////////

//         Route::get('/role', [AdminController::class, 'role'])->name('admin.role');
//         Route::get('/role', [ClientController::class, 'role'])->name('client.role');

    });