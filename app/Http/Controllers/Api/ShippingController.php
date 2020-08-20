<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shipping;
use App\Method;

class ShippingController extends Controller
{
    public function index()
    {
        $shippings = Shipping::with('cities', 'methods')->get();
        return response()->json($shippings,200, [], JSON_NUMERIC_CHECK);
    }

    public function store(Request $request)
    {
        $data = $request->data;
        $Shipping = new Shipping();
        $Shipping->title = $data['title'];
        $Shipping->description = $data['description'];
        $Shipping->save();
        $cities = $data['cities'];
        foreach ($cities as $key => $city) {
            $City = new City();
            $City->shipping_id = $Shipping->id;
            $City->value = $city;
            $City->save();
        }
        $methods = $data['methods'];
        foreach ($methods as $key => $method) {
            $Method = new Method();
            $Method->shipping_id = $Shipping->id;
            $Method->label = $method['label'];
            $Method->type = $method['type'];
            if ($method['type'] === 'Weight Based') {
                $Method->initialPrice = $method['initialPrice'];
                $Method->initialWeight = $method['initialWeight'];
                $Method->pricePerKg = $method['pricePerKg'];
            } else {
                $Method->price = $method['price'];
            }
            $Method->isCondition = $method['isCondition'];
            $Method->by = $method['by'];
            $Method->with = $method['with'];
            $Method->condition = $method['condition'];
            $Method->save();
        }
        return response()->json('Success');
    }

    public function update(Request $request)
    {
        $data = $request->data;
        $cities = $request->cities;


        $Shipping = Shipping::where('id', $data['id'])->get();
        $Shipping->title = $data['title'];
        $Shipping->description = $data['description'];
        $Shipping->save();

        City::where('shipping_id', $Shipping->id)->delete();
        foreach ($cities as $key => $city) {
            $City = new City();
            $City->shipping_id = $Shipping->id;
            $City->value = $city;
            $City->save();
        }
        $methods = $data['methods'];
        Method::where('shipping_id', $Shipping->id)->delete();
        foreach ($methods as $key => $method) {
            $Method = new Method();
            $Method->shipping_id = $Shipping->id;
            $Method->label = $method['label'];
            $Method->type = $method['type'];
            if ($method['type'] === 'Weight Based') {
                $Method->initialPrice = $method['initialPrice'];
                $Method->initialWeight = $method['initialWeight'];
                $Method->pricePerKg = $method['pricePerKg'];
            } else {
                $Method->price = $method['price'];
            }
            $Method->isCondition = $method['isCondition'];
            $Method->by = $method['by'];
            $Method->with = $method['with'];
            $Method->condition = $method['condition'];
            $Method->save();
        }
        return response()->json('Success');
    }

    public function show($id)
    {
        $shipping = Shipping::where('id', $id)->with('cities', 'methods')->first();
        return response()->json($shipping,200, [], JSON_NUMERIC_CHECK);
    }
    public function destroy($id)
    {
        Shipping::where('id', $id)->delete();
        return response()->json('success');
    }
}
