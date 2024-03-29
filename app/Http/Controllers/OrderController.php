<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmMail;
use App\Models\AdditionalItem;
use App\Models\ContactMail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderAdditionalItem;
use App\Models\Order;
use App\Models\OrderDetail;
use Mail;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orderStore(Request $request){

        
        session(['name' => $request->name]);
        session(['email' => $request->email]);
        session(['phone' => $request->phone]);
        session(['house' => $request->house]);
        session(['street' => $request->street]);
        session(['city' => $request->city]);
        session(['postcode' => $request->postcode]);

        $productIDs = $request->input('parent_product_id');
        if($productIDs == "" ){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill Product field.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"Name\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->email)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"Email\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->phone)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"contact number\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->collection_time)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"Delivery time field\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->delivery_type)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"Collection or Delivery\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if ($request->delivery_type == "Delivery") {
            if(empty($request->house)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"house\" field..!</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }

            if(empty($request->city)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"city\" field..!</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }

            if(empty($request->street)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"street\" field..!</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }

            if(empty($request->postcode)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"postcode\" field..!</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }
        }
        

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
        $order->house = $request->house;
        $order->city = $request->city;
        $order->note = $request->note;
        $order->street = $request->street;
        $order->postcode = $request->postcode;
        $order->delivery_type = $request->delivery_type;
        $order->discount = $request->discount_amount;
        $order->payment_type = "Cash";
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
                $orderDtl->save();

                    $additional_item_total_amount = 0;
                    if ($request->input('child_product_id')) {
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
                            $additional_item_total_amount = $additional_item_total_amount + $childitem->total_amount;
                            }
                        }
                    }
                    
                
                    $orderDtl->total_price = $request->get('parent_product_qty')[$key] * $request->get('parent_product_price')[$key] + $additional_item_total_amount;
                    $orderDtl->additional_item_total_price = $additional_item_total_amount;
                    $orderDtl->save();
                    $net_amount = $net_amount + $orderDtl->total_price;
                
            }
            
        $order->total_amount = $net_amount;
        $order->net_amount = $net_amount - $request->discount_amount;
        if ($order->save()) {

            $keysToClear = ['cart'];
            session()->forget($keysToClear);


                $adminmail = ContactMail::where('id', 1)->first()->email;
                $contactmail = $request->email;
                $ccEmails = $adminmail;
                $msg = "Thank you for your order.";

                $orderDtls = OrderDetail::with('orderadditionalitem')->where('order_id', $order->id)->get();
                
                if (isset($msg)) {
                    $array['name'] = $request->name;
                    $array['email'] = $request->email;
                    $array['phone'] = $request->phone;
                    $array['house'] = $request->house;
                    $array['city'] = $request->city;
                    $array['street'] = $request->street;
                    $array['postcode'] = $request->postcode;
                    $array['note'] = $request->note;
                    $array['invoiceno'] = $order->invoiceno;
                    $array['payment_type'] = $order->payment_type;
                    $array['delivery_type'] = $order->delivery_type;
                    $array['collection_time'] = $order->collection_time;
                    $array['collection_date'] = $order->collection_date;
                    $array['orderDtls'] = $orderDtls;
                    $array['date'] = $order->date;
                    $array['discount'] = $order->discount;
                    $array['net_amount'] = $order->net_amount;
                    $array['subject'] = "Order Booking Confirmation";
                    $array['message'] = $msg;
                    $array['contactmail'] = $contactmail;
        
                    Mail::to($contactmail)
                        ->cc($ccEmails)
                        ->send(new OrderConfirmMail($array));
        
                }

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Thank you for this order.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message,'id'=>$order->id]);


        } else {
            $message ="<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Server Error!!.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message,'id'=>$order->id]);
        }
        
            
            
        }


    }



    public function storeDataInSession(Request $request)
    {

        $cart = session()->get('cart', []);
        if(isset($cart[$request->pid])) {
            
        }  else {
            $cart[$request->pid] = [
                "product_items" => $request->sessionData
            ];
        }
 
        session()->put('cart', $cart);

        // $arrayData = session('add_to_card_item', []);
        // $newElement = $request->input('sessionData');
        // $arrayData[] = $newElement;
        // // Store data in the session
        // session(['add_to_card_item' => $arrayData]);
        return response()->json(['message' => 'Data stored successfully','arrayData'=>$cart]);
    }

    public function clearSpecificSessionData(Request $request)
    {
        session()->flush();
        session()->regenerate();

        session()->flush();
        session()->regenerate();


        $cart = session()->get('cart', []);
        if(isset($cart[$request->pid])) {
            
        }  else {
            $cart[$request->pid] = [
                "product_items" => $request->data
            ];
        }
 
        session()->put('cart', $cart);

        return response()->json(['message' => 'Specific session data cleared','data'=>$cart]);
    }


    public function orderConfirmation($id)
    {
        
        $data = Order::where('id', $id)->first();

        $orderdetails = OrderDetail::with('orderadditionalitem')->where('order_id', $id)->get();
        
        return view('frontend.orderconfirmation', compact('data','orderdetails'));
    }


}
