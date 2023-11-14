<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AdditionalItem;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orderStore(Request $request){

        // $productIDs = $request->input('product_id');
        // if($productIDs == "" ){
        //     $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill Product field.</b></div>";
        //     return response()->json(['status'=> 303,'message'=>$message]);
        //     exit();
        // }
        
        // if(empty($request->grand_total)){
        //     $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"Product\" field..!</b></div>";
        //     return response()->json(['status'=> 303,'message'=>$message]);
        //     exit();
        // }

        // new code
        $order = new Order();
        $order->invoiceno = date('Ymd-his');
        $order->date = date('Y-m-d');
        $order->collection_date = $request->collection_date;
        $order->collection_time = $request->collection_time;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        if($order->save()){

            // foreach($request->input('product_id') as $key => $value)
            // {
            //     $orderDtl = new OrderDetail();
            //     $orderDtl->invoiceno = $order->invoiceno;
            //     $orderDtl->order_id = $order->id;
            //     $orderDtl->product_id = $request->get('product_id')[$key];
            //     $orderDtl->quantity = $request->get('quantity')[$key];
            //     $orderDtl->sellingprice = $request->get('sellingprice')[$key];
            //     $orderDtl->total_amount = $request->get('quantity')[$key] * $request->get('sellingprice')[$key];
            //     $orderDtl->created_by = Auth::user()->id;
            //     $orderDtl->save();
            // }
            
            
            
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Thank you for this order.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message,'id'=>$order->id]);
        }


    }
}
