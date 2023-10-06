@extends('admin.layouts.admin')

@section('content')


<div class="stsermsg"></div>
    <hr>
    <div id="contentContainer">
        <form action="{{route('admin.assignProductStore')}}" method="POST">
            @csrf
            <div class="row">
                <input type="hidden" name="product_id" id="product_id" value="{{$data->id}}">

                @foreach ($additionalproducts as $key => $title)
                <div class="col-md-6">
                    <div class="card" style="background-color: #fdf3ee">
                        <div class="card-header">
                            <h3> {{$title->name}}</h3>
                        </div>
                        <div class="card-body">
                            
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">SL</th>
                                        <th style="text-align: center">Name</th>
                                        <th style="text-align: center">Item Status</th>
                                        <th style="text-align: center">Amount</th>
                                        <th style="text-align: center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($title->additionalitem as $key => $item)
                                        <tr>
                                            <td style="text-align: center">{{$key+1}}</td>
                                            <td style="text-align: center">{{$item->item_name}}</td>
                                            <td style="text-align: center">
                                            @if ($item->item_status == 1)
                                                Required
                                            @else
                                                Optional
                                            @endif    
                                            </td>
                                            <td style="text-align: center">{{$item->amount}}</td>
                                            <td style="text-align: center">
                                                <input type="checkbox" name="itemid[]" value="{{$item->id}}" class="form-check-label" @foreach (json_decode($data->assignitem) as $assignitem) @if ($assignitem == $item->id) checked @endif @endforeach>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
                
                @endforeach

                <div class="col-lg-12 mt-2">
                    <div class="form-group ">
                        <button class="btn-theme bg-primary" type="submit">Save</button>
                    </div>
                </div>

                
                
            </div>
        </form>
    </div>
</div>


@endsection
@section('script')


<script>
    $(document).ready(function () {

        

        //header for csrf-token is must in laravel
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //
            var url = "{{URL::to('/admin/additional-items')}}";
            var updateurl = "{{URL::to('/admin/additional-items-update')}}";
            // console.log(url);
            $("#addBtn").click(function(){
                // fundraiser create 
                    var form_data = new FormData();
                    form_data.append("additional_item_title_id", $("#additional_item_title_id").val());
                    form_data.append("item_status", $("#item_status").val());
                    form_data.append("item_name", $("#item_name").val());
                    form_data.append("description", $("#description").val());
                    form_data.append("amount", $("#amount").val());
                    
                    $.ajax({
                        url: url,
                        method: "POST",
                        contentType: false,
                        processData: false,
                        data:form_data,
                        success: function (d) {
                            if (d.status == 303) {
                                $(".ermsg").html(d.message);
                            }else if(d.status == 300){
                                pagetop();
                                $(".ermsg").html(d.message);
                                window.setTimeout(function(){location.reload()},2000)
                            }
                        },
                        error: function (d) {
                            console.log(d);
                        }
                    });

                // fundraiser create 

            });

            
            

    });

    
</script>
@endsection