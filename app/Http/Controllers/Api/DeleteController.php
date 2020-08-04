<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Invoice;

class DeleteController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->id;
        $type = $request->type;
        if ($type === 'User') {
            foreach ($data as $key => $id) {
                User::where('id', $id)->delete();
            }
        }
        if ($type === 'Product') {
            foreach ($data as $key => $id) {
                Product::where('id', $id)->delete();
            }
        }
        if ($type === 'Invoice') {
            foreach ($data as $key => $id) {
                Invoice::where('id', $id)->delete();
            }
        }
        return response()->json(['success']);
    }
}
