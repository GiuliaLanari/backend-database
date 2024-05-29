<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
   
    public function index()
    {
        $reviews = Review::with('user', 'product')->get();
        
        return $reviews;
    }

    
    public function add(Request $request)
    {
        //  if(Auth::user()->role !== "client") abort(404);
        $request->validate([
            'rating' => ['required', 'numeric', 'max:5'],
            'comment' => ['required', 'string'],
            // 'user_id' => ['required', 'string'],
            // 'product_id' => ['required', 'numeric'], 
            
        ]);

        $date= $request->all();

            $newReview= new Review();
            $newReview->rating=$date["rating"];
            $newReview->comment=$date["comment"];
            $newReview->user_id=3;
            $newReview->product_id= 3;
            // $newReview->user_id=$request->user()->id;
            // $newReview->product_id=$request->product()->id;///da sistemare
            $newReview->save();
    
            return response()->json($newReview, 201);
           
    }

  
    public function delete(Review $review, $id)
    {
         // if(Auth::user()->role !== "client") abort(404);

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
