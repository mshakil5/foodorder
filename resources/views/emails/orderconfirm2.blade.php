<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shambleskorner</title>
</head>

<body style="margin: 0; padding: 0;">

    <style>
        @media (max-width: 768px) {
            tr {
                display: flex;
                flex-direction: column;
                text-align: left;
                align-items: flex-start;
                text-align: left;
            }
            tr td {
                width: 100%;
                text-align: unset !important;
                background: none !important;
            }
            tr td:before {
                content: attr(data-label);
                font-weight: bold;
                float: left;
                display: block;
                width: 100%;
            }
            thead tr {
                display: none;
            }
        }
    </style>

    <div style="  margin:0 auto; padding: 25px;    font-family: system-ui; ">
        <div style="background-color: #F6FBFB;padding: 25px;">

            <p>Dear {{$array['name']}},</p>

            <p>Congratulations! We confirm your order. Here is your order details:</p>

            <h3>Invoice</h3>
            <p>Order No: {{$array['invoiceno']}}</p>
            <hr>
            <p><b>Bill To: {{$array['name']}}</b>    </p>
            <p><b>Contact Information: </b>    </p>
            <p>Mail: {{$array['email']}}</p>
            <p>Mobile: {{$array['phone']}}</p>
            <p><b>Payment Method: {{$array['payment_type']}}</b>    </p>
            <p><b>Order Date: </b>     {{$array['date']}}</p>
            <p><b>Delivery/Collection Details: </b>    </p>
            <p><b>Type: {{$array['delivery_type']}} </b>    </p>
            <p><b>Time: {{$array['collection_time']}} </b>    </p>

            
            <h3>Order Summery: </h3>

            <table width="100%" style="border-collapse: collapse; margin-bottom: 10px;">
                <tr style="font-weight: bold;">
                  <td style="border:1px solid; padding:5px; font-size: 12px;">Item</td>
                  <td style="border:1px solid; padding:5px; font-size: 12px;">Additional Item</td>
                  <td style="border:1px solid; padding:5px; font-size: 12px;">Price</td>
                  <td style="border:1px solid; padding:5px; font-size: 12px;">Quantity</td>
                  <td style="border:1px solid; padding:5px; font-size: 12px;">Total</td>
                </tr>

                @foreach ($array['orderDtls'] as $item)
                    <tr>
                        <td style="border:1px solid; padding:5px; font-size: 12px;">{{$item->product_name}} </td>
                        <td style="border:1px solid; padding:5px; font-size: 12px;">
                        @foreach ($item->orderadditionalitem as $additms)
                            {{$additms->item_name}},
                        @endforeach
                        </td>
                        <td style="border:1px solid; padding:5px; font-size: 12px;">{{$item->price_per_unit}}</td>
                        <td style="border:1px solid; padding:5px; font-size: 12px;">{{$item->quantity}}</td>
                        <td style="border:1px solid; padding:5px; font-size: 12px;">{{$item->total_price}}</td>
                    </tr>
                @endforeach

                <tr style="font-weight: bold;">
                    <td style="border:1px solid; padding:5px; font-size: 12px;"></td>
                    <td style="border:1px solid; padding:5px; font-size: 12px;"></td>
                    <td style="border:1px solid; padding:5px; font-size: 12px;"></td>
                    <td style="border:1px solid; padding:5px; font-size: 12px;">Subtotal</td>
                    <td style="border:1px solid; padding:5px; font-size: 12px;">{{$array['net_amount']}}</td>
                </tr>

                <tr style="font-weight: bold;">
                    <td style="border:1px solid; padding:5px; font-size: 12px;"></td>
                    <td style="border:1px solid; padding:5px; font-size: 12px;"></td>
                    <td style="border:1px solid; padding:5px; font-size: 12px;"></td>
                    <td style="border:1px solid; padding:5px; font-size: 12px;">Delivery Charge</td>
                    <td style="border:1px solid; padding:5px; font-size: 12px;"></td>
                </tr>

                <tr style="font-weight: bold;">
                    <td style="border:1px solid; padding:5px; font-size: 12px;"></td>
                    <td style="border:1px solid; padding:5px; font-size: 12px;"></td>
                    <td style="border:1px solid; padding:5px; font-size: 12px;"></td>
                    <td style="border:1px solid; padding:5px; font-size: 12px;">Total</td>
                    <td style="border:1px solid; padding:5px; font-size: 12px;">{{$array['net_amount']}}</td>
                </tr>

                

            </table>


        </div>
        <div style="text-align:center; background:  #f3f3f3;padding: 15px; margin-top: 5px;">
            <span style="color: #143157;">&copy; Shambleskorner, all right reserved 2024</span>
        </div>
       
    </div>

</body>

</html>