<!----------------------------additemModal ------------------------->
<div class="modal fade" id="additemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  
    <div class="modal-dialog modal-dialog-scrollable ">
        <div class="modal-content">
            <div class="modal-header alert modal-header" style="text-align: left;">
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
                                {{-- <input type='hidden' id='addebreaditems' data-itemid='0' name='additionalitm' data-count='0' value='' data-itemname='' class='extraaitem'>  --}}
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-dash minus" viewBox="0 0 16 16">
                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                            </svg>
                        </button>


                        
                        {{-- <input type="button" value="+" id="add1" class="add" /> --}}
                        <input type="hidden" id="productid" value="" class="productid" />
                        <input type="hidden" id="qty" value="1" min="1" class="qty" />
                        <input type="hidden" id="tamount" value=""  class="tamount" />
                        <input type="hidden" id="parent_item_uprice" value=""  class="parent_item_uprice" />
                        <input type="hidden" id="additemtamnt" value="0"  class="additemtamnt" />
                        <input type="hidden" id="additemtunitamnt" value=""  class="additemtunitamnt" />
                        {{-- <input type="button" value="-" id="minus1" class="minus" /> --}}
        
                          <b> <span style="font-size: 22px;" id="pShow"></span>   </b>
                          <input type="hidden" id="unitprice" name="unitprice" value="">
        
                    
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus add" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg> 
                        </button>
        
                    </div><br>

                    <div class="row text-left tValues">
                        <div class="col-sm-12">
                            <div class="row">
                                
                                <button type="submit" id="addToCard" pqty="" pid="" child_item_total="" net_amount="" price="" pname="" additionalitem="[]" class="btn btn-primary text-uppercase btn-lg btn-block orderBtn">
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