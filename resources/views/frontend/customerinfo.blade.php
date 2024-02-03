<div class="row"> 
    <div class="col-md-12"> 
        <div class="panel panel-primary"> 
            <div class="panel-heading"> 
                <div class="row"> 
                    <div class="col-md-4">Your Details</div> 
                </div> 
            </div> 
            <div class="panel-body"> 
                

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

                <div class="ermsg"></div>
                <div class="row"> 
                    <div class="col-md-12 col-xs-12"> 
                        <div class="form-group"> 
                            <label for="name">Name</label> 
                            <input type="text" class="form-control" id="name" name="name" placeholder="John" value="@if (session('name') !== 'Null') {{session('name')}} @else {{ old('name') }} @endif"> 
                        </div> 
                        <div class="form-group"> 
                            <label for="uemail">Mail</label> 
                            <input type="text" class="form-control" id="uemail" name="email" placeholder="example@mail.com" value="@if (session('email') !== 'Null') {{session('email')}} @else {{ old('email') }} @endif" required> 
                        </div> 
                        <div class="form-group"> 
                            <label for="phone">Contact No</label> 
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="phone" value="@if (session('phone') !== 'Null') {{session('phone')}} @else {{ old('phone') }} @endif"> 
                        </div>

                        <div class="row" id="addressDiv">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>House Number</label>
                                <input type="text" class="form-control" id="house" name="house" value="@if (session('house') !== 'Null') {{session('house')}} @else {{ old('house') }} @endif">
                              </div>
                            </div>
        
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Street</label>
                                <input type="text" class="form-control" id="street" name="street" value="@if (session('street') !== 'Null') {{session('street')}} @else {{ old('street') }} @endif">
                              </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                  <label>City</label>
                                  <input type="text" class="form-control" id="city" name="city" value="@if (session('city') !== 'Null') {{session('city')}} @else {{ old('city') }} @endif">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Postcode</label>
                                  <input type="text" class="form-control" id="postcode" name="postcode" value="{{ old('postcode') }}">
                                </div>
                                <div class="perrmsg"></div>
                            </div>
                        </div>

                    </div> 
                </div> 
            </div> 
        </div> 
    </div> 
</div>