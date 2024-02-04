@extends('admin.layouts.admin')

@section('content')

<!-- content area -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="pagetitle pb-2">
                All Orders
            </div>
        </div>
    </div>
    
    
    <hr>
    <div id="contentContainer">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="background-color: #fdf3ee">
                    <div class="card-header">
                        <h3> All Data</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover" id="example">
                            <thead>
                            <tr>
                                <th style="text-align: center">SL</th>
                                <th style="text-align: center">Date</th>
                                <th style="text-align: center">Name</th>
                                <th style="text-align: center">Phone</th>
                                <th style="text-align: center">Email</th>
                                <th style="text-align: center">Payment Method</th>
                                <th style="text-align: center">Total Amount</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $data)
                                    <tr>
                                        <td style="text-align: center">{{ $key + 1 }}</td>
                                        <td style="text-align: center">{{$data->date}}</td>
                                        <td style="text-align: center">{{$data->name}}</td>
                                        <td style="text-align: center">{{$data->phone}}</td>
                                        <td style="text-align: center">{{$data->email}}</td>
                                        <td style="text-align: center">{{$data->payment_type}}</td>
                                        <td style="text-align: center">{{$data->net_amount}}</td>
                                        <td style="text-align: center">
                                            {{-- <a href="{{route('admin.orderDeatils', $data->id)}}"> <i class="fa fa-eye" style="color: #2196f3;font-size:16px;"> </i></a> --}}

                                            {{-- order details show  --}}

                                            <a href="#" class="btn-theme bg-primary w-100 ms-1"  data-bs-toggle="modal" data-bs-target="#viewMore{{$data->id}}">Items</a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="viewMore{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header py-2 bg-primary">
                                                            <h4 class="modal-title fw-bold my-1 text-white" id="exampleModalLabel">Order Details</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">


                                                            @include('admin.order.modal')

                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            {{-- order details show  --}}









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