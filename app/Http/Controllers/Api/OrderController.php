<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\OrderDetail;
use App\BillAddress;
use App\Events\NewOrder;
use App\Product;
use App\Variation;
use App\Events\OrderStatus;
use PDF;

class OrderController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $orders = Order::where('user_id', $user_id)->with('detail.product.images', 'detail.product.brand', 'detail.product.categories', 'detail.product.tags.tag', 'detail.variation.product.images', 'detail.variation.product.variations.Attri2.attribute', 'detail.variation.Attri2.attribute', 'detail.variation.Attri1.attribute', 'detail.variation.product.variations.Attri1.attribute', 'detail.variation.product.brand', 'detail.variation.product.categories', 'detail.variation.product.tags.tag', 'billAddress', 'payment.banks', 'payment.restrictions')->orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }
    public function slip($id)
    {
        $order = Order::where('id', $id)->with('user', 'detail.product.images', 'detail.product.brand', 'detail.product.categories', 'detail.product.tags.tag',  'detail.variation.product.images', 'detail.variation.Attri2.attribute', 'detail.variation.Attri1.attribute', 'detail.variation.product.variations.Attri2.attribute', 'detail.variation.product.variations.Attri1.attribute', 'detail.variation.product.brand', 'detail.variation.product.categories', 'detail.variation.product.tags.tag', 'billAddress', 'payment.banks', 'payment.restrictions')->first();
        $pdf_name = $order->order_id . '-' . time() . '.pdf';
        $slip = PDF::loadView('Pdf.slip', $order);
        return $slip->download($pdf_name);
    }
    public function show($id)
    {

        $orders = Order::where('id', $id)->with('user', 'detail.product.images', 'detail.product.brand', 'detail.product.categories', 'detail.product.tags.tag',  'detail.variation.product.images', 'detail.variation.Attri2.attribute', 'detail.variation.Attri1.attribute', 'detail.variation.product.variations.Attri2.attribute', 'detail.variation.product.variations.Attri1.attribute', 'detail.variation.product.brand', 'detail.variation.product.categories', 'detail.variation.product.tags.tag', 'billAddress', 'payment.banks', 'payment.restrictions')->first();
        return response()->json($orders);
    }
    public function noti()
    {
        $order = Order::where('seen', 0)->get();
        return response()->json(count($order));
    }
    public function all()
    {
        DB::table('orders')->where('seen', '=', 0)->update(['seen' => 1]);
        $orders = Order::with('detail', 'billAddress')->orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }
    public function store(Request $request)
    {
        $user_id = Auth::id();
        $data = $request->data;
        $Order = new Order();
        $Order->user_id = $user_id;
        $Order->payment_id = $data['selectedPayment']['id'];
        $Order->totalPrice = $data['totalPrice'];
        $Order->totalWeight = $data['totalWeight'];
        $Order->shippingPrice = $data['shippingPrice'];
        $Order->payment_method = $data['selectedPayment']['type'];
        $Order->userName = $data['userName'];
        $Order->email = $data['email'];
        $Order->phone = $data['phone'];
        $Order->save();
        $Order->order_id = '#' . str_pad($Order->id, 4, '0', STR_PAD_LEFT);
        $Order->save();

        $BillAddress = new BillAddress();
        $BillAddress->order_id = $Order->id;
        $BillAddress->state = $data['state'];
        $BillAddress->city = $data['city'];
        $BillAddress->addressLine1 = $data['addressLine1'];
        if (!empty($data['addressLine2'])) {
            $BillAddress->addressLine2 = $data['addressLine2'];
        }
        $BillAddress->save();
        foreach ($data['cart'] as $key => $detail) {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $Order->id;
            $orderDetail->quantity = $detail['addCart'];
            $orderDetail->product_type = $detail['type'];
            if ($detail['type'] === 'Simple Product') {
                $orderDetail->product_id = $detail['id'];
                $product = Product::where('id', $detail['id'])->first();
                $product->sold_out = (int)$product->sold_out + (int)$detail['addCart'];
                if ($product->stock === 'Manage Stock') {
                    $product->number_of_stock = (int)$product->number_of_stock - (int)$detail['addCart'];
                    if ($product->number_of_stock > 1) {
                        $product->stock = 'Out Of Stock';
                    }
                    $product->save();
                }
            }
            if ($detail['type'] === 'Variable Product') {
                $orderDetail->variation_id = $detail['id'];
                $Variation = Variation::where('id', $detail['id'])->first();
                $Variation->sold_out = (int)$Variation->sold_out + (int)$detail['addCart'];
                $product = Product::where('id', $Variation->product_id)->first();
                $product->sold_out = (int)$product->sold_out + (int)$detail['addCart'];
                $product->save();
                if ($Variation->stock === 'Manage Stock') {
                    $Variation->number_of_stock = (int)$Variation->number_of_stock - (int)$detail['addCart'];
                    if ($Variation->number_of_stock > 1) {
                        $Variation->stock = 'Out Of Stock';
                    }
                    $Variation->save();
                }
            }
            $orderDetail->save();
        }
        $order = Order::where('id', $Order->id)->with('user', 'detail.product.images', 'detail.product.brand', 'detail.product.categories', 'detail.product.tags.tag',  'detail.variation.product.images', 'detail.variation.Attri2.attribute', 'detail.variation.Attri1.attribute', 'detail.variation.product.variations.Attri2.attribute', 'detail.variation.product.variations.Attri1.attribute', 'detail.variation.product.brand', 'detail.variation.product.categories', 'detail.variation.product.tags.tag', 'billAddress', 'payment.banks', 'payment.restrictions')->first();

        $data = Auth::user();
        event(new NewOrder($data));
        return response()->json($order, 200);
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $paid = $request->paid;
        $order = Order::where('id', $id)->first();
        $order->status = $status;
        $order->paid = $paid;
        $order->save();
        broadcast(new OrderStatus($order));
        return response()->json('Success');
    }
    public function destroy($id)
    {
        Order::where('id', $id)->delete();
        return response()->json('success');
    }
}
