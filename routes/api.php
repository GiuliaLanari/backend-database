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


Route::name('api.v1')//va a scrivere nella prima parte del name->route
    ->prefix('v1')//va a inserirsi nel link del  sito
//     ->middleware(['auth:sanctum']) 
    ->group(function () {
    ////////////////// ROUTE PRODUCT /////////////////////
        Route::get('/products',            [ProductController::class, 'index'])->name('products.index');// http://127.0.0.1:8000/api/v1/products
        Route::get('/products/{product}',  [ProductController::class, 'show'])->name('products.show');//http://127.0.0.1:8000/api/v1/products/id


        Route::post('/products/add',     [ProductController::class, 'add'])->name('products.add');//ADMIN
        Route::put('/products/{id}/edit',  [ProductController::class, 'edit'])->name('products.edit');//ADMIN
        Route::delete('/products/{id}',    [ProductController::class, 'delete'])->name('products.delete');//ADMIN

///////// FINO QUI TUTTO CORRETTO ////////
//////////////////// ROUTE ORDER /////////////////////

        Route::get('/orders',            [OrderController::class, 'index'])->name('orders.index'); //http://127.0.0.1:8000/api/v1/orders
        Route::get('/orders/{order}',     [OrderController::class, 'show'])->name('orders.show');

        Route::get('/orders/confirm',     [OrderController::class, 'confirm'])->name('orders.confirm');//ADMIN
        Route::delete('/products/{id}',    [ProductController::class, 'delete'])->name('products.delete');//ADMIN




//////////////////// ROUTE CART /////////////////////

        Route::get('/cart',            [CartController::class, 'index'])->name('cart');//CLIENT

        Route::get('/carts/add',       [CartController::class, 'add'])->name('carts.add'); //CLIENT

        Route::delete('/carts/{id}',   [CartController::class, 'delete'])->name('carts.delete'); //CLIENT
        Route::get('/carts/',          [CartController::class, 'buy'])->name('carts.buy');//CLIENT

//////////////////// ROUTE REVIEW /////////////////////

        Route::get('/reviews',            [ReviewController::class, 'index'])->name('reviews.index');//TUTTI
        Route::get('/reviews/add',       [ReviewController::class, 'add'])->name('reviews.add');//CLIENT
        Route::delete('/reviews/{id}',    [ReviewController::class, 'delete'])->name('reviews.delete');//CLIENT

//////////////////// ROUTE TYPE USER /////////////////////

//         Route::get('/role', [AdminController::class, 'role'])->name('admin.role');
//         Route::get('/role', [ClientController::class, 'role'])->name('client.role');

    });