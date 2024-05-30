<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    
    public function index()
    {
        if(Auth::user()->role !== "client") abort(404);

        if(Auth::user()->role === "client") {
            $cart = Cart::with('user','products')->where('user_id', Auth::id())->get();

        }

        return [
            'data' => $cart
        ];
    }



    public function add(Product $product)
    {
      
        if(Auth::user()->role !== "client") abort(404);

        $cart_id=Cart::where('user_id', Auth::id())->get();
        $product->carts()->attach($cart_id, ['quantity'=> 1]);

        return response()->noContent();
        
    }


 
    // public function buy(Cart $cart)
    // {
    //     if(Auth::user()->role !== "client") abort(404);

    //     $cart_id=Cart::where('user_id', Auth::id())->get();
    //     $cart->orders()->attach();

    //     return response()->noContent();
    // }

    public function delete($id)
    {
        if(Auth::user()->role !== "client") abort(404);

        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json(['message' => 'Not found'], 404);
        }

       
        $cart->products()->detach();
        
        $cart->delete();

        return response()->json(['message' => 'Element deleted successfully'], 200);  
    }
}
