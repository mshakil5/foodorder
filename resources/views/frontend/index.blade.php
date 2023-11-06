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
</style>

<div class="container mt-5">
    <div class="row">
    
        <div class="col-md-2 col-xs-4">
            <ul class="list-group" id="get_category">
                @foreach (\App\Models\Category::orderby('id','ASC')->get() as $cat)
                    
                <li><button value="{{$cat->id}}" class='category list-group-item getsrchval'>{{$cat->name}}</button></li>

                @endforeach
                
            </ul>
        </div>

        <div class="col-md-5 col-xs-8">		
            <div class="row" id="get_product">
                @foreach ($products as $product)
                    <div class='col-md-9 col-xs-12'>
                        <h3 style='margin-top: 0px'>{{$product->product_name}}</h3>
                        <p>{{$product->description}}</p>
                        <input type='text' placeholder='Note' class='' style='width:100%;border:1px solid black;margin-bottom:20px;' />
                    </div>
                    <div class='col-md-2 col-xs-6'>£{{ number_format($product->price, 2) }}</div>
                    <div class='col-md-1 col-xs-6'>
                        @if ($product->assign == 1)
                            <button class="btn btn-primary btn-sm btn-modal" data-toggle="modal" data-target="#additemModal" style="margin-left: -7px;" pid="{{$product->id}}" pname="{{$product->product_name}}" pdesc="{{$product->description}}" price="{{ number_format($product->price, 2) }}">
                                 add
                            </button>
                        @else
                            <button class="btn btn-primary btn-sm" style="margin-left: -7px;">Add</button>
                        @endif
                    </div>
                @endforeach
                
            </div>	
        </div>

            <!--************************************* right side cart div start ************************************************* -->

        <div class="col-md-5 col-xs-12"> 
            <!--**********************************cart item start *************************************************-->
            <div id="cart_checkout">
                
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
                                    <div class="col-md-2 col-xs-2"><b>Action</b></div>
                                    <div class="col-md-3 col-xs-4"><b>Name</b></div>
                                    <div class="col-md-2 col-xs-2"><b>Quantity</b></div>
                                    <div class="col-md-2 col-xs-2"><b>Price</b></div>
                                    <div class="col-md-3 col-xs-2"><b>Total £</b></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 col-xs-3">
                                        <div class="btn-group">
                                            <a href="#" remove_id="'.$cart_item_id.'" class="btn btn-danger remove"><span class="glyphicon glyphicon-trash"></span></a>
                                        </div>
                                    </div>
                                    <input type="hidden" name="product_id[]" value=""/>
                                    <input type="hidden" name="" value=""/>								
                                    <div class="col-md-3 col-xs-3">Full English Breakfast Tray</div>
                                    <div class="col-md-2 col-xs-2">
                                        <input type="text" class="form-control qty" value="2" >
                                    </div>
                                    <div class="col-md-2 col-xs-2">
                                        <input type="text" class="form-control price"  value="£12.95" readonly="readonly">
                                    </div>
                                    <div class="col-md-3 col-xs-2">
                                        <input type="text" class="form-control total" value="£12.95" readonly="readonly">
                                    </div>
                                </div>
                            </div>

                            <!--**********************************cart item end *************************************************-->
                            <div id="cart_info">
                                
                            </div>	

                        </div>
                                <!--************************************* right side cart div end ************************************************* -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-md-4">Payment Option</div> 
                                        </div> 
                                    </div> 
                                    <div class="panel-body"> 
                                        <div class="row"> 
                                            <div class="col-md-6 col-xs-12"><b>
                                                <div class="radio"> 
                                                    <label><input type="radio" name="payment" value="Paypal" checked>Paypal</label>
                                                </div> </b>
                                            </div> 
                                            <div class="col-md-6 col-xs-12"><b>
                                                <div class="radio"> 
                                                    <label><input type="radio" name="payment" value="Cash">Cash</label>
                                                </div></b>
                                            </div> 
                                        </div> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                        <!--**********************************Payment Option end*************************************************--> <!--**********************************Collection Option start*************************************************--> 
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="panel panel-primary"> 
                                    <div class="panel-heading"> 
                                        <div class="row"> 
                                            <div class="col-md-4">Collection Option</div> 
                                        </div> 
                                    </div> 
                                    <div class="panel-body"> 
                                        <div class="row"> 
                                            <div class="col-md-6 col-xs-12">
                                                <b>
                                                <div class="radio"> 
                                                    <label for="clnChkNo" class="rmvDiv">
                                                    <input type="radio" name="collection" value="Collection" class="rmvDiv" id="clnChkNo" onclick="ShowHideDivforCln()" checked>Collection</label> <p>Within 20 Minutes</p> 
                                                </div>
                                                </b>
                                            </div> 
                                            <div class="col-md-6 col-xs-12"><b>
                                                <div class="radio"> 
                                                    <label for="clnChkYes">
                                                    <input type="radio" name="collection" value="Delivery" id="clnChkYes" onclick="ShowHideDivforCln()">Delivery</label> <p>Within 60 Minutes</p> 
                                                </div></b>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="delivery">Collection/Delivery Date</label><input type="text" class="date-picker form-control hasDatepicker" name="date" id="date" placeholder="Select date" required="">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="delivery">Collection/Delivery Time</label> 
                                                <select id="timeslot" class="form-control"  name="timeslot">					
                                                <option value="0">Delivery/Collection time</option>
                                                <option value="11:00am - 11:10am">11:00am - 11:10am</option>
                                                <option value="11:10am - 11:20am">11:10am - 11:20am</option>
                                                <option value="11:20am - :1130am">11:20am - :1130am</option>
                                                <option value="11:30am - 11:40am">11:30am - 11:40am</option>
                                                <option value="11:40am - 11:50am">11:40am - 11:50am</option>
                                                <option value="11:50am - 12:00pm">11:50am - 12:00pm</option>
                                                <option value="12:00pm - 12:10pm">12:00pm - 12:10pm</option>
                                                <option value="12:10pm - 12:20pm">12:10pm - 12:20pm</option>
                                                <option value="12:20pm - 12:30pm">12:20pm - 12:30pm</option>
                                                <option value="12:30pm - 12:40pm">12:30pm - 12:40pm</option>
                                                <option value="12:40pm - 12:50pm">12:40pm - 12:50pm</option>
                                                <option value="1:00pm - 1:10pm">1:00pm - 1:10pm</option>
                                                <option value="1:10pm - 1:20pm">1:10pm - 1:20pm</option>
                                                <option value="1:20pm - 1:30pm">1:20pm - 1:30pm</option>
                                                <option value="1:30pm - 1:40pm">1:30pm - 1:40pm</option>
                                                <option value="1:40pm - 1:50pm">1:40pm - 1:50pm</option>
                                                <option value="1:50pm - 2:00pm">1:50pm - 2:00pm</option>
                                                <option value="2:00pm - 2:10pm">2:00pm - 2:10pm</option>
                                                <option value="2:10pm - 2:20pm">2:10pm - 2:20pm</option>
                                                <option value="2:20pm - 2:30pm">2:20pm - 2:30pm</option>
                                                <option value="2:30pm - 2:40pm">2:30pm - 2:40pm</option>
                                                <option value="2:40pm - 2:50pm">2:40pm - 2:50pm</option>
                                                <option value="2:50pm - 3:00pm">2:50pm - 3:00pm</option>
                                                <option value="3:00pm - 3:10pm">3:00pm - 3:10pm</option>
                                                <option value="3:10pm - 3:20pm">3:10pm - 3:20pm</option>
                                                <option value="3:20pm - 3:30pm">3:20pm - 3:30pm</option>
                                                <option value="3:30pm - 3:40pm">3:30pm - 3:40pm</option>
                                                <option value="3:40pm - 3:50pm">3:40pm - 3:50pm</option>
                                                <option value="3:50pm - 4:00pm">3:50pm - 4:00pm</option>
                                                <option value="4:00pm - 4:10pm">4:00pm - 4:10pm</option>
                                                <option value="4:10pm - 4:20pm">4:10pm - 4:20pm</option>
                                                <option value="4:20pm - 4:30pm">4:20pm - 4:30pm</option>
                                                <option value="4:30pm - 4:40pm">4:30pm - 4:40pm</option>
                                                <option value="4:40pm - 4:50pm">4:40pm - 4:50pm</option>
                                                <option value="4:50pm - 5:00pm">4:50pm - 5:00pm</option>
                                                <option value="5:00pm - 5:10pm">5:00pm - 5:10pm</option>
                                                <option value="5:10pm - 5:20pm">5:10pm - 5:20pm</option>
                                                <option value="5:20pm - 5:30pm">5:20pm - 5:30pm</option>
                                                <option value="5:30pm - 5:40pm">5:30pm - 5:40pm</option>
                                                <option value="5:40pm - 5:50pm">5:40pm - 5:50pm</option>
                                                <option value="5:50pm - 6:00pm">5:50pm - 6:00pm</option>
                                                <option value="6:00pm - 6:10pm">6:00pm - 6:10pm</option>
                                                <option value="6:10pm - 6:20pm">6:10pm - 6:20pm</option>
                                                <option value="6:20pm - 6:30pm">6:20pm - 6:30pm</option>
                                                <option value="6:30pm - 6:40pm">6:30pm - 6:40pm</option>
                                                <option value="6:40pm - 6:50pm">6:40pm - 6:50pm</option>
                                                <option value="6:50pm - 7:00pm">6:50pm - 7:00pm</option>
                                                <option value="7:00pm - 7:10pm">7:00pm - 7:10pm</option>
                                                <option value="7:10pm - 7:20pm">7:10pm - 7:20pm</option>
                                                <option value="7:20pm - 7:30pm">7:20pm - 7:30pm</option>
                                                <option value="7:30pm - 7:40pm">7:30pm - 7:40pm</option>
                                                <option value="7:40pm - 7:50pm">7:40pm - 7:50pm</option>
                                                <option value="7:50pm - 8:00pm">7:50pm - 8:00pm</option>
                                                <option value="8:00pm - 8:10pm">8:00pm - 8:10pm</option>
                                                <option value="8:10pm - 8:20pm">8:10pm - 8:20pm</option>
                                                <option value="8:20pm - 8:30pm">8:20pm - 8:30pm</option>
                                                <option value="8:30pm - 8:40pm">8:30pm - 8:40pm</option>
                                                <option value="8:40pm - 8:50pm">8:40pm - 8:50pm</option>
                                                <option value="8:50pm - 9:00pm">8:50pm - 9:00pm</option>
                                                <option value="9:00pm - 9:10pm">9:00pm - 9:10pm</option>
                                                <option value="9:10pm - 9:20pm">9:10pm - 9:20pm</option>
                                                <option value="9:20pm - 9:30pm">9:20pm - 9:30pm</option>
                                                <option value="9:30pm - 9:40pm">9:30pm - 9:40pm</option>
                                                <option value="9:40pm - 9:50pm">9:40pm - 9:50pm</option>
                                                <option value="9:50pm - 10:00pm">9:50pm - 10:00pm</option>
                                                <option value="10:00pm - 10:10pm">10:00pm - 10:10pm</option>
                                                <option value="10:10pm - 10:20pm">10:10pm - 10:20pm</option>
                                                <option value="10:20pm - 10:30pm">10:20pm - 10:30pm</option>
                                                <option value="10:30pm - 10:40pm">10:30pm - 10:40pm</option>
                                                <option value="10:40pm - 10:50pm">10:40pm - 10:50pm</option>
                                                <option value="10:50pm - 11:00pm">10:50pm - 11:00pm</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row"> 
                            <div class="col-md-12"> 
                                <div class="panel panel-primary"> 
                                    <div class="panel-heading"> 
                                        <div class="row"> 
                                            <div class="col-md-4">Your Details</div> 
                                        </div> 
                                    </div> 
                                    <div class="panel-body"> 
                                        <div class="row"> 
                                            <div class="col-md-12 col-xs-12"> 
                                                <div class="form-group"> 
                                                    <label for="name">Name</label> 
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="John"> 
                                                </div> 
                                                <div class="form-group"> 
                                                    <label for="email">Mail</label> 
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="example@mail.com"> 
                                                </div> 
                                                <div class="form-group"> 
                                                    <label for="contactno">Contact No</label> 
                                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="mobile"> 
                                                </div>
                                            </div> 
                                        </div> 
                                    </div> 
                                </div> 
                            </div> 
                        </div>

                        <input type="button" id="gust-signup-form" style="float:right;" name="login_user_with_product" class="btn btn-info btn-lg" value="Submit Order">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!----------------------------additemModal ------------------------->
<div class="modal fade transfer-modal" id="additemModal">
    <div class="modal-dialog modal-dialog-scrollable ">
        <div class="modal-content">
            <div class="modal-header alert alert-success" style="text-align: left;">
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="pnameshow"></h4>
                </div>
            </div>
            <div class="modal-body transferProduct">
                
                <div class="row text-left tValues">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="row">
                            
                            <p align="center"> <b><span id="priceShow"></span></b> </p>
                            <p align="center"><span id="descShow"></span></p>
                        </div>
                    </div>
                </div>

                <div class="row text-left tValues addons" style="display: none">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="title-section">
                                <div class="mx-2">Add-ons </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover addonsitem" style="width: 100%">
                    <tbody>
                    </tbody>
                </table>

                <div class="row text-left tValues breads" style="display: none">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="title-section">
                                <div class="mx-2">Choose Bread </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover breadsitem" style="width: 100%">
                    <tbody>
                    </tbody>
                </table>

                <div class="row text-left tValues cheese" style="display: none">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="title-section">
                                <div class="mx-2">Choose Cheese </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover cheeseitem" style="width: 100%">
                    <tbody>
                    </tbody>
                </table>

                <div class="row text-left tValues chutney" style="display: none">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="title-section">
                                <div class="mx-2">Chutney and Sauces </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover chutneyitem" style="width: 100%">
                    <tbody>
                    </tbody>
                </table>

                <div class="row text-left tValues toppings" style="display: none">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="title-section">
                                <div class="mx-2">Optional Toppings </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover toppingsitem" style="width: 100%">
                    <tbody>
                    </tbody>
                </table>


                <div class="row text-left tValues extoppings" style="display: none">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="title-section">
                                <div class="mx-2">Extra Toppings </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover extoppingsitem" style="width: 100%">
                    <tbody>
                    </tbody>
                </table>


                <div class="modal-footer">
                    <div class="center-form">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus add" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg> 
                        </button>
                        
                        {{-- <input type="button" value="+" id="add1" class="add" /> --}}
                        <input type="hidden" id="qty" value="1" min="1" class="qty" />
                        {{-- <input type="button" value="-" id="minus1" class="minus" /> --}}
        
                          <b> <span style="font-size: 22px;" id="pShow"></span>   </b>
                          <input type="hidden" id="unitprice" name="unitprice" value="">
        
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-dash minus" viewBox="0 0 16 16">
                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                            </svg>
                        </button>
        
                    </div><br>

                    <div class="row text-left tValues">
                        <div class="col-sm-12">
                            <div class="row">
                                
                                <button type="submit" class="btn btn-success btn-lg btn-block">
                                    Add to order
                                </button>

                            </div>
                        </div>
                    </div>


                        
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>



@endsection

@section('script')

<script>
    $(function()
        {
            $(".add").click(function()
            {
                var currentVal = parseInt($("#qty").val());
                var unitprice = $("#unitprice").val();
                var priceperunit = (currentVal+1)*unitprice;
                var amt = parseFloat(priceperunit);
                
                if (currentVal != NaN)
                {
                    $("#qty").val(currentVal + 1);
                    $("#pShow").html("£"+ amt.toFixed(2));
                }
            });

            $(".minus").click(function()
            {
                var currentVal = parseInt($("#qty").val());
                var unitprice = $("#unitprice").val();
                var priceperunit = (currentVal-1)*unitprice;
                var amt = parseFloat(priceperunit);
                
                if (currentVal != NaN)
                {
                    if(currentVal > 1){
                        $("#qty").val(currentVal - 1);
                        $("#pShow").html("£"+ amt.toFixed(2));
                    }

                }
            });
        });


         // header for csrf-token is must in laravel
         $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        // 

    $(document).ready(function() {

        var urlbr = "{{URL::to('/get-additional-product')}}";

        $(document).on('click', '.btn-modal', function () {
            let stockid = $(this).val();
            pdesc = $(this).attr('pdesc');
            productid = $(this).attr('pid');
            pname = $(this).attr('pname');
            price = $(this).attr('price');
            
            $('#additemModal').find('.modal-body #productname').val(pname);
            $('#additemModal').find('.modal-body #productid').val(productid);
            $('#additemModal').find('.modal-body #pdesc').val(pdesc);
            $("#pnameshow").html(pname);
            $("#descShow").html(pdesc);
            $("#priceShow").html("£"+price);
            $("#pShow").html("£"+price);
            $("#unitprice").val(price);
            $('#additemModal').find('.modal-body #price').val(price);

            // loop start
            $.ajax({
                    url: urlbr,
                    method: "POST",
                    data: {productid:productid},

                    success: function (d) {
                            console.log(d);
                        if (d.status == 303) {

                        }else if(d.status == 300){
                            
                            $(".breads").hide();
                            $(".cheese").hide();
                            $(".chutney").hide(100);
                            $(".toppings").hide(100);
                            $(".extoppings").hide(100);

                            // breadsitems
                            var breadsitems = $(".breadsitem tbody");
                            breadsitems.empty();
                            $.each(d.items, function (a, b) {
                                if (b.additional_item_title_id == 5) {
                                    $(".breads").show(100);
                                    breadsitems.append("<tr><td style='width: 10%; text-align:center'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle' viewBox='0 0 16 16' style='height:22px'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/></svg></td><td style='width: 70%'>" + b.item_name + "</td>" + "<td style='width: 20%; text-align:right'>£" +b.price +"</td>" + "</tr>"); 
                                }
                            });
                            // breadsitems end

                            //cheese items start
                            var cheeseitems = $(".cheeseitem tbody");
                            cheeseitems.empty();
                            $.each(d.items, function (a, b) {

                                    // add-ons product
                                if (b.additional_item_title_id == 4) {
                                    $(".cheese").show(100);
                                    cheeseitems.append("<tr><td style='width: 10%; text-align:center'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle' viewBox='0 0 16 16' style='height:22px'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/></svg></td><td style='width: 70%'>" + b.item_name + "</td>" + "<td style='width: 20%; text-align:right'>£" +b.price +"</td>" + "</tr>"); 
                                }
                                
                            });
                            //cheese items end

                            //Chutney and Sauces start
                            var chutneyitems = $(".chutneyitem tbody");
                            chutneyitems.empty();
                            $.each(d.items, function (a, b) {
                                if (b.additional_item_title_id == 4) {
                                    $(".chutney").show(100);
                                    chutneyitems.append("<tr><td style='width: 10%; text-align:center'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle' viewBox='0 0 16 16' style='height:22px'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/></svg></td><td style='width: 70%'>" + b.item_name + "</td>" + "<td style='width: 20%; text-align:right'>£" +b.price +"</td>" + "</tr>"); 
                                }
                            });
                            //Chutney and Sauces end

                            //toppings item start
                            var toppingsitems = $(".toppingsitem tbody");
                            toppingsitems.empty();
                            $.each(d.items, function (a, b) {
                                if (b.additional_item_title_id == 1) {
                                    $(".toppings").show(100);
                                    toppingsitems.append("<tr><td style='width: 10%; text-align:center'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle' viewBox='0 0 16 16' style='height:22px'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/></svg></td><td style='width: 70%'>" + b.item_name + "</td>" + "<td style='width: 20%; text-align:right'>£" +b.price +"</td>" + "</tr>"); 
                                }
                            });
                            //toppings item end

                            //extra toppings item start
                            var extoppingsitems = $(".extoppingsitem tbody");
                            extoppingsitems.empty();
                            $.each(d.items, function (a, b) {
                                if (b.additional_item_title_id == 2) {
                                    $(".extoppings").show(100);
                                    extoppingsitems.append("<tr><td style='width: 10%; text-align:center'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle' viewBox='0 0 16 16' style='height:22px'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/></svg></td><td style='width: 70%'>" + b.item_name + "</td>" + "<td style='width: 20%; text-align:right'>£" +b.price +"</td>" + "</tr>"); 
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

    });
</script>
    
@endsection