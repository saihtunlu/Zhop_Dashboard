<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Payment;
use App\Bank;
use App\Restriction;
use App\RestrictedCity;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('banks', 'restrictions.shipping.cities', 'restrictions.cities')->get();
        return response()->json($payments);
    }
    public function show($id)
    {
        $payment = Payment::where('id', $id)->with('banks', 'restrictions.shipping.cities', 'restrictions.cities')->first();
        return response()->json($payment);
    }
    public function store(Request $request)
    {
        $data = $request->data;
        $Payment = new Payment();
        $Payment->type = $data['type'];
        if ($data['description']) {
            $Payment->description = $data['description'];
        }
        $Payment->save();
        if ($data['type'] === 'Bank Direct Transfer') {
            $banks = $data['banks'];
            foreach ($banks as $key => $value) {
                $Bank = new Bank();
                $Bank->accNumber = $value['accNumber'];
                $Bank->bankName = $value['bankName'];
                $Bank->holderName = $value['holderName'];
                $Bank->payment_id = $Payment->id;
                $Bank->save();
            }
        }
        $restrictions = $data['restrictions'];
        foreach ($restrictions as $key => $data) {
            $restriction = new Restriction();
            $restriction->condition = $data['condition'];
            $restriction->by = $data['by'];
            if ($data['by'] === 'Shipping') {
                $restriction->shipping_id = $data['shipping_id'];
            }
            if ($data['by'] === 'Price') {
                $restriction->price = $data['price'];
            }
            $restriction->payment_id = $Payment->id;
            $restriction->save();

            if ($data['by'] === 'Cities') {
                foreach ($data['cities'] as $index => $value) {
                    $city = new RestrictedCity();
                    $city->value = $value;
                    $city->restriction_id = $restriction->id;
                    $city->save();
                }
            }
        }
        return response()->json($Payment);
    }
    public function update(Request $request)
    {
        $data = $request->data;
        $Payment = Payment::where('id', $data['id'])->get();
        $Payment->type = $data['type'];
        if ($data['description']) {
            $Payment->description = $data['description'];
        }
        $Payment->save();
        if ($data['type'] === 'Bank Direct Transfer') {
            $banks = $data['banks'];
            Bank::where('payment_id', $Payment->id)->delete();
            foreach ($banks as $key => $value) {
                $Bank = new Bank();
                $Bank->accNumber = $value['accNumber'];
                $Bank->bankName = $value['bankName'];
                $Bank->holderName = $value['holderName'];
                $Bank->payment_id = $Payment->id;
                $Bank->save();
            }
        }
        $restrictions = $data['restrictions'];
        Restriction::where('payment_id', $Payment->id)->delete();
        foreach ($restrictions as $key => $data) {
            $restriction = new Restriction();
            $restriction->condition = $data['condition'];
            $restriction->by = $data['by'];
            if ($data['by'] === 'Shipping') {
                $restriction->shipping_id = $data['shipping_id'];
            }
            if ($data['by'] === 'Price') {
                $restriction->price = $data['price'];
            }
            $restriction->payment_id = $Payment->id;
            $restriction->save();

            if ($data['by'] === 'Cities') {
                foreach ($data['newCities'] as $index => $value) {
                    $city = new RestrictedCity();
                    $city->value = $value;
                    $city->restriction_id = $restriction->id;
                    $city->save();
                }
            }
        }
        return response()->json(['Success']);
    }

    public function destroy($id)
    {
        Payment::where('id', $id)->delete();
        return response()->json('success');
    }
}
