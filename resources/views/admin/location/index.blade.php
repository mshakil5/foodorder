@extends('admin.layouts.admin')

@section('content')

<!-- content area -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="pagetitle pb-2">
                Location
            </div>
        </div>
    </div>
<div id="addThisFormContainer">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: #fdf3ee">
                <div class="card-header">
                    <h5>Location create form</h5>
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
                                        <label>Post code</label>
                                        <input type="text" class="form-control" id="postcode" name="postcode">
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
                                <th style="text-align: center">Post Code</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $data)
                                    <tr>
                                        <td style="text-align: center">{{ $key + 1 }}</td>
                                        <td style="text-align: center">{{$data->postcode}}</td>
                                        <td style="text-align: center">
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
        var url = "{{URL::to('/admin/location')}}";
        var upurl = "{{URL::to('/admin/location-update')}}";
        // console.log(url);
        $("#addBtn").click(function(){
        //   alert("#addBtn");
            if($(this).val() == 'Create') {
                var form_data = new FormData();
                form_data.append("postcode", $("#postcode").val());
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
                          $(".ermsg").html(d.message);
                        window.setTimeout(function(){location.reload()},2000)
                      }
                  },
                  error: function (d) {
                      console.log(d);
                  }
              });
            }
            //create  end
            //Update
            if($(this).val() == 'Update'){
                var form_data = new FormData();
                form_data.append("postcode", $("#postcode").val());
                form_data.append("codeid", $("#codeid").val());
                
                $.ajax({
                    url:upurl,
                    type: "POST",
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    data:form_data,
                    success: function(d){
                        console.log(d);
                        if (d.status == 303) {
                            $(".ermsg").html(d.message);
                            pagetop();
                        }else if(d.status == 300){
                          $(".ermsg").html(d.message);
                            window.setTimeout(function(){location.reload()},2000)
                        }
                    },
                    error:function(d){
                        console.log(d);
                    }
                });
            }
            //Update
        });
        //Edit
        $("#contentContainer").on('click','#EditBtn', function(){
            //alert("btn work");
            codeid = $(this).attr('rid');
            //console.log($codeid);
            info_url = url + '/'+codeid+'/edit';
            //console.log($info_url);
            $.get(info_url,{},function(d){
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
            $("#postcode").val(data.postcode);
            $("#codeid").val(data.id);
            $("#addBtn").val('Update');
            $("#addBtn").html('Update');
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