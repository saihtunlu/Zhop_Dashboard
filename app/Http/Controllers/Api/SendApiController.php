<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Payment;
use App\Shipping;
use App\Category1;
use App\Event;
use App\General;
use App\Theme;
use App\Attribute;

class SendApiController extends Controller
{
    public function index()
    {
        $data = [];
        $products = Product::with('images', 'variations.Attri2.attribute', 'variations.Attri1.attribute', 'brand', 'categories', 'tags.tag')->orderBy('created_at', 'desc')->get();
        $payments = Payment::with('banks', 'restrictions.shipping.cities', 'restrictions.cities')->get();
        $shippings = Shipping::with('cities', 'methods')->get();
        $categories = Category1::with('children.children')->get();
        $variations = Attribute::with('details')->get();
        $events = Event::get();
        $general = General::first();
        $themes = Theme::get();
        $data['products'] = $products;
        $data['events'] = $events;
        $data['payments'] = $payments;
        $data['general'] = $general;
        $data['themes'] = $themes;
        $data['shippings'] = $shippings;
        $data['variations'] = $variations;
        $data['categories'] = $categories;
        return response()->json($data,200, [], JSON_NUMERIC_CHECK);
    }
}
