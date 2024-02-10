@extends('layouts.master')

@section('content')

<style>
    .title-section {
        background-color: #f5f3f1;
        padding: 19px 24px;
        color: #515e64;
        font-weight: bold;
        text-transform: capitalize;
        font-size: 2.1rem;
    }
    .center-form {
        text-align: center;
    }

    .center-form form {
        display: inline-block;
        text-align: left;
    }


.box-custom{
    padding: 15px;
    box-shadow: 0px 4px 11px #0000005e;
    transition: transform 0.3s ease-in-out;
    margin-bottom: 15px;
    border-radius: 4px;
}
.box-custom:hover{
    transform: scale(1.02);

}

    /*loader css*/
    #loading {
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0.7;
        background-color: #fff;
        z-index: 99;
    }

    #loading-image {
        z-index: 100;
    }
    

</style>

<style>
    input.largerCheckbox {
      width: 25px;
      height: 25px;
    }

    input.largerRadiobox {
        width: 25px;
        height: 25px;
        background-color: white;
        border-radius: 50%;
        vertical-align: middle;
        border: 1px solid #9c9999;
        appearance: none;
        -webkit-appearance: none;
        outline: none;
        cursor: pointer;
    }

    .largerRadiobox:checked {
        background-color: #193d5b;
    }

  </style>

   <!-- Image loader -->
   <div id='loading' style='display:none ;'>
        <img src="{{ asset('loader.gif') }}" id="loading-image" alt="Loading..." style="height: 225px;" />
    </div>

    @php
        $minimum_sale = 10;
        $delivery_charge = 2;
    @endphp

<div class="container mt-5">
    <div class="row">
    
        <div class="col-md-2 col-xs-12">
            <ul class="list-group" id="get_category">
                @foreach (\App\Models\Category::orderby('id','ASC')->get() as $cat)
                    
                <li style="margin-bottom: 3px;"><button value="{{$cat->id}}" class='category list-group-item getsrchval'>{{$cat->name}}</button></li>

                @endforeach
                
            </ul>
        </div>

        <div class="col-md-5 col-xs-12">		
            <div class="row" id="get_product" style="padding: 15px">
                @foreach ($products as $product)
                
                <div class="col-md-12 box-custom mb-4 rounded-3">
                    <div class="row">
                        <div class='col-md-8 col-xs-12'>
                            <h4 style='margin-top: 0px' class='fw-bold text-primary'>{{$product->product_name}}</h4>
                            <p>{{$product->description}}</p>
                            {{-- <input type='text' placeholder='Note' class='' style='width:100%;border:1px solid black;margin-bottom:20px;' /> --}}
                            
                        </div>
                        <div class='col-md-2 col-xs-6'>£{{ number_format($product->price, 2) }}</div>
                        <div class='col-md-2 col-xs-6'>
                            @if ($product->assign == 1)
                                <button class="btn btn-primary text-uppercase btn-sm btn-modal" data-toggle="modal" data-target="#additemModal" style="margin-left: -7px;" pid="{{$product->id}}" pname="{{$product->product_name}}" pdesc="{{$product->description}}" price="{{ number_format($product->price, 2) }}">
                                    add
                                </button>
                            @else
    
                                <button class="btn btn-primary text-uppercase btn-sm btn-modal" data-toggle="modal" data-target="#additemModal" style="margin-left: -7px;" pid="{{$product->id}}" pname="{{$product->product_name}}" pdesc="{{$product->description}}" price="{{ number_format($product->price, 2) }}">
                                    add
                                </button>
    

                            @endif
                        </div>
                    </div>
                    
                    
                    
                </div>
                

                @endforeach

                
            </div>	
        </div>



        <div class="col-md-5 col-xs-12"> 
    
            <div id="cart_checkout" style="margin-top: 10px">
                <form action="{{route('paypalpayment')}}" method="POST">
                @csrf

                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif

                {{-- card checkout card start  --}}
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-4 col-xs-4">Cart Checkout</div>
                                    <div class="col-md-8" id="cart_msg"><!--Cart Message--> </div>
                                </div>

                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <table class="table">
                                        {{-- <thead>
                                            <tr>
                                                <th style="text-align: center">Action</th>
                                                <th style="text-align: center">Name</th>
                                                <th style="text-align: center">Quantity</th>
                                                <th style="text-align: center">Price</th>
                                                <th style="text-align: center">Total</th>
                                            </tr>
                                        </thead> --}}
                                        <tbody id="cardinner">

                                            @if(session('cart'))
                                                @foreach(session('cart') as $id => $items)
                                                    @foreach ($items as $item)
                                                        
                                                    {!! $item !!}
                                                    @endforeach
                                                @endforeach
                                            @endif
                                            

                                        </tbody>
                                        <tfoot id="cardfooter">
                                            <tr>
                                                <th style="padding:0px 15px;text-align: left; border:0px" colspan="4">Subtotal:</th>
                                                <th style="padding:0px;text-align: center; border:0px">
                                                    <div class="grand_total_amount" id="grand_total_amount"></div>
                                                    <input type="hidden" name="grand_total_value" id="grand_total_value">
                                                    
                                                </th>
                                            </tr>

                                            <tr id="dis_div">
                                                <th style="padding:0px 15px;text-align: left; border:0px" colspan="4">Discount:</th>
                                                <th style="padding:0px;text-align: center; border:0px"><div class="discount_div" id="discount_div">0.00</div>
                                                    <input type="hidden" name="discount_percent" id="discount_percent" value="0">
                                                </th>
                                            </tr>

                                            <tr>
                                                <th style="padding:0px 15px;text-align: left; border:0px;" colspan="4">Total:</th>
                                                <th style="padding:0px;text-align: center; border:0px"><div class="net_total_amount" id="net_total_amount"></div>
                                                    <input type="hidden" name="discount_amount" id="discount_amount" value="0">
                                                    <input type="hidden" name="net_total_value" id="net_total_value">
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="form-group"> 
                                            <label for="coupon">Use Your Coupon</label> 
                                            <input type="text" class="form-control" id="coupon" name="coupon"> 
                                        </div>
                                        <div class="couponerrmsg"></div>
                                    </div>
                                    <div class="col-md-42"></div>

                                    


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- card checkout card end  --}}
                

                
                
                <div class="row"> 
                    <div class="col-md-12">
                        <div class="panel panel-primary"> 
                            <div class="panel-heading"> 
                                <div class="row"> 
                                    <div class="col-md-4">Collection Option</div> 
                                </div> 
                            </div> 
                            <div class="panel-body"> 
                                @php
                                    $mytime = Carbon\Carbon::now();
                                    // echo $mytime->toDateTimeString();
                                @endphp
                                <div class="row"> 
                                    <div class="col-md-12 col-xs-6">
                                        <b>
                                        <div class="radio"> 
                                            <label for="clnChkNo" class="rmvDiv">
                                            <input type="radio" name="collection" value="Collection" class="rmvDiv" id="clnChkNo" onclick="ShowHideDivforCln()" {{ old('collection') !== null && old('collection') == "Collection" ? 'checked' : '' }} checked>Collection</label> <p>Within 20 Minutes</p> 
                                        </div>
                                        </b>
                                    </div>
                                    <div class="col-md-6 col-xs-6" style="display: none"><b>
                                        <div class="radio"> 
                                            <label for="clnChkYes">
                                            <input type="radio" name="collection" value="Delivery" id="clnChkYes" onclick="ShowHideDivforCln()" {{ old('collection') !== null && old('collection') == "Delivery" ? 'checked' : '' }}>Delivery</label> <p>Within 60 Minutes</p> 
                                        </div></b>
                                    </div>

                                    <div class="col-md-6 col-xs-6">
                                        <label for="date">Collection/Delivery Date</label><input type="date" class="date-picker form-control hasDatepicker" name="date" id="date" value="{{date('Y-m-d')}}" placeholder="Select date" required>
                                    </div>

                                    <div class="col-md-6 col-xs-6">
                                        <label for="timeslot">Collection/Delivery Time</label> 
                                        <select id="timeslot" class="form-control"  name="timeslot">					
                                        <option value="">Delivery/Collection Time </option>

                                            @foreach (\App\Models\TimeSlot::all() as $time)

                                                {{-- @if (date('H:i:s') < $time->start_time)
                                                    <option value="{{date('h:i A', strtotime($time->start_time))}} - {{date('h:i A', strtotime($time->end_time))}}">{{date('h:i A', strtotime($time->start_time))}} - {{date('h:i A', strtotime($time->end_time))}}</option>
                                                @endif --}}

                                                <option value="{{date('h:i A', strtotime($time->start_time))}} - {{date('h:i A', strtotime($time->end_time))}}">{{date('h:i A', strtotime($time->start_time))}} - {{date('h:i A', strtotime($time->end_time))}}</option>

                                            @endforeach
                                        
                                        
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                

                @include('frontend.customerinfo')


                <div class="row" id="submitDiv">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-4">Payment Option</div> 
                                </div> 
                            </div> 
                            <div class="panel-body"> 
                                <div class="row text-center"> 
                                    <div class="col-md-7 col-xs-12" style="margin-bottom: 2px">
                                        <button type="submit" class="btn btn-primary d-md-inline-block w-100">Pay with CARD or Paypal</button>
                                    </div> 
                                    </form>
                                    
                                    <div class="col-md-3 col-xs-12">
                                        <input type="button" id="orderCreateBtn" name="orderCreateBtn" class="btn btn-primary d-md-inline-block w-100" value="Pay with Cash">
                                    </div> 
                                    
                                </div> 
                            </div> 
                        </div> 
                    </div> 
                </div> 

            </div>
        </div>
                
    </div>
</div>

@include('frontend.modal')



@endsection

@section('script')
<script type="text/javascript">
    net_total();
    function removeRow(event) {

        // var data = ($(event.target).parents('tr').html());
        
        event.target.parentElement.parentElement.remove();
        net_total();
        var data = $("#cardinner").html();

        var clearsessionurl = "{{URL::to('/clear-session-data')}}";
            $.ajax({
                url: clearsessionurl,
                method: "POST",
                data: {data},

                success: function (d) {
                    window.setTimeout(function(){location.reload()},200)
                    net_total();
                    console.log(d);
                },
                error: function (d) {
                    console.log(d);
                }
            });
    
        // console.log(row);
    }
    $('#date').change(function() { 
        
        var collection_date = $("#date").val();

    });

        // net total calculation
        function net_total(){
            
            var discount_percent = $("#discount_percent").val();
            var totalamount=0;
            $('.net_amount_with_child_item').each(function(){
                totalamount += ($(this).val()-0);
            })
            if (discount_percent>0) {
                var disAmount = totalamount * discount_percent/100;
                var net_amnt = totalamount - disAmount;
                $("#discount_amount").val(disAmount.toFixed(2));
                $("#discount_div").html(disAmount.toFixed(2));
                $("#net_total_value").val(net_amnt.toFixed(2));
                $("#net_total_amount").html(net_amnt.toFixed(2));

                $("#grand_total_value").val(totalamount.toFixed(2));
                $("#grand_total_amount").html(totalamount.toFixed(2));
                $("#dis_div").show();


            } else {
                
                $("#grand_total_value").val(totalamount.toFixed(2));
                $("#grand_total_amount").html(totalamount.toFixed(2));
                $("#net_total_value").val(totalamount.toFixed(2));
                $("#net_total_amount").html(totalamount.toFixed(2));
                $("#dis_div").hide();
            }

            if (totalamount > 0) {
                $("#cardfooter").show();
            } else {
                $("#cardfooter").hide();
            }
        }
        // net total calculation
</script>
<script>

$(document).ready(function() {
    $("input[name='payment']").click(function() {
        var val = $(this).val();
        if (val == "Paypal") {
            $("#ppdiv").show(); 
            $("#cashdiv").hide(); 
        } else {
            
            $("#ppdiv").hide(); 
            $("#cashdiv").show(); 
        }
        // $("div.desc").hide();
    });
});


$(document).ready(function() {
    // $("#addressDiv").hide(); 
    $("input[name='collection']").click(function() {
        var val = $(this).val();
        // console.log(val);
        if (val == "Collection") {
            $("#addressDiv").hide(); 
        } else {
            $("#addressDiv").show(); 
        }
        // $("div.desc").hide();
    });
});


    $(function()
        {
            // parent increase function start
            $(".add").click(function()
            {
                var currentVal = parseInt($("#qty").val());
                var unitprice = $("#unitprice").val();
                var additemtotal = $("#additemtamnt").val();
                var priceperunit = (currentVal+1)*unitprice;
                var amt = parseFloat(priceperunit);
                var adamt = parseFloat(additemtotal);
                var net_amnt = adamt + amt;
                
                if (currentVal != NaN)
                {
                    $("#qty").val(currentVal + 1);
                    $("#pShow").html("£"+ net_amnt.toFixed(2));
                    $("#tamount").val(net_amnt.toFixed(2));
                    $('.orderBtn').attr('net_amount', net_amnt.toFixed(2));
                    $('.orderBtn').attr('pqty', currentVal + 1);
                }
            });
            // parent increase function end

            // parent decrease function start
            $(".minus").click(function()
            {
                var currentVal = parseInt($("#qty").val());
                var unitprice = $("#unitprice").val();
                var additemtotal = $("#additemtamnt").val();
                var priceperunit = (currentVal-1)*unitprice;
                
                var amt = parseFloat(priceperunit);
                var adamt = parseFloat(additemtotal);
                var net_amnt = adamt + amt;
                
                if (currentVal != NaN)
                {
                    if(currentVal > 1){
                        $("#qty").val(currentVal - 1);
                        $("#pShow").html("£"+ net_amnt.toFixed(2));
                        $("#tamount").val(net_amnt.toFixed(2));
                        $('.orderBtn').attr('net_amount', net_amnt.toFixed(2));
                        $('.orderBtn').attr('pqty', currentVal - 1);
                    }

                }
            });
            // parent decrease function end
        });


         // header for csrf-token is must in laravel
         $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        // 

        // category wise product show
        $("body").delegate(".getsrchval","click",function () {
            var searchurl = "{{URL::to('/getcatproduct')}}";
            var id = $(this).attr('value');
            var form_data = new FormData();			
            form_data.append("id", id);

            $.ajax({
                url:searchurl,
                method: "POST",
                type: "POST",
                contentType: false,
                processData: false,
                data:form_data,
                success: function(d){
                    $("#get_product").html(d.product);
                    // console.log((d.min));
                },
                error:function(d){
                    console.log(d);
                }
            });
        });
        // category wise product show

    $(document).ready(function() {

        var urlbr = "{{URL::to('/get-additional-product')}}";

        // product show in modal start
        $(document).on('click', '.btn-modal', function () {
            let stockid = $(this).val();
            pdesc = $(this).attr('pdesc');
            productid = $(this).attr('pid');
            pname = $(this).attr('pname');
            price = $(this).attr('price');
            
            $('#additemModal').find('.modal-body #brdDiv').html('<div class="title-section"><div class="mx-2">Choose Bread </div><input type="hidden" id="addebreaditems" data-itemid="0" name="additionalitm" data-count="0" value="" data-itemname="" class="extraaitem"></div>');




            $('#additemModal').find('.modal-body #productname').val(pname);
            $('#additemModal').find('.modal-body #productid').val(productid);
            $('#additemModal').find('.modal-body #pdesc').val(pdesc);
            $("#pnameshow").html(pname);
            $("#descShow").html(pdesc);
            $("#priceShow").html("£"+price);
            $("#pShow").html("£"+price);
            $("#unitprice").val(price);
            $("#tamount").val(price);
            $("#parent_item_uprice").val(price);
            $('#additemModal').find('.modal-body #price').val(price);

            $('.orderBtn').attr('net_amount', price);
            $('.orderBtn').attr('price', price);
            $('.orderBtn').attr('pid', productid);
            $('.orderBtn').attr('pname', pname);
            $('.orderBtn').attr('pqty', 1);

            // $("#addebreaditems").attr("data-count","");
            // $("#addebreaditems").attr("data-itemid","");
            // $("#addebreaditems").attr("class","extraaitem");
            // $("#addebreaditems").attr("itemname","");
            // $("#addebreaditems").attr("value","");
            
            // loop start
            $.ajax({
                    url: urlbr,
                    method: "POST",
                    data: {productid:productid},

                    success: function (d) {
                            // console.log(d);
                        if (d.status == 303) {

                        }else if(d.status == 300){
                            
                            $("#qty").val('1');
                            $("#additemtunitamnt").val('0');
                            $("#additemtamnt").val('0');
                            
                            $(".breads").hide();
                            $(".cheese").hide();
                            $(".chutney").hide(100);
                            $(".toppings").hide(100);
                            $(".extoppings").hide(100);
                            $(".addons").hide(100);

                            // addonsitems
                            var addonsitems = $(".addonsitem tbody");
                            addonsitems.empty();
                            $.each(d.items, function (a, b) {
                                if (b.additional_item_title_id == 6) {
                                    $(".addons").show(100);

                                    addonsitems.append("<tr><td class='additemval' value='"+b.additional_item_id+"' price='"+b.price+"' style='width: 10%; text-align:center'><svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-plus-circle' viewBox='0 0 16 16' style='height:22px'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/></svg><input type='hidden' id='addetoppings"+b.additional_item_id+"' data-itemid='' name='additionalitm' data-itemname='" + b.item_name + "' data-count='' value='"+b.price+"' class='extraaitem'></td><td style='width: 70%'>" + b.item_name + "<span class='badge badge-success pl-2' id='output"+b.additional_item_id+"'></span></td>" + "<td style='width: 20%; text-align:right'>"+ (b.price > 0 ? "£"+b.price.toFixed(2) : '')+"</td><td class='minusitemval' value='"+b.additional_item_id+"' id='minusadditem"+b.additional_item_id+"' price='"+b.price+"' style='width: 10%; text-align:center;display:none'><svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-dash-circle' viewBox='0 0 16 16'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path d='M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z'/></svg></td></tr>"); 
                                }
                            });
                            // addonsitems end

                            // breadsitems
                            var breadsitems = $(".breadsitem tbody");
                            breadsitems.empty();
                            $.each(d.items, function (a, b) {
                                if (b.additional_item_title_id == 5) {
                                    $(".breads").show(100);


                                    // breadsitems.append("<tr><td style='width: 10%; text-align:center'><input type='radio' name='bread' value='"+b.additional_item_id+"'  id='bread"+b.additional_item_id+"' class='largerCheckbox breadsingleitem' breadname='" + b.item_name + "' price='"+b.price+"'>  </td><td style='width: 70%'>" + b.item_name + "</td>" + "<td style='width: 20%; text-align:right'>"+ (b.price > 0 ? "£"+b.price.toFixed(2) : '')+"</td></tr>"); 

                                    

                                    breadsitems.append("<tr><td style='width: 10%; text-align:center'><input type='checkbox' class='largerRadiobox breadsingleitem' id='breads"+b.additional_item_id+"' name='breads' breadname='" + b.item_name + "' value='"+b.additional_item_id+"' price='"+b.price+"'><input type='hidden' id='addbreadsitems"+b.additional_item_id+"' data-itemid='' name='additionalitm' data-count='' value='"+b.price+"' data-itemname='" + b.item_name + "' class='extraaitembread'></td><td style='width: 70%'>" + b.item_name + "</td>" + "<td style='width: 20%; text-align:right'>"+ (b.price > 0 ? "£"+b.price.toFixed(2) : '')+"</td></tr>"); 

                                    
                                }
                            });
                            // breadsitems end

                            

                            //cheese items start
                            var cheeseitems = $(".cheeseitem tbody");
                            cheeseitems.empty();
                            $.each(d.items, function (a, b) {
                                
                                if (b.additional_item_title_id == 4) {
                                    $(".cheese").show(100);

                                    cheeseitems.append("<tr><td style='width: 10%; text-align:center'><input type='checkbox' class='largerCheckbox cheesesingleitem' id='cheese"+b.additional_item_id+"' name='cheese' value='"+b.additional_item_id+"' price='"+b.price+"'><input type='hidden' id='addecheeseitems"+b.additional_item_id+"' data-itemid='' name='additionalitm' data-count='' value='"+b.price+"' data-itemname='" + b.item_name + "' class='extraaitem'></td><td style='width: 70%'>" + b.item_name + "</td>" + "<td style='width: 20%; text-align:right'>"+ (b.price > 0 ? "£"+b.price.toFixed(2) : '')+"</td></tr>"); 
                                        
                                }
                                
                            });
                            //cheese items end

                            //Chutney and Sauces start
                            var chutneyitems = $(".chutneyitem tbody");
                            chutneyitems.empty();
                            $.each(d.items, function (a, b) {
                                if (b.additional_item_title_id == 3) {
                                    $(".chutney").show(100);
                                    chutneyitems.append("<tr><td style='width: 10%; text-align:center'><input type='checkbox' class='largerCheckbox chutneysingleitem' name='chutney' value='"+b.additional_item_id+"' price='"+b.price+"'><input type='hidden' id='addechutneyitems"+b.additional_item_id+"' data-itemid='' name='additionalitm' data-count='' value='"+b.price+"' data-itemname='" + b.item_name + "' class='extraaitem'></td><td style='width: 70%'>" + b.item_name + "</td>" + "<td style='width: 20%; text-align:right'>"+ (b.price > 0 ? "£"+b.price.toFixed(2) : '')+"</td></tr>"); 
                                    
                                }
                            });
                            //Chutney and Sauces end

                            //toppings item start
                            var toppingsitems = $(".toppingsitem tbody");
                            toppingsitems.empty();
                            $.each(d.items, function (a, b) {
                                if (b.additional_item_title_id == 1) {
                                    $(".toppings").show(100);
                                    toppingsitems.append("<tr><td class='additemval' value='"+b.additional_item_id+"' price='"+b.price+"' style='width: 10%; text-align:center'><svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-plus-circle' viewBox='0 0 16 16' style='height:22px'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/></svg><input type='hidden' id='addetoppings"+b.additional_item_id+"' data-itemid='' name='additionalitm' data-itemname='" + b.item_name + "' data-count='' value='"+b.price+"' class='extraaitem'></td><td style='width: 70%'>" + b.item_name + "<span class='badge badge-success pl-2' id='output"+b.additional_item_id+"'></span></td>" + "<td style='width: 20%; text-align:right'>"+ (b.price > 0 ? "£"+b.price.toFixed(2) : '')+"</td><td class='minusitemval' value='"+b.additional_item_id+"' id='minusadditem"+b.additional_item_id+"' price='"+b.price+"' style='width: 10%; text-align:center;display:none'><svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-dash-circle' viewBox='0 0 16 16'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path d='M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z'/></svg></td></tr>"); 
                                }
                            });
                            //toppings item end

                            //extra toppings item start
                            var extoppingsitems = $(".extoppingsitem tbody");
                            extoppingsitems.empty();
                            $.each(d.items, function (a, b) {
                                if (b.additional_item_title_id == 2) {
                                    $(".extoppings").show(100);
                                    extoppingsitems.append("<tr><td class='additemval' value='"+b.additional_item_id+"' price='"+b.price+"' style='width: 10%; text-align:center'><svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-plus-circle' viewBox='0 0 16 16' style='height:22px'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/></svg><input type='hidden' id='addetoppings"+b.additional_item_id+"' data-itemid='' name='additionalitm' data-itemname='" + b.item_name + "' data-count='' value='"+b.price+"' class='extraaitem'></td><td style='width: 70%'>" + b.item_name + "<span class='badge badge-success pl-2' id='output"+b.additional_item_id+"'></span></td>" + "<td style='width: 20%; text-align:right'>"+ (b.price > 0 ? "£"+b.price.toFixed(2) : '')+"</td><td class='minusitemval' value='"+b.additional_item_id+"' id='minusadditem"+b.additional_item_id+"' price='"+b.price+"' style='width: 10%; text-align:center;display:none'><svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-dash-circle' viewBox='0 0 16 16'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path d='M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z'/></svg></td></tr>"); 
                                }
                            });
                            //extra toppings item end
                            
                            

                        // $("#proname").html(d.productname);     
                        }
                    },
                    error: function (d) {
                        console.log(d);
                    }
                }); 
            // loop end
        });
        // product show in modal end


        

        // child product increase start
        $("body").delegate(".additemval","click",function () {
            
            var id = $(this).attr('value');
            var price = $(this).attr('price');
            $('#output'+id).html(function(i, val) { return val*1+1 });

            var output = $('#output'+id).html();
            var additemqty = parseInt(output);
            var additemtunitamnt = additemqty * price;
            var parent_item_unit_price = $("#parent_item_uprice").val();
            var parent_item_qty = $("#qty").val();
            var parent_item_price = parseFloat(parent_item_unit_price) * parseFloat(parent_item_qty);
            var additemtamnt = $("#additemtamnt").val();
            var total_add_item_amnt = parseFloat(additemtamnt) + parseFloat(price);
            var parent_item_total_price = parseFloat(parent_item_price) + parseFloat(total_add_item_amnt);

            $("#pShow").html("£"+ parent_item_total_price.toFixed(2));
            $("#additemtunitamnt").val(additemtunitamnt.toFixed(2));
            $("#additemtamnt").val(total_add_item_amnt.toFixed(2));
            $("#addetoppings"+id).val(additemtunitamnt.toFixed(2));
            $("#addetoppings"+id).attr('data-count', output);
            $("#addetoppings"+id).attr('data-itemid', id);
            if (additemqty>0) {
                $("#minusadditem"+id).show();
            }

        });
        // child product increase end
        
        // child product decrease start
        $("body").delegate(".minusitemval","click",function () {
            
            var id = $(this).attr('value');
            var price = $(this).attr('price');
            $('#output'+id).html(function(i, val) { return val*1-1 });
            var output = $('#output'+id).html();
            var additemqty = parseInt(output);
            var additemtunitamnt = additemqty * price;
            var parent_item_unit_price = $("#parent_item_uprice").val();
            var parent_item_qty = $("#qty").val();
            var parent_item_price = parseFloat(parent_item_unit_price) * parseFloat(parent_item_qty);
            var additemtamnt = $("#additemtamnt").val();
            var total_add_item_amnt = parseFloat(additemtamnt) - parseFloat(price);
            var parent_item_total_price = parseFloat(parent_item_price) + parseFloat(total_add_item_amnt);
            $("#pShow").html("£"+ parent_item_total_price.toFixed(2));
            $("#additemtunitamnt").val(additemtunitamnt.toFixed(2));
            $("#additemtamnt").val(total_add_item_amnt.toFixed(2));
            $("#addetoppings"+id).val(additemtunitamnt.toFixed(2));
            $("#addetoppings"+id).attr('data-count', output);
            $("#addetoppings"+id).attr('data-itemid', id);

            if (additemqty<1) {
                $("#minusadditem"+id).hide();
            }
        });
        // child product decrease end


        // enable disable checkbox item start
        $("body").delegate(".breadsingleitem","click",function () {
            
            var id = $(this).attr('value');

            var price = $(this).attr('price');
            var breadname = $(this).attr('breadname');
            var parent_item_price = $("#tamount").val();
            var additemtamnt = $("#additemtamnt").val();
            var additemtamntint = parseFloat(price);
            
            if(this.checked){
                var total_add_item_amnt = parseFloat(additemtamnt) + parseFloat(price);
                var parent_item_total_price = parseFloat(parent_item_price) + parseFloat(total_add_item_amnt);
                $("#pShow").html("£"+ parent_item_total_price.toFixed(2));
                $("#additemtamnt").val(total_add_item_amnt.toFixed(2));

                $("#addebreaditems").val(additemtamntint);
                $("#addebreaditems").attr('data-count', 1);
                $("#addebreaditems").attr('data-itemid', id);
                $("#addebreaditems").attr('data-itemname', breadname);
                $("#addebreaditems").attr('value', price);
            } else {
                var total_add_item_amnt = parseFloat(additemtamnt) - parseFloat(price);
                var parent_item_total_price = parseFloat(parent_item_price) + parseFloat(total_add_item_amnt);
                $("#pShow").html("£"+ parent_item_total_price.toFixed(2));
                $("#additemtamnt").val(total_add_item_amnt.toFixed(2));

                $("#addebreaditems").attr('data-count', 0);
                $("#addebreaditems").val(0);
            }

            if ($(this).prop("checked")) {
                // Uncheck all other checkboxes
                $(".breadsingleitem").not(this).prop("checked", false);

            }
        });

        $("body").delegate(".chutneyitem","click",function () {
            var id = $(this).attr('value');
            var check = $(this).find('input[type="checkbox"]:checked').length;
            if (check>1) {
                    $(this).find('input[type="checkbox"]').prop('disabled', true);
                    $(this).find('input[type="checkbox"]:checked').prop('disabled', false);
            } else {
                $(this).find('input[type="checkbox"]').prop('disabled', false);
            }
        });
        // enable disable checkbox item end

        // bread item check and uncheck start
        $("body").delegate(".cheeseitem","click",function () {
            var id = $(this).attr('value');
            
            var check = $(this).find('input[type="checkbox"]:checked').length;
            if (check>1) {
                    $(this).find('input[type="checkbox"]').prop('disabled', true);
                    $(this).find('input[type="checkbox"]:checked').prop('disabled', false);
            } else {
                $(this).find('input[type="checkbox"]').prop('disabled', false);
            }
        });
        // bread item check and uncheck end


        // child checkbox item calculation start
        // $("body").delegate(".breadsingleitem","change",function () {
            
        //     var id = $(this).attr('value');
        //     var price = $(this).attr('price');
        //     var breadname = $(this).attr('breadname');
        //     var parent_item_price = $("#tamount").val();
        //     var additemtamnt = $("#additemtamnt").val();
        //     var additemtamntint = parseFloat(price);
            
        //     if(this.checked){
        //         var total_add_item_amnt = parseFloat(additemtamnt) + parseFloat(price);
        //         var parent_item_total_price = parseFloat(parent_item_price) + parseFloat(total_add_item_amnt);
        //         $("#pShow").html("£"+ parent_item_total_price.toFixed(2));
        //         $("#additemtamnt").val(total_add_item_amnt.toFixed(2));

        //         $("#addebreaditems").val(additemtamntint);
        //         $("#addebreaditems").attr('data-count', 1);
        //         $("#addebreaditems").attr('data-itemid', id);
        //         $("#addebreaditems").attr('data-itemname', breadname);
        //         $("#addebreaditems").attr('value', price);
        //     } else {
        //         var total_add_item_amnt = parseFloat(additemtamnt) - parseFloat(price);
        //         var parent_item_total_price = parseFloat(parent_item_price) + parseFloat(total_add_item_amnt);
        //         $("#pShow").html("£"+ parent_item_total_price.toFixed(2));
        //         $("#additemtamnt").val(total_add_item_amnt.toFixed(2));

        //         $("#addebreaditems").attr('data-count', 0);
        //         $("#addebreaditems").val(0);
        //     }
        // });

        $("body").delegate(".breadsingleitem","click",function () {
            var id = $(this).attr('value');
            var price = $(this).attr('price');
            var parent_item_price = $("#tamount").val();
            var additemtamnt = $("#additemtamnt").val();
            var additemtamntint = parseFloat(price);
            

            if(this.checked){
                var total_add_item_amnt = parseFloat(additemtamnt) + parseFloat(price);
                var parent_item_total_price = parseFloat(parent_item_price) + parseFloat(total_add_item_amnt);
                $("#pShow").html("£"+ parent_item_total_price.toFixed(2));
                $("#additemtamnt").val(total_add_item_amnt.toFixed(2));

                $("#addbreadsitems"+id).val(additemtamntint);
                $("#addbreadsitems"+id).attr('data-count', 1);
                $("#addbreadsitems"+id).attr('data-itemid', id);
            } else {
                var total_add_item_amnt = parseFloat(additemtamnt) - parseFloat(price);
                var parent_item_total_price = parseFloat(parent_item_price) + parseFloat(total_add_item_amnt);
                $("#pShow").html("£"+ parent_item_total_price.toFixed(2));
                $("#additemtamnt").val(total_add_item_amnt.toFixed(2));

                $("#addbreadsitems"+id).val();
                $("#addbreadsitems"+id).attr('data-count', '');
                $("#addbreadsitems"+id).attr('data-itemid', '');
            }

        });

        $("body").delegate(".cheesesingleitem","click",function () {
            var id = $(this).attr('value');
            var price = $(this).attr('price');
            var parent_item_price = $("#tamount").val();
            var additemtamnt = $("#additemtamnt").val();
            var additemtamntint = parseFloat(price);
            

            if(this.checked){
                var total_add_item_amnt = parseFloat(additemtamnt) + parseFloat(price);
                var parent_item_total_price = parseFloat(parent_item_price) + parseFloat(total_add_item_amnt);
                $("#pShow").html("£"+ parent_item_total_price.toFixed(2));
                $("#additemtamnt").val(total_add_item_amnt.toFixed(2));

                $("#addecheeseitems"+id).val(additemtamntint);
                $("#addecheeseitems"+id).attr('data-count', 1);
                $("#addecheeseitems"+id).attr('data-itemid', id);
            } else {
                var total_add_item_amnt = parseFloat(additemtamnt) - parseFloat(price);
                var parent_item_total_price = parseFloat(parent_item_price) + parseFloat(total_add_item_amnt);
                $("#pShow").html("£"+ parent_item_total_price.toFixed(2));
                $("#additemtamnt").val(total_add_item_amnt.toFixed(2));

                $("#addecheeseitems"+id).val();
                $("#addecheeseitems"+id).attr('data-count', '');
                $("#addecheeseitems"+id).attr('data-itemid', '');
            }

        });

        $("body").delegate(".chutneysingleitem","click",function () {
            var id = $(this).attr('value');
            var price = $(this).attr('price');
            var parent_item_price = $("#tamount").val();
            var additemtamnt = $("#additemtamnt").val();
            var additemtamntint = parseFloat(price);
            
            if(this.checked){
                var total_add_item_amnt = parseFloat(additemtamnt) + parseFloat(price);
                var parent_item_total_price = parseFloat(parent_item_price) + parseFloat(total_add_item_amnt);
                $("#pShow").html("£"+ parent_item_total_price.toFixed(2));
                $("#additemtamnt").val(total_add_item_amnt.toFixed(2));

                $("#addechutneyitems"+id).val(additemtamntint);
                $("#addechutneyitems"+id).attr('data-count', 1);
                $("#addechutneyitems"+id).attr('data-itemid', id);
            } else {
                var total_add_item_amnt = parseFloat(additemtamnt) - parseFloat(price);
                var parent_item_total_price = parseFloat(parent_item_price) + parseFloat(total_add_item_amnt);
                $("#pShow").html("£"+ parent_item_total_price.toFixed(2));
                $("#additemtamnt").val(total_add_item_amnt.toFixed(2));

                $("#addechutneyitems"+id).val();
                $("#addechutneyitems"+id).attr('data-count', '');
                $("#addechutneyitems"+id).attr('data-itemid', '');
            }
        });
        // child checkbox item calculation end


        

        // add to card start
        $("body").delegate("#addToCard","click",function () {

            var allextraaItems = [];
            $( '.extraaitem' ).each( function() {
                var counts = $( this ).data('count');

                // console.log(counts, allextraaItems);
                
                if (counts>0) {
                    allextraaItems.push( {
                    itemname: $( this ).data('itemname'),
                    count: $( this ).data('count'),
                    price: $( this ).val(),
                    id: $( this ).data( 'itemid' )
                    });  
                }
                
            });

            
            

            pqty = $(this).attr('pqty');
            pid = $(this).attr('pid');
            price = $(this).attr('price');
            pname = $(this).attr('pname');
            net_amount = price*pqty;
            
            child_item_total = $("#additemtamnt").val();
            net_amount_with_child_item = parseFloat(net_amount) + parseFloat(child_item_total);


            var card_product_id = $("input[name='parent_product_id[]']")
                        .map(function(){return $(this).val();}).get();
                        
            card_product_id.push(pid);
            seen = card_product_id.filter((s => v => s.has(v) || !s.add(v))(new Set));
            
            if (Array.isArray(seen) && seen.length) {
                parent_product_id = $("#parent_product_id"+pid).val();
                parent_product_qty = $("#parent_product_qty"+pid).val();
                parent_product_price = $("#parent_product_price"+pid).val();
                parent_product_total_price = $("#parent_product_total_price"+pid).val();

                new_parent_product_qty = parseFloat(parent_product_qty) + parseFloat(pqty); 
                new_parent_product_total_price = parseFloat(parent_product_total_price) + parseFloat(net_amount_with_child_item); 

                
                $("#parent_product_qty"+pid).val(new_parent_product_qty);
                $("#parent_product_total_price"+pid).val(new_parent_product_total_price.toFixed(2));
                $("#parent_product_total_price_div"+pid).html(new_parent_product_total_price.toFixed(2));


                var additmshowcard = $("#childitems"+pid);
                // additmshowcard.empty();
                $.each(allextraaItems, function (a, b) {
                    


                    chk_child_item_id = $("#child_product_id"+pid+b.id).val();

                    if (chk_child_item_id) {

                        chk_child_product_qty = $("#child_product_qty"+pid+b.id).val();
                        chk_child_product_total_price = $("#child_product_total_price"+pid+b.id).val();

                        new_child_qty = parseFloat(chk_child_product_qty) + parseFloat(b.count);
                        new_child_t_price = parseFloat(chk_child_product_total_price) + parseFloat(b.price);

                        $("#child_product_total_price"+pid+b.id).val(new_parent_product_total_price.toFixed(2));
                        $("#child_product_total_qty_div"+pid+b.id).html(new_child_qty);
                        
                    } else {

                        additmshowcard.append('<div><input type="hidden" id="related_parent_id" name="related_parent_id[]" value="'+pid+'"><input type="hidden" id="child_product_id'+pid+b.id+'" name="child_product_id[]" value="'+b.id+'"><input type="hidden" id="child_product_qty'+pid+b.id+'" name="child_product_qty[]" value="'+b.count+'"><input type="hidden" id="child_product_name" name="child_product_name[]" value="'+b.itemname+'"><input type="hidden" id="child_product_total_price'+pid+b.id+'" name="child_product_total_price[]" value="'+b.price+'">'+b.itemname+': <span>Price:'+b.price/b.count+'</span> X <span id="child_product_total_qty_div'+pid+b.id+'">Qty:'+b.count+'</span></div>');
                    }

                    
                });

                net_total();
                // alert('This product already added!!');
                $('#additemModal').modal('hide');
                return;
            }

            var markup = '<tr><td style="text-align: center; border:0px"><div style="color: white;  user-select:none;  padding: 5px;    background: red;    width: 35px;    display: flex;    align-items: center; margin-right:5px;   justify-content: center;    border-radius: 4px;   left: 4px;    top: 81px;" onclick="removeRow(event)" >X</div></td><td style="text-align: left; border:0px; width:60%" colspan="2">'+pname+'<input type="hidden" id="parent_product_name" name="parent_product_name[]" value="'+pname+'" class="form-control"><input type="hidden" id="parent_product_id'+pid+'" name="parent_product_id[]" value="'+pid+'" class="form-control"><div class="childitems'+pid+'" id="childitems'+pid+'"><span></span></div></td><td style="text-align: center; border:0px"><input type="number" id="parent_product_qty'+pid+'" name="parent_product_qty[]" min="1" value="'+pqty+'" class="form-control parent_product_qty"></td><td style="text-align: center; border:0px"><div id="parent_product_total_price_div'+pid+'" class="parent_product_total_price_div">'+net_amount_with_child_item.toFixed(2)+'</div><input type="hidden" id="parent_product_price'+pid+'" name="parent_product_price[]" step="any" value="'+price+'" class="form-control parent_product_price" readonly><input type="hidden" id="parent_product_total_price'+pid+'" name="parent_product_total_price[]" step="any" value="'+net_amount_with_child_item.toFixed(2)+'" class="form-control net_amount_with_child_item" readonly><input type="hidden" id="child_items_total_amnt'+pid+'" name="child_items_total_amnt[]" step="any" value="'+child_item_total+'" class="form-control child_items_total_amnt" readonly></td></tr>';
            $("table #cardinner ").append(markup);

            var additmshowcard = $("#childitems"+pid);
            additmshowcard.empty();
            $.each(allextraaItems, function (a, b) {

                additmshowcard.append('<div><input type="hidden" id="related_parent_id" name="related_parent_id[]" value="'+pid+'"><input type="hidden" id="child_product_id'+pid+b.id+'" name="child_product_id[]" value="'+b.id+'"><input type="hidden" id="child_product_qty'+pid+b.id+'" name="child_product_qty[]" value="'+b.count+'"><input type="hidden" id="child_product_name" name="child_product_name[]" value="'+b.itemname+'"><input type="hidden" id="child_product_total_price'+pid+b.id+'" name="child_product_total_price[]" class="child_product_total_price" value="'+b.price+'">'+b.itemname+': <span>Price:'+b.price/b.count+'</span> X <span id="child_product_total_qty_div'+pid+b.id+'">Qty:'+b.count+'</span></div>'); 

            });
            // console.log(additmshowcard);
            net_total();
        
            $("#qty").val('1');
            $("#tamount").val('');
            $("#parent_item_uprice").val('');
            $("#additemtunitamnt").val('0');
            $("#additemtamnt").val('0');
            $('#brdDiv').html('');
            
            $('#additemModal').modal('hide');

            sessionData = markup;
            // sessionData = $("#cardinner").html();

            var addtocardurl = "{{URL::to('/add-to-session-card-item')}}";
            console.log(pid);
            $.ajax({
                url: addtocardurl,
                method: "POST",
                data: {sessionData, pid},

                success: function (d) {
                    if (d.status == 303) {

                    }else if(d.status == 300){
                        
                        
                    }
                },
                error: function (d) {
                    console.log(d);
                }
            });






        });
        // add to card end

        // net total calculation
        function net_total(){
            
            var discount_percent = $("#discount_percent").val();
            var totalamount=0;
            $('.net_amount_with_child_item').each(function(){
                totalamount += ($(this).val()-0);
            })
            if (discount_percent>0) {
                var disAmount = totalamount * discount_percent/100;
                var net_amnt = totalamount - disAmount;
                $("#discount_amount").val(disAmount.toFixed(2));
                $("#discount_div").html(disAmount.toFixed(2));
                $("#net_total_value").val(net_amnt.toFixed(2));
                $("#net_total_amount").html(net_amnt.toFixed(2));

                $("#grand_total_value").val(totalamount.toFixed(2));
                $("#grand_total_amount").html(totalamount.toFixed(2));
                $("#dis_div").show();


            } else {
                
                $("#grand_total_value").val(totalamount.toFixed(2));
                $("#grand_total_amount").html(totalamount.toFixed(2));
                $("#net_total_value").val(totalamount.toFixed(2));
                $("#net_total_amount").html(totalamount.toFixed(2));
                $("#dis_div").hide();
            }

            if (totalamount > 0) {
                $("#cardfooter").show();
            } else {
                $("#cardfooter").hide();
            }
        }
        // net total calculation


        // unit price calculation
        $("body").delegate(".parent_product_qty","keyup",function(event){
            event.preventDefault();
            var row = $(this).parent().parent();
            var quantity = row.find('.parent_product_qty').val();

            if (quantity < 1) {
                var quantity = 1;
            }

            var parent_product_price = row.find('.parent_product_price').val();
            var net_amount_with_child_item = row.find('.net_amount_with_child_item').val();
            var child_items_total_amnt = row.find('.child_items_total_amnt').val();


            var parent_product_total_amount =  parseFloat(parent_product_price) * parseFloat(quantity);
            var new_net_amount_with_child_item =  parseFloat(parent_product_total_amount) + parseFloat(child_items_total_amnt);


            
            console.log(quantity, parent_product_price, net_amount_with_child_item, child_items_total_amnt, parent_product_total_amount, new_net_amount_with_child_item.toFixed(2));
            // var amount = quantity * rate;
            row.find('.net_amount_with_child_item').val(new_net_amount_with_child_item);
            row.find('.parent_product_total_price_div').html(new_net_amount_with_child_item.toFixed(2));
            // row.find('.parent_product_price').val(parent_product_total_amount);
            net_total();
        })


        $("body").delegate(".parent_product_qty","click",function(event){
            event.preventDefault();
            var row = $(this).parent().parent();
            var quantity = row.find('.parent_product_qty').val();

            if (quantity < 1) {
                var quantity = 1;
            }

            var parent_product_price = row.find('.parent_product_price').val();
            var net_amount_with_child_item = row.find('.net_amount_with_child_item').val();
            var child_items_total_amnt = row.find('.child_items_total_amnt').val();


            var parent_product_total_amount =  parseFloat(parent_product_price) * parseFloat(quantity);
            var new_net_amount_with_child_item =  parseFloat(parent_product_total_amount) + parseFloat(child_items_total_amnt);


            
            console.log(quantity, parent_product_price, net_amount_with_child_item, child_items_total_amnt, parent_product_total_amount, new_net_amount_with_child_item.toFixed(2));
            // var amount = quantity * rate;
            row.find('.net_amount_with_child_item').val(new_net_amount_with_child_item);
            row.find('.parent_product_total_price_div').html(new_net_amount_with_child_item.toFixed(2));
            // row.find('.parent_product_price').val(parent_product_total_amount);
            net_total();
        })


        // unit price calculation end




        // submit to purchase 

        $("body").delegate("#orderCreateBtn","click",function(event){
            event.preventDefault();

            $("#loading").show();
            // alert('btn work');
            
            var collection_date = $("#date").val();
            var collection_time = $("#timeslot").val();
            var name = $("#name").val();
            var email = $("#uemail").val();
            var phone = $("#phone").val();
            var house = $("#house").val();
            var street = $("#street").val();
            var city = $("#city").val();
            var postcode = $("#postcode").val();
            var discount_amount = $("#discount_amount").val();
            var discount_percent = $("#discount_percent").val();
            var delivery_type = $('input[name="collection"]:checked').val();
            var payment_type = $('input[name="payment"]:checked').val();

            if (payment_type == "Paypal") {
                var orderurl = "{{URL::to('/payment')}}";
            } else {
                var orderurl = "{{URL::to('/order-store')}}";
            }
            
            var parent_product_name = $("input[name='parent_product_name[]']")
                .map(function(){return $(this).val();}).get();

            var parent_product_id = $("input[name='parent_product_id[]']")
                .map(function(){return $(this).val();}).get();
                
            var parent_product_qty = $("input[name='parent_product_qty[]']")
                .map(function(){return $(this).val();}).get();
                
            var parent_product_price = $("input[name='parent_product_price[]']")
                .map(function(){return $(this).val();}).get();

            var parent_product_total_price = $("input[name='parent_product_total_price[]']")
                .map(function(){return $(this).val();}).get();

                
            var related_parent_id = $("input[name='related_parent_id[]']")
                .map(function(){return $(this).val();}).get();

            var child_product_id = $("input[name='child_product_id[]']")
                .map(function(){return $(this).val();}).get();
                
            var child_product_qty = $("input[name='child_product_qty[]']")
                .map(function(){return $(this).val();}).get();

            var child_product_name = $("input[name='child_product_name[]']")
                .map(function(){return $(this).val();}).get();

            var child_product_total_price = $("input[name='child_product_total_price[]']")
                .map(function(){return $(this).val();}).get();

            $.ajax({
                url: orderurl,
                method: "POST",
                data: {collection_date,collection_time,name,email,phone,parent_product_id,parent_product_qty,parent_product_price,parent_product_total_price,parent_product_name,delivery_type,payment_type,child_product_id,child_product_qty,child_product_total_price,related_parent_id,child_product_name,house,street,city,postcode,discount_percent,discount_amount},

                success: function (d) {
                    console.log(d);
                    if (d.status == 303) {
                        $("#loading").hide();
                        $(".ermsg").html(d.message);
                    }else if(d.status == 300){
                        $("#loading").hide();
                        $(".ermsg").html(d.message);
                        // window.setTimeout(function(){location.reload()},2000)
                        window.open(`https://click.shambleskorner.co.uk/order-confirmation/${d.id}`);
                        // window.open(`https://www.localhost/laravel/foodorder/order-confirmation/${d.id}`);
                        
                    }
                },
                error: function (d) {
                    $("#loading").hide();
                    console.log(d);
                }
            });

        });
        // submit to purchase end

          //check post code start 
      var postcodeurl = "{{URL::to('/check-post-code')}}";
        $("#postcode").keyup(function(){
            var length =  $(this).val().length;

            var postcode = $("#postcode").val();
            var delivery_type = $('input[name="collection"]:checked').val();

            if (delivery_type == "Delivery") {
                if (length > 2) {
                    $.ajax({
                        url: postcodeurl,
                        method: "POST",
                        data: {postcode},

                        success: function (d) {
                            console.log(d);
                            if (d.status == 303) {
                                $(".perrmsg").html(d.message);
                                $('#submitDiv').hide();
                            }else if(d.status == 300){
                                $(".perrmsg").html(d.message);
                                $('#submitDiv').show();
                            }
                        },
                        error: function (d) {
                            console.log(d);
                        }
                    }); 
                }else{
                    $(".perrmsg").html("");
                    $('#submitDiv').show();
                }
            }
            
            

            
        });
        //check post code end 


          //check coupon code start 
      var couponcodeurl = "{{URL::to('/check-coupon-code')}}";
        $("#coupon").keyup(function(){
            var length =  $(this).val().length;

            var coupon = $("#coupon").val();

            if (length > 2) {
                $.ajax({
                    url: couponcodeurl,
                    method: "POST",
                    data: {coupon},

                    success: function (d) {
                        console.log(d);
                        if (d.status == 303) {
                            $(".couponerrmsg").html(d.message);
                            $("#discount_percent").val(0);
                            $("#discount_amount").val(0);
                            $("#discount_div").html("0.00");
                            net_total();

                        }else if(d.status == 300){
                            $(".couponerrmsg").html(d.message);
                            $("#discount_percent").val(d.percentage);
                            net_total();
                        }
                    },
                    error: function (d) {
                        console.log(d);
                    }
                }); 
            }else{
                $(".couponerrmsg").html("");
            }
            
        });
        //check coupon code end 
        

    });
</script>


@endsection