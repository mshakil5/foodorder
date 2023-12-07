<?php

namespace App\Http\Controllers;

use App\Models\AdditionalItem;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderAdditionalItem;
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

        // dd($request->all());

        // new code
        $order = new Order();
        $order->invoiceno = date('Ymd-his');
        $order->date = date('Y-m-d');
        $order->collection_date = $request->collection_date;
        $order->collection_time = $request->collection_time;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->delivery_type = $request->delivery_type;
        $order->payment_type = $request->payment_type;
        if($order->save()){

            $net_amount = 0;
            foreach($request->input('parent_product_id') as $key => $value)
            {
                $orderDtl = new OrderDetail();
                $orderDtl->order_id = $order->id;
                $orderDtl->product_id = $request->get('parent_product_id')[$key];
                $orderDtl->product_name = $request->get('parent_product_name')[$key];
                $orderDtl->quantity = $request->get('parent_product_qty')[$key];
                $orderDtl->price_per_unit = $request->get('parent_product_price')[$key];
                $orderDtl->total_price = $request->get('parent_product_qty')[$key] * $request->get('parent_product_price')[$key];
                $orderDtl->save();
                $net_amount = $net_amount + $orderDtl->total_price;

                    foreach ($request->input('child_product_id') as $childkey => $childvalue) {
                        $childproduct = AdditionalItem::where('id', $request->get('child_product_id')[$childkey])->first();


                        if ($orderDtl->product_id == $request->get('related_parent_id')[$childkey]) {
                        $childitem = new OrderAdditionalItem();
                        $childitem->order_id = $order->id;
                        $childitem->order_detail_id = $orderDtl->id;
                        $childitem->additional_item_id = $request->get('child_product_id')[$childkey];
                        $childitem->item_name = $request->get('child_product_name')[$childkey];
                        $childitem->quantity = $request->get('child_product_qty')[$childkey];
                        $childitem->price_per_unit = $childproduct->amount;
                        $childitem->total_amount = $request->get('child_product_total_price')[$childkey];
                        $childitem->save();

                        }
                    }
                
                
            }
            
        $order->net_amount = $net_amount;
        $order->save();
            
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Thank you for this order.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message,'id'=>$order->id]);
        }


    }
}
