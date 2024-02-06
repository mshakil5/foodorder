

@extends('layouts.master')

@section('content')


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

    
    table tr td {padding:10px;}


</style>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <h2>Invoice</h2><h3 class="pull-right">Order #{{$data->invoiceno}}</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                    <strong>Billed To:</strong><br>
                        {{$data->name}}<br>
                        {{$data->house}}<br>
                        {{$data->street}}<br>
                        {{$data->city}}<br>
                        {{$data->postcode}}<br>
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Contact Info:</strong><br>
                            Mail:   {{$data->email}}<br>
                            Mobile:   {{$data->phone}}<br>
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Payment Method:</strong><br>
                        {{$data->payment_type}}<br>
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Order Date:</strong><br>
                        {{$data->date}}<br>
                    </address>
                </div>
            </div>


            <div class="row">
                <div class="col-xs-6">
                    <address>
                    <strong>Delivery/Collection Details:</strong><br>
                    Type: {{$data->delivery_type}}<br>
                    Date: {{$data->collection_date}}<br>
                    Time: {{$data->collection_time}}<br>
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
                                @foreach ($orderdetails as $item)
                                
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
                                    <td class="thick-line text-right"><strong>Subtotal:</strong></td>
                                    <td class="thick-line text-right">{{$data->net_amount}}</td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="thick-line text-right"><strong>Discount:</strong></td>
                                    <td class="thick-line text-right">{{$data->discount}}</td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="thick-line text-right"><strong>Delivery Charge:</strong></td>
                                    <td class="thick-line text-right"></td>
                                </tr>
                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="thick-line text-right"><strong>Total:</strong></td>
                                    <td class="thick-line text-right">{{$data->net_amount - $data->discount}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>













@endsection
