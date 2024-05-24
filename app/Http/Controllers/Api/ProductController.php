<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::with('category')->get();
        return $products;
        // $products = Product::all();
        // // mi permette di visualizzare tutti i prodotti
        // //COME POSSO ESPANDERE CATEGORY
        // return $products;
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

    public function add (Product $request)
    {
        $data = $request->all();
        $newProduct = new Product();
        $newProduct->title = $data["title"];
        $newProduct->description = $data["description"];
        $newProduct->price = $data["price"];
        $newProduct->category_id = $data["category_id"];
        $newProduct->save();

        return response()->json($newProduct, 201);
        // $date= $request->all();

        // $newProduct= new Product();
        // $newProduct->title=$date["title"];
        // // $newProduct->picture=$date["picture"];
        // // $newProduct->summary=$date["summary"];
        // $newProduct->description=$date["description"];
        // $newProduct->price=$date["price"];
        // $newProduct->category_id=$request->category()->id;
        // $newProduct->save();

        // return $date;
        // return  redirect()->route("products.index");
    }

    
    
    public function edit(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $data = $request->all();
        $product->title = $data["title"];
        $product->description = $data["description"];
        $product->price = $data["price"];
        $product->category_id = $data["category_id"];
        $product->save();

        return response()->json($product, 200);
    }
    
  

    
    public function delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);  
    }
}
