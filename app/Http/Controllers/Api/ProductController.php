<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    
    
    public function index()
    {
        $products = Product::with('category')->get();
        return [
            'data' => $products,
        ];
       
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
            'picture' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'], 
            'category_id' => ['required', 'string'], 
            
        ]);

        $file_path = $request['picture'] ? Storage::put('/product-img', $request['picture']) : null;

        $data = $request->all();
        $newProduct = new Product();
        $newProduct->title = $data["title"];
        $newProduct->picture= 'storage/' . $file_path ;
        $newProduct->description = $data["description"];
        $newProduct->price = $data["price"];
        $newProduct->category_id = $data["category_id"]; 
    
        $newProduct->save();

        return response()->json($newProduct, 201);

    }

    
    
    public function edit(Request $request, $id)
    {

    
        if(Auth::user()->role !== "admin") abort(404);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'picture' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'], 
            'category_id' => ['required', 'string'], 
             
            
        ]);

        $product = Product::find($id);
        $file_path = $request['picture'] ? 'storage/' . Storage::put('/product-img', $request['picture']) : $product->picture;

        if (!$product) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $data = $request->all();
        $product->title = $data["title"];
        $product->picture= $file_path  ;
        $product->description = $data["description"];
        $product->price = $data["price"];
        $product->category_id = $data["category_id"];
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
