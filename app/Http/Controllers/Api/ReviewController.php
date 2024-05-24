<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

class ReviewController extends Controller
{
   
    public function index()
    {
        $reviews = Review::all();
        //come faccio a recuperare l'utente e il prodotto?
        return $reviews;
    }

    
    // public function add(Product $request)
    // {
    //     $date= $request->all();

        //     $newReview= new Product();
        //     $newReview->rating=$date["rating"];
        //     $newReview->comment=$date["comment"];
        //     $newReview->user_id=$request->user()->id;
        //     $newReview->product_id=$request->product()->id;
        //     $newProduct->save();
    
        //     return $date;
        //     // return  redirect()->route("reviews.index");
    // }

  
    public function delete(Review $review)
    {
        //
    }
}
