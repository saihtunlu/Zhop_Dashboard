<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rating;

class RatingController extends Controller
{
    public function setRating(Request $request)
    {
        $rating = $request->rating;
        $product_id = $request->product_id;
        $user_id = Auth::id();

        $Rating = new Rating;
        $Rating->rating = $rating;
        $Rating->product_id = $product_id;
        $Rating->user_id = $user_id;
        $Rating->save();
        return response($request);
    }
    public function getRating($id)
    {
        $Rating = Rating::where('product_id', $id)
            ->get();
        return response($Rating);
    }
}
