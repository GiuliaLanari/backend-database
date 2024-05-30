<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    
    
    public function index()
    {
        $products = Product::with('category')->get();
        return $products;
       
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);
        if (!$product) {
            return response(['message' => 'Not found'], 404);
        }
  
        return [
            'data' => $product
        ];
    }

    public function add (Request $request)
    {
        if(Auth::user()->role !== "admin") abort(404);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'picture' => ['nullable', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'], 
            
        ]);

        
        $data = $request->all();
        $newProduct = new Product();
        $newProduct->title = $data["title"];
        $newProduct->picture = $data["picture"];
        $newProduct->description = $data["description"];
        $newProduct->price = $data["price"];
        // $newProduct->category_id = $data["category_id"]; //da sistemare categorie
        $newProduct->category_id = 2;
        $newProduct->save();

        return response()->json($newProduct, 201);

    }

    
    
    public function edit(Request $request, $id)
    {

        if(Auth::user()->role !== "admin") abort(404);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'picture' => ['nullable', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'], 
            
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $data = $request->all();
        $product->title = $data["title"];
        $product->picture = $data["picture"];
        $product->description = $data["description"];
        $product->price = $data["price"];
        // $product->category_id = $data["category_id"];
        $product->category_id = 2;
        $product->update();

        return response()->json($product, 200);
    }
    
  

    
    public function delete($id)
    
    {
        if(Auth::user()->role !== "admin") abort(404);

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $product->carts()->detach();
        $product->orders()->detach();
        
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);  
    }
}
