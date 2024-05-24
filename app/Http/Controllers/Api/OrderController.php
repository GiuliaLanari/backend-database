<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    
    public function index()
    {
        $orders = Order::all();
        //COME POSSO VEDERE ANCHE TABELLA PONTE
        return $orders;
    }

    public function show($id)
    {

        //VORREI RECUPERARE ANCHE I PRODOTTI ORDINE
        $orders = Order::with('user')->find($id);
        if (!$orders) {
            return response(['message' => 'Not found'], 404);
        }
  
        return [
            'order' => $orders
        ];
    }
    
    public function confirm()
    {
     //
    }

   
    public function delete(Order $order)
    {
        //
    }
}
