
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Shambleskorner</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">


        <style>
            table tr td {padding:10px;}
        </style>
    </head>
<body>
    
    <style>

        .invoice-title h2, .invoice-title h3 {
            display: inline-block;
        }

        .table > tbody > tr > .no-line {
            border-top: none;
        }

        .table > thead > tr > .no-line {
            border-bottom: none;
        }

        .table > tbody > tr > .thick-line {
            border-top: 2px solid;
        }


    </style>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice-title">
                    <h2>Invoice</h2><h3 class="pull-right">Order #{{$array['invoiceno']}}</h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                        <strong>Billed To:</strong><br>
                            {{$array['name']}}<br>
                            {{$array['house']}}<br>
                            {{$array['street']}}<br>
                            {{$array['city']}}<br>
                            {{$array['postcode']}}<br>
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
                            <strong>Payment Method:</strong><br>
                            {{$array['payment_type']}}<br>
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <strong>Order Date:</strong><br>
                            {{$array['date']}}<br>
                        </address>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-6">
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <h3 class="panel-title"><strong>Order summary</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>Item</strong></td>
                                        <td class="text-center"><strong>Additional Item</strong></td>
                                        <td class="text-center"><strong>Note</strong></td>
                                        <td class="text-center"><strong>Price</strong></td>
                                        <td class="text-center"><strong>Quantity</strong></td>
                                        <td class="text-right"><strong>Totals</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($array['orderDtls'] as $item)
                                    
                                        <tr>
                                            <td>{{$item->product_name}}</td>
                                            <td class="text-center">
                                                @foreach ($item->orderadditionalitem as $additms)
                                                    {{$additms->item_name}},Qty: {{$additms->quantity}} <br>
                                                @endforeach
                                            </td>
                                            <td class="text-center"></td>
                                            <td class="text-center">{{$item->price_per_unit}}</td>
                                            <td class="text-center">{{$item->quantity}}</td>
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
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="thick-line text-left"><strong>Discount Amount:</strong></td>
                                        <td class="thick-line text-right">{{$array['discount']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="thick-line text-left"><strong>Delivery Charge:</strong></td>
                                        <td class="thick-line text-right"></td>
                                    </tr>
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
        </div>
    </div>



</body>
</html>
















