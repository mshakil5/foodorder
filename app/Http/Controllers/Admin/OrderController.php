<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getAllOrder()
    {
        $data = Order::orderby('id','DESC')->get();
        return view('admin.order.index', compact('data'));
    }
}
