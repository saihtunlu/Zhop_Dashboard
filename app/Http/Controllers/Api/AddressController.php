<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $user_id = Auth::id();
        $data = $request->data;
        $address = new Address();
        $address->state = $data['state'];
        $address->city = $data['city'];
        $address->addressLine1 = $data['addressLine1'];
        if ($data['addressLine2']) {
            $address->addressLine2 = $data['addressLine2'];
        }
        $address->user_id = $user_id;
        $address->save();
        return response()->json($address,200, [], JSON_NUMERIC_CHECK);
    }
    public function index()
    {
        $user_id = Auth::id();
        $address = Address::where('user_id', $user_id)->first();
        return response()->json($address,200, [], JSON_NUMERIC_CHECK);
    }
    public function update(Request $request)
    {
        $data = $request->data;
        $address = Address::where('id', $data['id'])
            ->update([
                'state' => $data['state'],
                'city' => $data['city'],
                'addressLine1' => $data['addressLine1'],
                'addressLine2' => $data['addressLine2'],
            ]);
        return response()->json('Success');
    }
}
