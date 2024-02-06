
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Shambleskorner</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
<body>
     <style>
        * {
                padding: 0;
                margin: 0;
                box-sizing: border-box;
                position: relative;
            }
            
                @font-face {
                font-family: "Roboto-Regular";
                src: url(../fonts/Roboto-Regular.ttf);
                }
                @font-face {
                font-family: "Roboto-Bold";
                src: url(../fonts/Roboto-Bold.ttf);
                }
                @font-face {
                font-family: "Roboto-Light";
                src: url(../fonts/Roboto-Light.ttf);
                }
                @font-face {
                font-family: "DarkerGrotesque-regular";
                src: url(../fonts/DarkerGrotesque-Regular.ttf);
                }
                @font-face {
                font-family: "DarkerGrotesque-medium";
                src: url(../fonts/DarkerGrotesque-Medium.ttf);
                }
                @font-face {
                font-family: "DarkerGrotesque-bold";
                src: url(../fonts/DarkerGrotesque-Bold.ttf);
                }
                @font-face {
                font-family: "DarkerGrotesque-black";
                src: url(../fonts/DarkerGrotesque-Black.ttf);
                }
                @font-face {
                font-family: "DarkerGrotesque-Light";
                src: url(../fonts/DarkerGrotesque-Light.ttf);
                }
                @font-face {
                font-family: "DarkerGrotesque-semibold";
                src: url(../fonts/DarkerGrotesque-SemiBold.ttf);
                }

                a {
                text-decoration: none;
                }

                body {
                    font-family: "darkerGrotesque-semibold";
                    overflow-x:hidden;
                    color: #74787E;
                    }

     </style>


    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice-title">
                    <h2>Invoice</h2>
                    <h3 class="pull-right">Order #{{$array['invoiceno']}}</h3>
                </div>
                <hr>
                <div class="row" style="color: #74787E">
                    <div class="col-xs-6">
                        <strong>Billed To:</strong><br>
                            {{$array['name']}}<br>
                            {{$array['house']}}  {{$array['street']}} {{$array['city']}} {{$array['postcode']}}<br>
                    </div>
                    <div class="col-xs-6 text-right" style="text-decoration: none;">
                            <strong>Contact Info:</strong><br>
                                Mail:   <span style="text-decoration: none;">{{$array['email']}}</span><br>
                                Mobile:   {{$array['phone']}}<br>
                    </div>
                </div>
                <div class="row" style="color: #74787E">
                    <div class="col-xs-6" style="color: #74787E">
                            <strong>Payment Method:</strong> {{$array['payment_type']}}<br>
                    </div>
                    <div class="col-xs-6 text-right" style="color: #74787E">
                            <strong>Order Date:</strong> {{$array['date']}}<br>
                    </div>
                    
                    <div class="col-xs-6 text-right">
                        <strong>Order Time:</strong>  {{date("h:i a")}}<br>
                    </div>
                </div>


                <div class="row" style="color: #74787E">
                    <div class="col-xs-6 text-right">
                        <strong>Delivery/Collection Details:</strong><br>
                        Type: {{$array['delivery_type']}}<br>
                        Date: {{$array['collection_date']}}<br>
                        Time: {{$array['collection_time']}}<br>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                
                <h3 class="panel-title" style="color: #74787E"><strong>Order Summary:</strong></h3>
            </div>
            <div class="col-md-12">

                <div class="table-responsive">
                    <table class="table table-condensed" style="width: 90%">
                        <thead>
                            <tr>
                                <td><strong>Item</strong></td>
                                <td class="text-center"><strong>Additional Item</strong></td>
                                <td class="text-center"><strong>Note</strong></td>
                                <td class="text-center"><strong>Quantity</strong></td>
                                <td class="text-center"><strong>Price</strong></td>
                                <td class="text-right" style="text-align: right"><strong>Totals</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($array['orderDtls'] as $item)
                            
                                <tr>
                                    <td>{{$item->product_name}}</td>
                                    <td class="text-left">
                                        @foreach ($item->orderadditionalitem as $additms)
                                            {{$additms->item_name}},Qty: {{$additms->quantity}} <br>
                                        @endforeach
                                    </td>
                                    <td class="text-center"></td>
                                    <td class="text-center">{{$item->quantity}}</td>
                                    <td class="text-center">{{$item->price_per_unit}}</td>
                                    <td class="text-right" style="text-align: right">{{$item->total_price}}</td>
                                </tr> 

                            @endforeach

                            <tr>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line text-left"><strong>Subtotal:</strong></td>
                                <td class="thick-line text-right" style="text-align: right">{{ number_format($array['net_amount'], 2) }}</td>
                            </tr>

                            @if ($array['discount'] > 0)
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line text-left"><strong>Discount:</strong></td>
                                <td class="thick-line text-right" style="text-align: right">{{ number_format($array['discount'], 2) }}</td>
                            </tr>
                            @endif
                            


                            {{-- <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line text-left"><strong>Delivery Charge:</strong></td>
                                <td class="thick-line text-right"></td>
                            </tr> --}}

                            @php
                                $namnt = $array['net_amount'] - $array['discount'];
                            @endphp

                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line text-left"><strong>Total:</strong></td>
                                <td class="thick-line text-right" style="text-align: right">{{number_format($namnt, 2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>



</body>
</html>
















