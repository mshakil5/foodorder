@extends('admin.layouts.admin')

@section('content')


  <!-- content area -->
  <div class="content">
      <div class="row ">
          <div class="col-lg-6" style="display:none">
              <div class="row my-2">
                
                  <div class="col-lg-12 mt-4">
                      <div class=" p-3 py-4 mt-2" style="background-color: #D9D9D9;">
                          <div>
                              <div class="txt-secondary fs-20 fw-bold  text-center fw-800">Withdraw request notification</div>  <br>
                              
                                <div class="ermsg"></div>
                              <div class="txt-secondary fs-14 my-2 fw-500"> 
                                
                                
                            </div> 
                              
                          </div> 
                      </div>
                  </div>
              </div>
             
          </div>
          <div class="col-lg-6" style="display:none">
              <div class="row mb-5">
                  <div class="col-lg-6">
                      <div class="user">
                          Latest transactions
                      </div>

                  </div>
                  <div class="col-lg-6 text-center">
                      <a href="#" class="btn-theme btn-transaction">View all transactions</a>
                  </div>
              </div>
              <div class="row titleBar my-3 ">
                  <div class="col-lg-6">Description</div>
                  <div class="col-lg-3">Amount</div>
                  <div class="col-lg-3">Balance</div>
              </div>

              <!-- loop start -->
              <div class="row mb-4">
                  <div class="date">
                      Today
                  </div>
                  <div class="row">
                      <div class="col-lg-6 mt-3">
                          <div class="info">Aim Habonim</div>
                          <span class="fs-16 txt-theme">Online donation</span>
                      </div>
                      <div class="col-lg-3 mt-3 d-flex align-items-center ">
                          <div class="info">-£18.00</div>
                      </div>
                      <div class="col-lg-3 mt-3 d-flex align-items-center ">
                          <span class="fs-16 txt-theme">£4.50</span>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-6 mt-3">
                          <div class="info">Initact Solutions Ltd.</div>
                          <span class="fs-16 txt-theme">Company donation</span>
                      </div>
                      <div class="col-lg-3 mt-3 d-flex align-items-center ">
                          <div class="info txt-primary">£20.00</div>
                      </div>
                      <div class="col-lg-3 mt-3 d-flex align-items-center ">
                          <span class="fs-16 txt-theme">£23.50</span>
                      </div>
                  </div>
              </div>

              <!-- end -->

              <!-- loop start -->

              <div class="row mb-4">
                  <div class="date">
                      21 January 23
                  </div>
                  <div class="row">
                      <div class="col-lg-6 mt-3">
                          <div class="info">Aim Habonim</div>
                          <span class="fs-16 txt-theme">Online donation</span>
                      </div>
                      <div class="col-lg-3 mt-3 d-flex align-items-center ">
                          <div class="info">-£18.00</div>
                      </div>
                      <div class="col-lg-3 mt-3 d-flex align-items-center ">
                          <span class="fs-16 txt-theme">£4.50</span>
                      </div>
                  </div> 
              </div>

              <!-- end -->
              <!-- loop start -->

              <div class="row mb-4">
                  <div class="date">
                      20 January 23
                  </div>
                  <div class="row">
                      <div class="col-lg-6 mt-2">
                          <div class="info">Bikur Cholim D’satamar</div>
                          <span class="fs-16 txt-theme">Online donation</span>
                      </div>
                      <div class="col-lg-3 mt-2 d-flex align-items-center ">
                          <div class="info">-£180.00</div>
                      </div>
                      <div class="col-lg-3 mt-2 d-flex align-items-center ">
                          <span class="fs-16 txt-theme">£203.50</span>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-6 mt-2">
                          <div class="info">Bikur Cholim D’satamar</div>
                          <span class="fs-16 txt-theme">Online donation</span>
                      </div>
                      <div class="col-lg-3 mt-2 d-flex align-items-center ">
                          <div class="info txt-primary">-£180.00</div>
                      </div>
                      <div class="col-lg-3 mt-2 d-flex align-items-center ">
                          <span class="fs-16 txt-theme">£203.50</span>
                      </div>
                  </div>
                  
              </div>

              <!-- end -->

          </div>

      </div>
  </div>

@endsection

@section('script')


<script>
    
</script>

@endsection
