<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Fav;

class FavController extends Controller
{
    public function store(Request $request)
    {
        $user_id = Auth::id();
        $product_id = $request->id;
        $Fav = new Fav();
        $Fav->product_id = $product_id;
        $Fav->user_id = $user_id;
        $Fav->save();
        return response()->json('success');
    }
    public function show()
    {
        $user_id = Auth::id();
        $Fav = Fav::where('user_id', $user_id)->with('product.images', 'product.variations.Attri2.attribute', 'product.variations.Attri1.attribute', 'product.brand', 'product.categories', 'product.tags.tag')->get();
        return response()->json($Fav);
    }
    public function remove(Request $request)
    {
        $user_id = Auth::id();
        $product_id = $request->id;
        Fav::where([['user_id', $user_id], ['product_id', $product_id]])->delete();
        return response()->json('success');
    }
}
