<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderAdditionalItem;
use App\Models\AdditionalItem;
use App\Models\Order;
use App\Models\OrderDetail;
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


        // $rules = [
        //     'house' => 'required',
        //     'net_total_value' => 'required',
        // ];
        // $customMessages = [
        //     'required' => 'The :attribute field is required.',
        //     'net_total_value.required' => 'Please select a product.'
        // ];
        // $this->validate($request, $rules, $customMessages);

        // dd($request->all());

        if ($request->collection == "Delivery") {
            $validatedData = $request->validate([
                'name' => 'required',
                'collection' => 'required',
                'phone' => 'required',
                'house' => 'required',
                'street' => 'required',
                'city' => 'required',
                'postcode' => 'required',
                'parent_product_id' => 'required'
            ], [
                'name.required' => 'Name field is required.',
                'parent_product_id.required' => 'Please, choose a product.'
            ]);
        } else {
            $validatedData = $request->validate([
                'name' => 'required',
                'collection' => 'required',
                'phone' => 'required',
                'parent_product_id' => 'required'
            ], [
                'name.required' => 'Name field is required.',
                'parent_product_id.required' => 'Please, choose a product.'
            ]);
        }
        

        

        
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
            $order->payment_type = $alldata['payment'];
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
            $order->net_amount = $net_amount;
            $order->save();
            }
            // data store end
            
            $request->session()->forget('alldata');

            return redirect()
                ->route('homepage')
                ->with('success', 'Thank you for this order.');
        } else {
            return redirect()
                ->route('homepage')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }




    // private $gateway;

    // public function __construct() {
    //     $this->gateway = Omnipay::create('PayPal_Rest');
    //     $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
    //     $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
    //     $this->gateway->setTestMode(true);
    // }


    // public function pay(Request $request)
    // {
    //     // dd($request->all());
    //     session(['charity_id' => $request->charity_id]);
    //     session(['paypalcommission' => $request->paypalcommission]);
    //     if (Auth::user()) {
    //     } else {
    //         session(['guest_name' => $request->guest_name]);
    //         session(['guest_email' => $request->guest_email]);
    //         session(['guest_phone' => $request->guest_phone]);
    //     }
        
    //     // dd($request->charity_id);


    //     try {
    //         $response = $this->gateway->purchase(array(
    //             'amount' => $request->amount,
    //             'currency' => env('PAYPAL_CURRENCY'),
    //             'returnUrl' => url('charity-success'),
    //             'cancelUrl' => url('charity-error')
    //         ))->send();

    //         if ($response->isRedirect()) {
    //             $response->redirect();
    //         }
    //         else{
    //             return $response->getMessage();
    //         }

    //     } catch (\Throwable $th) {
    //         $msg = $th->getMessage();
    //         return redirect()->back()->with('error', $msg);
    //     }
    // }

    // public function success(Request $request)
    // {
    //     if ($request->input('paymentId') && $request->input('PayerID')) {
    //         $transaction = $this->gateway->completePurchase(array(
    //             'payer_id' => $request->input('PayerID'),
    //             'transactionReference' => $request->input('paymentId')
    //         ));

    //         $charity_id = session('charity_id');
    //         $paypalcommission = session('paypalcommission');

    //         $request->session()->forget('charity_id');
    //         $request->session()->forget('paypalcommission');

    //         if (Auth::user()) {
    //         } else {
    //             $guest_name = session('guest_name');
    //             $guest_email = session('guest_email');
    //             $guest_phone = session('guest_phone');
    //             $request->session()->forget('guest_name');
    //             $request->session()->forget('guest_email');
    //             $request->session()->forget('guest_phone');
    //         }

    //         // check user by email
    //         $chkuser = User::where('email', $guest_email)->first();
    //         // check user by email end

    //         $response = $transaction->send();

    //         if ($response->isSuccessful()) {
    //             $arr = $response->getData();
    //             $amount = $arr['transactions'][0]['amount']['total'];

    //             $payment = new Payment();
    //             $payment->charity_id = $charity_id;
    //             if (Auth::user()) {
    //                 $payment->user_id = Auth::user()->id;
    //             } elseif (isset($chkuser)) {
    //                 $payment->user_id = $chkuser->id;
    //                 $payment->guest_name = $guest_name;
    //                 $payment->guest_email = $guest_email;
    //                 $payment->guest_phone = $guest_phone;
    //             } else {
    //                 $payment->guest_name = $guest_name;
    //                 $payment->guest_email = $guest_email;
    //                 $payment->guest_phone = $guest_phone;
    //             }
    //             $payment->payment_id = $arr['id'];
    //             $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
    //             $payment->payer_email = $arr['payer']['payer_info']['email'];
    //             $payment->amount = $arr['transactions'][0]['amount']['total'];
    //             $payment->currency = env('PAYPAL_CURRENCY');
    //             $payment->payment_status = $arr['state'];
    //             $payment->save();


    //             $stripetopup = new Transaction();
    //             $stripetopup->date = date('Y-m-d');
    //             $stripetopup->tran_no = date('his');
    //             $stripetopup->tran_type = "In";
    //             if (Auth::user()) {
    //                 $stripetopup->user_id = Auth::user()->id;
    //             } elseif (isset($chkuser)) {
    //                 $stripetopup->user_id = $chkuser->id;
    //                 $stripetopup->guest_name = $guest_name;
    //                 $stripetopup->guest_email = $guest_email;
    //                 $stripetopup->guest_phone = $guest_phone;
    //             } else {
    //                 $stripetopup->guest_name = $guest_name;
    //                 $stripetopup->guest_email = $guest_email;
    //                 $stripetopup->guest_phone = $guest_phone;
    //             }
    //             $stripetopup->charity_id = $charity_id;
    //             $stripetopup->commission = $paypalcommission;
    //             $stripetopup->amount = $amount - $paypalcommission;
    //             $stripetopup->total_amount = $amount;
    //             $stripetopup->token = time();
    //             $stripetopup->donation_type = "Charity";
    //             $stripetopup->description = "Charity Donation";
    //             $stripetopup->payment_type = "Paypal";
    //             $stripetopup->notification = "0";
    //             $stripetopup->status = "0";
    //             $stripetopup->save();

    //             // charity balance update
    //                 $fundraiser = User::find($charity_id);
    //                 $fundraiser->balance =  $fundraiser->balance + $amount - $paypalcommission;
    //                 $fundraiser->save();
    //             // charity balance update end


    //             $adminmail = ContactMail::where('id', 1)->first()->email;
    //             if (Auth::user()) {
    //                 $contactmail = Auth::user()->email;
    //             } else {
    //                 $contactmail = $guest_email;
    //             }
                

    //             $ccEmails = [$adminmail];
                
    //             $getcharitydtl = User::where('id',$charity_id)->first();
    //             $msg = EmailContent::where('title','=','charity_donation_email_message')->first()->description;
    //             if (isset($msg)) {
    //                 if (Auth::user()) {
    //                     $array['name'] = Auth::user()->name;
    //                     $array['email'] = Auth::user()->email;
    //                 } else {
    //                     $array['name'] = $guest_name;
    //                     $array['email'] = $guest_email;
    //                 }

    //                 $array['subject'] = "Charity Payment confirmation";
    //                 $array['message'] = $msg;
    //                 $array['contactmail'] = $contactmail;

    //                 $array['message'] = str_replace(
    //                     ['{{title}}','{{user_name}}','{{date}}','{{amount}}','{{payment_method}}'],
    //                     [$getcharitydtl->name, $getcharitydtl->r_name,$stripetopup->date,$amount,$stripetopup->payment_type],
    //                     $msg
    //                 );
    //                 Mail::to($contactmail)
    //                     ->cc($ccEmails)
    //                     ->send(new EventPaymentMail($array));

    //             }
                

    //             $tranid = $arr['id'];
    //             return view('frontend.paypalsuccess', compact('tranid'));

    //         }
    //         else{
    //             return $response->getMessage();
    //         }
    //     }
    //     else{
    //         return view('frontend.paypalerror');
    //     }
    // }

    // public function error()
    // { 
        
    //     return view('frontend.paypaldecline');  
    // }
}
