<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderAdditionalItem;
use App\Models\AdditionalItem;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Mail\OrderConfirmMail;
use Mail;
use Illuminate\Http\RedirectResponse;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function store(Request $request)
    {
        $order = new Order();
        $order->invoiceno = date('Ymd-his');
        $order->date = date('Y-m-d');
        $order->collection_date = $request->collection_date;
        $order->collection_time = $request->collection_time;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
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
                $orderDtl->save();
                    $additional_item_total_amount = 0;
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
                
                $orderDtl->total_price = $request->get('parent_product_qty')[$key] * $request->get('parent_product_price')[$key] + $additional_item_total_amount;
                $orderDtl->additional_item_total_price = $additional_item_total_amount;
                $orderDtl->save();
                $net_amount = $net_amount + $orderDtl->total_price;
            }
        $order->net_amount = $net_amount;
        $order->save();
        }
    }



    public function payment(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'collection' => 'required'
        ], [
            'collection.required' => 'Collection field is required.'
        ]);

        if ($request->collection == "Delivery") {
            $validatedData = $request->validate([
                'parent_product_id' => 'required',
                'name' => 'required',
                'collection' => 'required',
                'timeslot' => 'required',
                'phone' => 'required',
                'house' => 'required',
                'street' => 'required',
                'city' => 'required',
                'postcode' => 'required'
            ], [
                'name.required' => 'Name field is required.',
                'timeslot.required' => 'Delivery time field is required.',
                'parent_product_id.required' => 'Please, choose a product.'
            ]);
        } else {
            $validatedData = $request->validate([
                'parent_product_id' => 'required',
                'name' => 'required',
                'collection' => 'required',
                'timeslot' => 'required',
                'phone' => 'required'
            ], [
                'name.required' => 'Name field is required.',
                'timeslot.required' => 'Delivery time field is required.',
                'parent_product_id.required' => 'Please, choose a product.'
            ]);
        }

        session(['name' => $request->name]);
        session(['email' => $request->email]);
        session(['phone' => $request->phone]);
        session(['house' => $request->house]);
        session(['street' => $request->street]);
        session(['city' => $request->city]);
        session(['postcode' => $request->postcode]);
        
        
        session(['alldata' => $request->all()]);
        session(['net_total_value' => $request->net_total_value]);
        $net_total_value = session('net_total_value');
        $request->session()->forget('net_total_value');
        // dd($net_total_value);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
  
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success'),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "GBP",
                        "value" => $net_total_value
                    ]
                ]
            ]
        ]);
  
        if (isset($response['id']) && $response['id'] != null) {
  
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
  
            return redirect()
                ->route('cancel.payment')
                ->with('error', 'Something went wrong.');
  
        } else {
            return redirect()
                ->route('homepage')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    
    }

    public function cancel()
    {
        return redirect()
              ->route('homepage')
              ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    public function success(Request $request)
    {
        // dd($request->all());
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        // dd($response);
  
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            
            $alldata = session('alldata');
            // dd($alldata);
            // data store start
            $order = new Order();
            $order->invoiceno = date('Ymd-his');
            $order->date = date('Y-m-d');
            $order->collection_date = $alldata['date'];
            $order->collection_time = $alldata['timeslot'];
            $order->name = $alldata['name'];
            $order->email = $alldata['email'];
            $order->phone = $alldata['phone'];
            $order->house = $alldata['house'];
            $order->city = $alldata['city'];
            $order->street = $alldata['street'];
            $order->postcode = $alldata['postcode'];
            $order->delivery_type = $alldata['collection'];
            $order->discount = $alldata['discount_amount'];
            $order->payment_type = "Paypal";
            if($order->save()){
                $net_amount = 0;
                foreach($alldata['parent_product_id'] as $key => $value)
                {
                    $orderDtl = new OrderDetail();
                    $orderDtl->order_id = $order->id;
                    $orderDtl->product_id = $alldata['parent_product_id'][$key];
                    $orderDtl->product_name = $alldata['parent_product_name'][$key];
                    $orderDtl->quantity = $alldata['parent_product_qty'][$key];
                    $orderDtl->price_per_unit = $alldata['parent_product_price'][$key];
                    $orderDtl->save();
                        $additional_item_total_amount = 0;

                        if (isset($alldata['child_product_id'])) {
                            foreach ($alldata['child_product_id'] as $childkey => $childvalue) {
                                $childproduct = AdditionalItem::where('id', $alldata['child_product_id'][$childkey])->first();
                                if ($orderDtl->product_id == $alldata['related_parent_id'][$childkey]) {
                                $childitem = new OrderAdditionalItem();
                                $childitem->order_id = $order->id;
                                $childitem->order_detail_id = $orderDtl->id;
                                $childitem->additional_item_id = $alldata['child_product_id'][$childkey];
                                $childitem->item_name = $alldata['child_product_name'][$childkey];
                                $childitem->quantity = $alldata['child_product_qty'][$childkey];
                                $childitem->price_per_unit = $childproduct->amount;
                                $childitem->total_amount = $alldata['child_product_total_price'][$childkey];
                                $childitem->save();
                                $additional_item_total_amount = $additional_item_total_amount + $childitem->total_amount;
                                }
                            }
                        }

                    $orderDtl->total_price = $alldata['parent_product_qty'][$key] * $alldata['parent_product_price'][$key] + $additional_item_total_amount;
                    $orderDtl->additional_item_total_price = $additional_item_total_amount;
                    $orderDtl->save();
                    $net_amount = $net_amount + $orderDtl->total_price;
                }
                
            $order->total_amount = $net_amount;
            $order->net_amount = $net_amount - $alldata['discount_amount'];

                if ($order->save()) {

                    // clear session items
                    $keysToClear = ['cart'];
                    session()->forget($keysToClear);



                    $adminmail = "kmushakil71@gmail.com";
                    $contactmail = $request->email;
                    $ccEmails = "kmushakil93@gmail.com";
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

                            // this is use for paypal function
                        $request->session()->forget('alldata');

                        return redirect()
                            ->route('confirmorder', $order->id)
                            ->with('success', 'Thank you for this order.');
                        
                                }
                }
            }
            // data store end
            
            
        } else {
            return redirect()
                ->route('homepage')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }



}
