<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::all();
        // voglio vedere solo il carello del cliente logato
        
        return $cart;
    }

    public function add()
    {
        // 
    }

 
    public function buy(Cart $cart)
    {
        //
    }

    public function delete(Cart $cart)
    {
        //
    }
}
