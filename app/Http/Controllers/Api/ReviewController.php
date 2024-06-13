<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

class ReviewController extends Controller
{
   
    public function index()
    {
          
    if (auth()->check()) {
      
        if (auth()->user()->role === 'client') {
           
            $reviews = Review::with('user', 'product')
                ->where('user_id', auth()->id())
                ->get();
        } else {
           
            $reviews = Review::with('user', 'product')->get();
        }
    } else {
    
        $reviews = Review::with('user', 'product')->get();
    }

    return $reviews;
    }

    
    public function add(Request $request, $id)
    {
         if(Auth::user()->role !== "client") abort(404);
        $request->validate([
            'rating' => ['required', 'numeric', 'max:5'],
            'comment' => ['required', 'string'],
            
            
        ]);

        $date= $request->all();

            $newReview= new Review();
            $newReview->rating=$date["rating"];
            $newReview->comment=$date["comment"];
            $newReview->user_id=$request->user()->id;
            $newReview->product_id=$id;
            $newReview->save();
    
            return response()->json($newReview, 201);
           
    }

  
    public function delete(Review $review, $id)
    {
         if(Auth::user()->role !== "client") abort(404);

         $review = Review::find($id);

         if (!$review) {
             return response()->json(['message' => 'Not found'], 404);
         }
 
        //  $review->users()->detach();
        //  $review->product()->detach();
         
         $review->delete();
 
         return response()->json(['message' => 'Review deleted successfully'], 200); 
    }
}
