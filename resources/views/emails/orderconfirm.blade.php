
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Shambleskorner</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
<body>
    


    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice-title">
                    <h2>Invoice</h2>
                    <h3 class="pull-right">Order #{{$array['invoiceno']}}</h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                        <strong>Billed To:</strong><br>
                            {{$array['name']}}<br>
                            {{$array['house']}}  {{$array['street']}} {{$array['city']}} {{$array['postcode']}}<br>
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <strong>Contact Info:</strong><br>
                                Mail:   {{$array['email']}}<br>
                                Mobile:   {{$array['phone']}}<br>
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                            <strong>Payment Method:</strong> {{$array['payment_type']}}<br>
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <strong>Order Date:</strong> {{$array['date']}}<br>
                        </address>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-6 text-right">
                        <address>
                        <strong>Delivery/Collection Details:</strong><br>
                        Type: {{$array['delivery_type']}}<br>
                        Date: {{$array['collection_date']}}<br>
                        Time: {{$array['collection_time']}}<br>
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                        <strong>Order Time:</strong><br>
                        Time: {{date("h:i a")}}<br>
                        </address>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                
                <h3 class="panel-title"><strong>Order summary</strong></h3>
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
                                <td class="text-right"><strong>Totals</strong></td>
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
                                    <td class="text-right">{{$item->total_price}}</td>
                                </tr> 

                            @endforeach

                            <tr>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line text-left"><strong>Subtotal:</strong></td>
                                <td class="thick-line text-right">{{$array['net_amount']}}</td>
                            </tr>

                            @if ($array['discount'] > 0)
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line text-left"><strong>Discount:</strong></td>
                                <td class="thick-line text-right">{{$array['discount']}}</td>
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


                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="thick-line text-left"><strong>Total:</strong></td>
                                <td class="thick-line text-right">{{$array['net_amount'] - $array['discount']}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>



</body>
</html>
















