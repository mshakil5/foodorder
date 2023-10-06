@extends('admin.layouts.admin')

@section('content')

<!-- content area -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="pagetitle pb-2">
                Product
            </div>
        </div>
    </div>
<div id="addThisFormContainer">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: #fdf3ee">
                <div class="card-header">
                    <h5>Product create form</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="ermsg">
                        </div>
                        <div class="col-md-12">
                          <div class="tile">
                            <div class="row">
                                <div class="col-lg-6">
                                    {!! Form::open(['url' => 'admin/master/create','id'=>'createThisForm']) !!}
                                    {!! Form::hidden('codeid','', ['id' => 'codeid']) !!}
                                    @csrf
                                    <div>
                                        <label for="product_name">Product Name</label>
                                        <input type="text" id="product_name" name="product_name" class="form-control">
                                    </div>

                                    <div>
                                        <label for="name">Brand Name</label>
                                        <select name="brand_id" id="brand_id" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="name">Category</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($category as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="description">Product Description</label>
                                        <input type="text" id="description" name="description" class="form-control">
                                    </div>
                                </div>

                                
                                <div class="col-lg-6">
                                    <div>
                                        <label for="stock_qty">Stock Qty</label>
                                        <input type="number" id="stock_qty" name="stock_qty" class="form-control">
                                    </div>

                                    <div>
                                        <label for="price">Selling Price</label>
                                        <input type="number" id="price" name="price" class="form-control">
                                    </div>

                                    <div>
                                        <label for="image">Image</label>
                                        <input type="file" id="image" name="image" class="form-control">
                                    </div>

                                </div>
                                
                            </div>
                            <div class="tile-footer">
                                <hr>
                                <input type="button" id="addBtn" value="Create" class="btn-theme bg-primary">
                                <input type="button" id="FormCloseBtn" value="Close" class="btn-theme btn-warning">
                                {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

<button id="newBtn" type="button" class="btn-theme bg-primary">Add New</button>
<div class="stsermsg"></div>
    @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session::get('success') }} </strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
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
                                <th style="text-align: center">Name</th>
                                <th style="text-align: center">Brand</th>
                                <th style="text-align: center">Category</th>
                                <th style="text-align: center">Price</th>
                                <th style="text-align: center">Image</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $data)
                                    <tr>
                                        <td style="text-align: center">{{ $key + 1 }}</td>
                                        <td style="text-align: center">{{$data->product_name}}</td>
                                        <td style="text-align: center">
                                            @if (isset($data->brand_id))
                                                {{$data->brand->name}}
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            @if (isset($data->category_id))
                                                {{$data->category->name}}
                                            @endif
                                        </td>
                                        <td style="text-align: center">{{$data->price}}</td>
                                        <td style="text-align: center">
                                            @if ($data->image)
                                            <img src="{{asset('images/product/'.$data->image)}}" height="120px" width="220px" alt="">
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            @if ($data->assign == 1)
                                            <a href="{{route('admin.assignProductEdit', $data->id)}}"> <i class="fa fa-plus" style="color: #f34f21;font-size:16px;"> </i></a>

                                            @else
                                            <a href="{{route('admin.assignProduct', $data->id)}}"> <i class="fa fa-plus" style="color: #2196f3;font-size:16px;"> </i></a>
                                            @endif
                                            
                                            <a id="EditBtn" rid="{{$data->id}}"> <i class="fa fa-edit" style="color: #2196f3;font-size:16px;"> </i></a>
                                            <a id="deleteBtn" rid="{{$data->id}}"> <i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a>
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
    $(function() {
      $('.fundraiserstatus').change(function() {
        var url = "{{URL::to('/admin/active-fundraiser')}}";
          var status = $(this).prop('checked') == true ? 1 : 0;
          var id = $(this).data('id');
           console.log(id);
          $.ajax({
              type: "GET",
              dataType: "json",
              url: url,
              data: {'status': status, 'id': id},
              success: function(d){
                // console.log(data.success)
                if (d.status == 303) {
                        pagetop();
                        $(".stsermsg").html(d.message);
                        window.setTimeout(function(){location.reload()},2000)
                    }else if(d.status == 300){
                        pagetop();
                        $(".stsermsg").html(d.message);
                        window.setTimeout(function(){location.reload()},2000)
                    }
                },
                error: function (d) {
                    console.log(d);
                }
          });
      })
    })
</script>
<script>
    $(document).ready(function () {

        $("#addThisFormContainer").hide();
            $("#newBtn").click(function(){
                clearform();
                $("#newBtn").hide(100);
                $("#addThisFormContainer").show(300);

            });
            $("#FormCloseBtn").click(function(){
                $("#addThisFormContainer").hide(200);
                $("#newBtn").show(100);
                clearform();
            });

        //header for csrf-token is must in laravel
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //
            var url = "{{URL::to('/admin/product')}}";
            var updateurl = "{{URL::to('/admin/product-update')}}";
            // console.log(url);
            $("#addBtn").click(function(){
                // fundraiser create 
                if($(this).val() == 'Create') {

                    var file_data = $('#image').prop('files')[0];
                    if(typeof file_data === 'undefined'){
                        file_data = 'null';
                    }

                    var form_data = new FormData();
                    form_data.append('image', file_data);
                    form_data.append("product_name", $("#product_name").val());
                    form_data.append("brand_id", $("#brand_id").val());
                    form_data.append("category_id", $("#category_id").val());
                    form_data.append("description", $("#description").val());
                    form_data.append("stock_qty", $("#stock_qty").val());
                    form_data.append("price", $("#price").val());
                    
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
                }
                // fundraiser create 
                //Update
                if($(this).val() == 'Update'){
                    var file_data = $('#image').prop('files')[0];
                    if(typeof file_data === 'undefined'){
                        file_data = 'null';
                    }
                    var form_data = new FormData();
                    form_data.append('image', file_data);
                    form_data.append("product_name", $("#product_name").val());
                    form_data.append("brand_id", $("#brand_id").val());
                    form_data.append("category_id", $("#category_id").val());
                    form_data.append("description", $("#description").val());
                    form_data.append("stock_qty", $("#stock_qty").val());
                    form_data.append("price", $("#price").val());
                    form_data.append("codeid", $("#codeid").val());
                    
                    $.ajax({
                        url: updateurl,
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
                }
                //Update

            });

            //Edit
            $("#contentContainer").on('click','#EditBtn', function(){
                $accountid = $(this).attr('rid');
                $info_url = url + '/'+$accountid+'/edit';
                $.get($info_url,{},function(d){
                    populateForm(d);
                    pagetop();
                });
            });
            //Edit  end

            //Delete
            $("#contentContainer").on('click','#deleteBtn', function(){
                if(!confirm('Sure?')) return;
                codeid = $(this).attr('rid');
                info_url = url + '/'+codeid;
                $.ajax({
                    url:info_url,
                    method: "GET",
                    type: "DELETE",
                    data:{
                    },
                    success: function(d){
                        if(d.success) {
                            alert(d.message);
                            location.reload();
                        }
                    },
                    error:function(d){
                        console.log(d);
                    }
                });
            });
            //Delete

            function populateForm(data){
                $("#product_name").val(data.product_name);   
                $("#brand_id").val(data.brand_id);   
                $("#category_id").val(data.category_id);   
                $("#description").val(data.description);   
                $("#stock_qty").val(data.stock_qty);   
                $("#price").val(data.price);   
                $("#codeid").val(data.id);
                $("#addBtn").val('Update');
                $("#addThisFormContainer").show(300);
                $("#newBtn").hide(100);
            }

            function clearform(){
                $('#createThisForm')[0].reset();
                $("#addBtn").val('Create');
            }

    });

    
</script>
@endsection