<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Brand;
use App\Order;
use Illuminate\Support\Facades\DB;
use App\CalendarEvent;
use Carbon\Carbon;
use App\Product;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function invoice($Year)
    {
        $monthly = DB::table("invoices")
            ->where([['status', 'Paid'], [DB::raw("YEAR(create_date)"), $Year]])
            ->select(DB::raw('sum(grand_total) as total'), DB::raw('sum(primary_total) as primary_total'), DB::raw('MONTH(create_date) as months'))
            ->orderBy('created_at')
            ->groupBy(DB::raw("MONTH(create_date)"))
            ->get();
        return response()->json($monthly);
    }

    public function order(Request $request)
    {
        $Date = $request->date;
        $monthly = DB::table("orders")
            ->where([[DB::raw("YEAR(created_at)"), $Date[0]], [DB::raw("MONTH(created_at)"), $Date[1]]])
            ->select(DB::raw('sum(totalPrice) as total'), DB::raw('count(id) as count'),  DB::raw('DAY(created_at) as day'))
            ->orderBy('created_at')
            ->groupBy(DB::raw("DAY(created_at)"))
            ->get();
        return response()->json($monthly);
    }

    public function calendar()
    {
        $user_id = Auth::id();
        $calendar = CalendarEvent::where('user_id', $user_id)->get();
        // $order = OrderDetail::select(DB::raw('COUNT(id) as cnt', 'product_id'))->groupBy('product_id')->orderBy('cnt', 'DESC')->first();
        return response()->json($calendar);
    }
    public function count()
    {
        $count = [];
        $products = Product::get();
        $customer = User::where('type', 'Customer')->get();
        $order = order::get();
        $brand = Brand::get();
        $count['product'] = count($products);
        $count['customer'] = count($customer);
        $count['order'] = count($order);
        $count['brand'] = count($brand);
        return response()->json($count);
    }
    public function sellProduct()
    {
        $products = Product::with('images', 'variations.Attri2.attribute', 'variations.Attri1.attribute', 'brand', 'categories', 'tags.tag')->orderBy('sold_out', 'desc')->limit(6)->get();
        return response()->json($products);
    }
}
