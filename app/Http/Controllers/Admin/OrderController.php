<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getAllOrder()
    {
        $data = Order::orderby('id','DESC')->get();
        return view('admin.order.index', compact('data'));
    }

    public function getOrderDetails($id)
    {
        
        $data = Order::where('id', $id)->first();
        $orders = OrderDetail::with('orderadditionalitem')->where('order_id', $id)->orderby('id','DESC')->get();

        // dd($data);
        return view('admin.order.orderdetails', compact('data','orders'));
    }
}
