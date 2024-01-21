@extends('admin.layouts.admin')

@section('content')

<!-- content area -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="pagetitle pb-2">
                <a href="{{route('admin.order')}}"  class="btn-theme bg-primary">Back</a>
            </div>
        </div>
    </div>
    

    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="background-color: #fdf3ee">
                    <div class="card-header">
                        <h3> Order Information</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="text-align: center">Date</th>
                                <th style="text-align: center">Name</th>
                                <th style="text-align: center">Phone</th>
                                <th style="text-align: center">Email</th>
                                <th style="text-align: center">Total Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center">{{$data->date}}</td>
                                    <td style="text-align: center">{{$data->name}}</td>
                                    <td style="text-align: center">{{$data->phone}}</td>
                                    <td style="text-align: center">{{$data->email}}</td>
                                    <td style="text-align: center">{{$data->net_amount}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="background-color: #fdf3ee">
                    <div class="card-header">
                        <h3> Product Details</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover" id="example">
                            <thead>
                                <tr>
                                    <th style="text-align: center">SL</th>
                                    <th style="text-align: center">Product name</th>
                                    <th style="text-align: center">Quantity</th>
                                    <th style="text-align: center">Price per unit</th>
                                    <th style="text-align: center">Total price</th>
                                    <th style="text-align: center">
                                        Additional Items
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td style="text-align: center">{{ $key + 1 }}</td>
                                        <td style="text-align: center">
                                            {{$order->product_name}}
                                        </td>
                                        <td style="text-align: center">{{$order->quantity}}</td>
                                        <td style="text-align: center">{{$order->price_per_unit}}</td>
                                        <td style="text-align: center">{{$order->total_price}}</td>
                                        <td style="text-align: center">
                                            <a href="#" class="btn-theme bg-primary w-100 ms-1"  data-bs-toggle="modal" data-bs-target="#viewMore{{$order->id}}">Items</a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="viewMore{{$order->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header py-2 bg-primary">
                                                            <h4 class="modal-title fw-bold my-1 text-white" id="exampleModalLabel">Donations</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row px-3 mb-2">
                                                                <!-- loop -->
                                                                <table class="table table-bordered table-hover">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="text-align: center">Name</th>
                                                                        <th style="text-align: center">Quantity</th>
                                                                        <th style="text-align: center">Price per unit</th>
                                                                        <th style="text-align: center">Total Amount</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($order->orderadditionalitem as $item)
                                                                            
                                                                        <tr>
                                                                            <td style="text-align: center">{{$item->item_name}}</td>
                                                                            <td style="text-align: center">{{$item->quantity}}</td>
                                                                            <td style="text-align: center">{{$item->price_per_unit}}</td>
                                                                            <td style="text-align: center">{{$item->total_amount}}</td>
                                                                        </tr>

                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


        
</div>


@endsection
@section('script')

<script>
    
</script>
<script>
    $(document).ready(function () {

        //header for csrf-token is must in laravel
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //
            
            

            

            

    });

    
</script>
@endsection