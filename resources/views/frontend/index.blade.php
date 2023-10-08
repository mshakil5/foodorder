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
</style>

<div class="container mt-5">
    <div class="row">
    
        <div class="col-md-2 col-xs-4">
            <ul class="list-group" id="get_category">
                @foreach (\App\Models\Category::orderby('id','ASC')->get() as $cat)
                    
                <li><a href='#' class='category list-group-item'>{{$cat->name}}</a></li>
                @endforeach
                
            </ul>
        </div>

        <div class="col-md-5 col-xs-8">		
            <div class="row" id="get_product">
                @foreach (\App\Models\Product::all() as $product)
                    <div class='col-md-9 col-xs-12'>
                        <h3 style='margin-top: 0px'>{{$product->product_name}}</h3>
                        <p>{{$product->description}}</p>
                        <input type='text' placeholder='Note' class='' style='width:100%;border:1px solid black;margin-bottom:20px;' />
                    </div>
                    <div class='col-md-2 col-xs-6'>£{{ number_format($product->price, 2) }}</div>
                    <div class='col-md-1 col-xs-6'>
                        @if ($product->assign == 1)
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal" style="margin-left: -7px;">Add</button>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog">
                                
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">{{$product->product_name}}</h4>
                                    </div>
                                    <div class="modal-body">
                                    <p align="center"> <b>£{{ number_format($product->price, 2) }}</b> </p>
                                    <p align="center">{{$product->description}}</p>

                                    <div class="title-section">
                                        <div class="mx-2">Add-ons </div>
                                    </div>

                                    <table>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>




                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                
                                </div>
                            </div>


                        @else
                            <button class="btn btn-danger btn-sm" style="margin-left: -7px;">Add</button>
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




@endsection