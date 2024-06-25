<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EmailController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;




Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});




Route::name('api.v1.')//va a scrivere nella prima parte del name->route
    ->prefix('v1')//va a inserirsi nel link del  sito
    ->middleware(['auth:sanctum'])
    ->group(function () {

   ////////////////// ROUTE CHANGE PASSWORD /////////////////////
    //FATTO ✔//
       Route::post('/change-password', [NewPasswordController::class, 'changePassword'])->name('change.password');
 
       ////////////////// ROUTE CHANGE EMAIL /////////////////////
    //FATTO ✔//
    Route::put('/update-email', [UserController::class, 'updateEmail'])->name('update.email');
       ////////////////// ROUTE CHANGE NAME AND SURNAME /////////////////////
    //FATTO ✔//
    Route::put('/update-profile', [UserController::class, 'updateProfile'])->name('update.profile');




    ////////////////// ROUTE PRODUCT /////////////////////
    //FATTO ✔//
      


        Route::post('/products/add',     [ProductController::class, 'add'])->name('products.add');//ADMIN
        Route::post('/products/{id}/edit',  [ProductController::class, 'edit'])->name('products.edit');//ADMIN
        Route::delete('/products/{id}',    [ProductController::class, 'delete'])->name('products.delete');//ADMIN



//////////////////// ROUTE ORDER /////////////////////
//FATTO ✔//
        Route::get('/orders',            [OrderController::class, 'index'])->name('orders.index');//ADMIN-CLIENT //http://127.0.0.1:8000/api/v1/orders

        Route::get('/orders/{order}',     [OrderController::class, 'show'])->name('orders.show');//ADMIN

        Route::delete('/orders/{id}',    [OrderController::class, 'delete'])->name('orders.delete');//ADMIN




//////////////////// ROUTE CART /////////////////////
//FATTO ✔//
        Route::get('/cart',            [CartController::class, 'index'])->name('cart.index');//CLIENT
        Route::delete('/carts/{id}',   [CartController::class, 'delete'])->name('carts.delete'); //CLIENT
        Route::post('/carts/{product}/add',       [CartController::class, 'add'])->name('carts.add'); //CLIENT
        Route::post('/buy-carts/',          [CartController::class, 'buy'])->name('carts.buy');//CLIENT

        

//////////////////// ROUTE REVIEW /////////////////////
//FATTO ✔//
       
        Route::post('/reviews/{id}/add',       [ReviewController::class, 'add'])->name('reviews.add');//CLIENT 
        Route::delete('/reviews/{id}',    [ReviewController::class, 'delete'])->name('reviews.delete');//CLIENT


//////////////////// ROUTE CATEGORY /////////////////////

Route::get('/category',       [CategoryController::class, 'list'])->name('categories.list');//ADMIN


    });

   

    Route::name('api.v1.')
    ->prefix('v1')
    ->group(function () {
        Route::get('/products',            [ProductController::class, 'index'])->name('products.index');// http://127.0.0.1:8000/api/v1/products
        Route::get('/products/{product}',  [ProductController::class, 'show'])->name('products.show');//http://127.0.0.1:8000/api/v1/products/id

        Route::get('/reviews',            [ReviewController::class, 'index'])->name('reviews.index');//TUTTI


        Route::post('/send-email', [EmailController::class, 'sendEmail']);

////////////////// ROUTE verification email  /////////////////////
//    TO DOOOOO Proveeee //
    
        Route::post('/email/verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
            return response()->json(['message' => 'Verification link sent!']);
        });
        


        Route::get('/verify-email/{id}/{hash}', function (EmailVerificationRequest $request, $id, $hash) {

            $request->fulfill();
            
            return response()->json(['redirect_url' => config('app.frontend_url')."/verify-email/$id/$hash" ]);
        })->withoutMiddleware('auth')->name('verification.verify');
       

        ///// FORGOT/RESET PASSWORD ///////
        Route::post('forgot-password',[ForgotPasswordController::class, 'sendResetLinkEmail']);

        ////Reset- To DOOO////
        Route::post('reset-password', [ResetPasswordController::class, 'reset']);
     
    });