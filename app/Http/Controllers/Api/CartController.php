<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
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

        $cart =Cart::where('user_id', Auth::id())->first();

        if($cart === null){
            $cart= new Cart();
            $cart->status = 'confirm';
            $cart->user_id = Auth::id();
            $cart->save();
        }

        $existing_product= $cart->products()->where('product_id',$product->id)->first();



        if($existing_product){
            $cart->products()->updateExistingPivot($product->id, ["quantity"=>$existing_product->pivot->quantity+1]);
        } else{
            $product->carts()->attach($cart->id, ['quantity'=> 1]);
        }

       

        return response()->noContent();
        
    }

 

 
    public function buy()
    {
       
    
        if (Auth::user()->role !== "client") {
            abort(404); 
        }

        $cart= Cart::where('user_id', Auth::id())->first();
    
        // product ids nel carello di un utente
        $cartProducts = $cart->products()->get();

        
        if (empty($cartProducts)) {
            return response()->json(['message' => 'No products in the cart'], 400); // vedo se ci sono prodotti nel carello
        }
    
        //creo un nuovo ordine
        $order = new Order();
        $order->user_id = Auth::id();
        $order->save();
    
        // Add product to order
        foreach($cartProducts as $product){
        $order->products()->attach($product->id, ['quantity'=>$product->pivot->quantity, 'price'=>$product->price]);
        }
        
    
        // Ellimino i prodotti dal carello
        // $cart->products()->detach($cartProducts->pluck('id')->all());
        $cart->products()->detach();
        return response()->noContent();
    }



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
