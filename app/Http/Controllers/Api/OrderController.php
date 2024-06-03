<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    
    public function index()
    {
       
        if(Auth::user()->role === "admin") {
            $orders = Order::with('user', 'products')->get();
            
        }

        if(Auth::user()->role === "client") {
            $orders = Order::with('user','products')->where('user_id', Auth::id())->get();

            
        }

        return [
            'data' => $orders
        ];
    }



    public function show($id)
    {
        if(Auth::user()->role !== "admin") abort(404);
        
        $order = Order::with('user','products')->find($id);

        
        
        if (!$order) {
            return response(['message' => 'Not found'], 404);
        }

        if($order->user_id !== Auth::user()->id)abort(404);

        return [
            'data' => $order
        ];
    }
    


   
    public function delete($id)
    {
        if(Auth::user()->role !== "admin") abort(404);

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Not found'], 404);
        }

       
        $order->products()->detach();
        
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);  
    }
}
