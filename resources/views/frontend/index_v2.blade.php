@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <!-- Loader -->
    <div id="loading" class="fixed inset-0 flex justify-center items-center bg-white opacity-70 z-50 hidden">
        <img src="{{ asset('loader.gif') }}" id="loading-image" alt="Loading..." class="h-56" />
    </div>

    @php
        $minimum_sale = 10;
        $delivery_charge = 2;
    @endphp

    <div class="row">
        <!-- Category Sidebar -->
        <div class="col-md-2 col-xs-12">
            <ul class="list-group" id="get_category">
                @foreach (\App\Models\Category::orderBy('id', 'ASC')->get() as $cat)
                    <li class="mb-1">
                        <button value="{{ $cat->id }}" class="list-group-item category getsrchval">{{ $cat->name }}</button>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Product Listing -->
        <div class="col-md-5 col-xs-12">
            <div class="row" id="get_product" style="padding: 15px">
                @foreach ($products as $product)
                    <div class="col-md-12 box-custom mb-4 rounded-3">
                        <div class="row">
                            <div class="col-md-8 col-xs-12">
                                <h4 class="fw-bold text-primary mb-0">{{ $product->product_name }}</h4>
                                <p>{{ $product->description }}</p>
                            </div>
                            <div class="col-md-2 col-xs-6">£{{ number_format($product->price, 2) }}</div>
                            <div class="col-md-2 col-xs-6">
                                <button class="btn btn-primary text-uppercase btn-sm btn-modal" data-bs-toggle="modal" data-bs-target="#additemModal"
                                    pid="{{ $product->id }}"
                                    pname="{{ $product->product_name }}"
                                    pdesc="{{ $product->description }}"
                                    price="{{ number_format($product->price, 2) }}">
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Cart Checkout -->
        <div class="col-md-5 col-xs-12">
            <div id="cart_checkout" class="mt-3">
                <form action="{{ route('paypalpayment') }}" method="POST">
                    @csrf

                    <!-- Error and Success Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    <!-- Cart Table -->
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">Cart Checkout</div>
                                <div class="col-md-8" id="cart_msg"></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody id="cardinner">
                                    @if (session('cart'))
                                        @foreach (session('cart') as $id => $items)
                                            @foreach ($items as $item)
                                                {!! $item !!}
                                            @endforeach
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot id="cardfooter" style="display: none;">
                                    <tr>
                                        <th style="padding:0 15px; text-align: left; border:0" colspan="4">Subtotal:</th>
                                        <th style="padding:0; text-align: center; border:0">
                                            <div class="grand_total_amount" id="grand_total_amount"></div>
                                            <input type="hidden" name="grand_total_value" id="grand_total_value">
                                        </th>
                                    </tr>
                                    <tr id="dis_div" style="display: none;">
                                        <th style="padding:0 15px; text-align: left; border:0" colspan="4">Discount:</th>
                                        <th style="padding:0; text-align: center; border:0">
                                            <div class="discount_div" id="discount_div">0.00</div>
                                            <input type="hidden" name="discount_percent" id="discount_percent" value="0">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="padding:0 15px; text-align: left; border:0" colspan="4">Total:</th>
                                        <th style="padding:0; text-align: center; border:0">
                                            <div class="net_total_amount" id="net_total_amount"></div>
                                            <input type="hidden" name="discount_amount" id="discount_amount" value="0">
                                            <input type="hidden" name="net_total_value" id="net_total_value">
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- Coupon Input -->
                            <div class="row">
                                <div class="col-md-8 col-xs-12 mx-auto">
                                    <div class="form-group">
                                        <label for="coupon">Use Your Coupon</label>
                                        <input type="text" class="form-control" id="coupon" name="coupon">
                                    </div>
                                    <div class="couponerrmsg text-danger"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Collection Options -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4">Collection Option</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-xs-6">
                                    <div class="form-check">
                                        <input type="radio" name="collection" value="Collection" class="form-check-input rmvDiv" id="clnChkNo" onclick="ShowHideDivforCln()" {{ old('collection', 'Collection') === 'Collection' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="clnChkNo">Collection</label>
                                        <p class="mb-0">Within 20 Minutes</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="form-check">
                                        <input type="radio" name="collection" value="Delivery" class="form-check-input" id="clnChkYes" onclick="ShowHideDivforCln()" {{ old('collection') === 'Delivery' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="clnChkYes">Delivery</label>
                                        <p class="mb-0">Within 60 Minutes</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <label for="date">Collection/Delivery Date</label>
                                    <input type="text" class="form-control date-picker" name="date" id="date" value="{{ date('Y-m-d') }}" placeholder="Select date" required>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <label for="timeslot">Collection/Delivery Time</label>
                                    <select id="timeslot" class="form-control" name="timeslot" required>
                                        <option value="">Select Time</option>
                                        @foreach (\App\Models\TimeSlot::all() as $time)
                                            @if (now()->format('H:i:s') < $time->start_time)
                                                <option value="{{ date('h:i A', strtotime($time->start_time)) }} - {{ date('h:i A', strtotime($time->end_time)) }}">
                                                    {{ date('h:i A', strtotime($time->start_time)) }} - {{ date('h:i A', strtotime($time->end_time)) }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    @include('frontend.customerinfo')

                    <!-- Payment Options -->
                    <div class="card mt-3" id="submitDiv">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4">Payment Option</div>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <div class="row">
                                <div class="col-md-7 col-xs-12 mb-2">
                                    <button type="submit" class="btn btn-primary w-100">Pay with Card or PayPal</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-12 mx-auto">
                                    <input type="button" id="orderCreateBtn" name="orderCreateBtn" class="btn btn-primary w-100" value="Pay with Cash">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('frontend.modal')


@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/cart.css') }}">
@endsection

@section('script')
    {{-- <script src="{{ asset('frontend/js/cart.js') }}"></script> --}}


<script>


$(document).ready(function () {
    // CSRF Token Setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize net total calculation
    calculateNetTotal();

    // Show/Hide address div based on collection type
    $('input[name="collection"]').on('click', function () {
        const val = $(this).val();
        $('#addressDiv').toggle(val === 'Delivery');
    });

    // Category-wise product fetch
    $(document).on('click', '.getsrchval', function () {
        const categoryId = $(this).val();
        fetchProductsByCategory(categoryId);
    });

    // Open product modal
    $(document).on('click', '.btn-modal', function () {
        const product = {
            id: $(this).attr('pid'),
            name: $(this).attr('pname'),
            description: $(this).attr('pdesc'),
            price: $(this).attr('price')
        };
        populateProductModal(product);
        fetchAdditionalItems(product.id);
    });

    // Quantity increment/decrement
    $('.add').on('click', function () {
        updateQuantity(1);
    });

    $('.minus').on('click', function () {
        updateQuantity(-1);
    });

    // Add to cart
    $(document).on('click', '#addToCard', function () {
        addToCart($(this));
    });

    // Remove cart item
    $(document).on('click', '.remove-cart-item', function (event) {
        removeCartItem(event);
    });

    // Update cart on quantity change
    $(document).on('keyup click', '.parent_product_qty', function (event) {
        updateCartItemQuantity($(this));
    });

    // Submit order
    $(document).on('click', '#orderCreateBtn', function (event) {
        submitOrder(event);
    });

    // Check postcode
    $('#postcode').on('keyup', function () {
        if ($(this).val().length > 2 && $('input[name="collection"]:checked').val() === 'Delivery') {
            checkPostcode($(this).val());
        } else {
            $('.perrmsg').html('');
            $('#submitDiv').show();
        }
    });

    // Check coupon code
    $('#coupon').on('keyup', function () {
        if ($(this).val().length > 2) {
            checkCoupon($(this).val());
        } else {
            $('.couponerrmsg').html('');
            $('#discount_percent').val(0);
            $('#discount_amount').val(0);
            $('#discount_div').html('0.00');
            calculateNetTotal();
        }
    });
});

// Fetch products by category
function fetchProductsByCategory(categoryId) {
    $.ajax({
        url: '{{ URL::to("/getcatproduct") }}',
        method: 'POST',
        data: { id: categoryId },
        success: function (data) {
            $('#get_product').html(data.product);
        },
        error: function (error) {
            console.error('Error fetching products:', error);
        }
    });
}

// Populate product modal
function populateProductModal(product) {
    const modal = $('#additemModal');
    modal.find('.modal-body #brdDiv').html(`
        <div class="title-section">
            <div class="mx-2">Choose Bread</div>
            <input type="hidden" id="addebreaditems" data-itemid="0" name="additionalitm" data-count="0" value="" data-itemname="" class="extraaitem">
        </div>
    `);
    modal.find('.modal-body #productname').val(product.name);
    modal.find('.modal-body #productid').val(product.id);
    modal.find('.modal-body #pdesc').val(product.description);
    $('#pnameshow').html(product.name);
    $('#descShow').html(product.description);
    $('#priceShow').html(`£${product.price}`);
    $('#pShow').html(`£${product.price}`);
    $('#unitprice').val(product.price);
    $('#tamount').val(product.price);
    $('#parent_item_uprice').val(product.price);
    modal.find('.modal-body #price').val(product.price);
    $('.orderBtn').attr({
        'net_amount': product.price,
        'price': product.price,
        'pid': product.id,
        'pname': product.name,
        'pqty': 1
    });
}

// Fetch additional items for product
function fetchAdditionalItems(productId) {
    $.ajax({
        url: '{{ URL::to("/get-additional-product") }}',
        method: 'POST',
        data: { productid: productId },
        success: function (data) {
            if (data.status === 300) {
                resetModalFields();
                renderAdditionalItems(data.items);
            }
        },
        error: function (error) {
            console.error('Error fetching additional items:', error);
        }
    });
}

// Reset modal fields
function resetModalFields() {
    $('#qty').val('1');
    $('#additemtunitamnt').val('0');
    $('#additemtamnt').val('0');
    $('.breads, .cheese, .chutney, .toppings, .extoppings, .addons').hide();
}

// Render additional items in modal
function renderAdditionalItems(items) {
    const sections = {
        1: { selector: '.toppingsitem tbody', class: 'toppings', template: (item) => toppingTemplate(item) },
        2: { selector: '.extoppingsitem tbody', class: 'extoppings', template: (item) => toppingTemplate(item) },
        3: { selector: '.chutneyitem tbody', class: 'chutney', template: (item) => checkboxTemplate(item, 'chutneysingleitem', 'addechutneyitems') },
        4: { selector: '.cheeseitem tbody', class: 'cheese', template: (item) => checkboxTemplate(item, 'cheesesingleitem', 'addecheeseitems') },
        5: { selector: '.breadsitem tbody', class: 'breads', template: (item) => radioTemplate(item) },
        6: { selector: '.addonsitem tbody', class: 'addons', template: (item) => toppingTemplate(item) }
    };

    $.each(items, function (_, item) {
        const section = sections[item.additional_item_title_id];
        if (section) {
            $(section.selector).append(section.template(item));
            $(`.${section.class}`).show(100);
        }
    });
}

// Template for toppings/addons
function toppingTemplate(item) {
    return `
        <tr>
            <td class="additemval" value="${item.additional_item_id}" price="${item.price}" style="width: 10%; text-align:center">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16" style="height:22px">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                <input type="hidden" id="addetoppings${item.additional_item_id}" data-itemid="" name="additionalitm" data-itemname="${item.item_name}" data-count="" value="${item.price}" class="extraaitem">
            </td>
            <td style="width: 70%">${item.item_name}<span class="badge badge-success pl-2" id="output${item.additional_item_id}"></span></td>
            <td style="width: 20%; text-align:right">${item.price > 0 ? `£${item.price.toFixed(2)}` : ''}</td>
            <td class="minusitemval" value="${item.additional_item_id}" id="minusadditem${item.additional_item_id}" price="${item.price}" style="width: 10%; text-align:center; display:none">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                </svg>
            </td>
        </tr>
    `;
}

// Template for checkboxes
function checkboxTemplate(item, className, inputIdPrefix) {
    return `
        <tr>
            <td style="width: 10%; text-align:center">
                <input type="checkbox" class="largerCheckbox ${className}" name="${className.replace('singleitem', '')}" value="${item.additional_item_id}" price="${item.price}">
                <input type="hidden" id="${inputIdPrefix}${item.additional_item_id}" data-itemid="" name="additionalitm" data-count="" value="${item.price}" data-itemname="${item.item_name}" class="extraaitem">
            </td>
            <td style="width: 70%">${item.item_name}</td>
            <td style="width: 20%; text-align:right">${item.price > 0 ? `£${item.price.toFixed(2)}` : ''}</td>
        </tr>
    `;
}

// Template for radio buttons
function radioTemplate(item) {
    return `
        <tr>
            <td style="width: 10%; text-align:center">
                <input type="checkbox" class="largerRadiobox breadsingleitem" id="breads${item.additional_item_id}" name="breads" breadname="${item.item_name}" value="${item.additional_item_id}" price="${item.price}">
                <input type="hidden" id="addbreadsitems${item.additional_item_id}" data-itemid="" name="additionalitm" data-count="" value="${item.price}" data-itemname="${item.item_name}" class="extraaitembread">
            </td>
            <td style="width: 70%">${item.item_name}</td>
            <td style="width: 20%; text-align:right">${item.price > 0 ? `£${item.price.toFixed(2)}` : ''}</td>
        </tr>
    `;
}

// Update quantity in modal
function updateQuantity(change) {
    let currentVal = parseInt($('#qty').val()) || 0;
    if (currentVal + change < 1) return;
    const unitPrice = parseFloat($('#unitprice').val());
    const addItemTotal = parseFloat($('#additemtamnt').val()) || 0;
    currentVal += change;
    const netAmount = (currentVal * unitPrice + addItemTotal).toFixed(2);
    $('#qty').val(currentVal);
    $('#pShow').html(`£${netAmount}`);
    $('#tamount').val(netAmount);
    $('.orderBtn').attr({ 'net_amount': netAmount, 'pqty': currentVal });
}

// Add item to cart
function addToCart(button) {
    const extraItems = [];
    $('.extraaitem').each(function () {
        const count = $(this).data('count');
        if (count > 0) {
            extraItems.push({
                itemname: $(this).data('itemname'),
                count: count,
                price: $(this).val(),
                id: $(this).data('itemid')
            });
        }
    });

    const product = {
        qty: button.attr('pqty'),
        id: button.attr('pid'),
        price: button.attr('price'),
        name: button.attr('pname'),
        childTotal: parseFloat($('#additemtamnt').val()) || 0
    };
    const netAmount = (product.price * product.qty + product.childTotal).toFixed(2);

    // Check if product exists in cart
    const existingIds = $('input[name="parent_product_id[]"]').map(function () { return $(this).val(); }).get();
    if (existingIds.includes(product.id)) {
        updateExistingCartItem(product, extraItems, netAmount);
    } else {
        addNewCartItem(product, extraItems, netAmount);
    }

    // Save to session
    saveCartToSession();
    resetModalFields();
    $('#additemModal').modal('hide');
}

// Update existing cart item
function updateExistingCartItem(product, extraItems, netAmount) {
    const qtyField = $(`#parent_product_qty${product.id}`);
    const totalPriceField = $(`#parent_product_total_price${product.id}`);
    const totalPriceDiv = $(`#parent_product_total_price_div${product.id}`);
    const childItemsDiv = $(`#childitems${product.id}`);

    const newQty = parseFloat(qtyField.val()) + parseFloat(product.qty);
    const newTotalPrice = (parseFloat(totalPriceField.val()) + parseFloat(netAmount)).toFixed(2);

    qtyField.val(newQty);
    totalPriceField.val(newTotalPrice);
    totalPriceDiv.html(newTotalPrice);

    $.each(extraItems, function (_, item) {
        const childQtyField = $(`#child_product_qty${product.id}${item.id}`);
        if (childQtyField.length) {
            const newChildQty = parseFloat(childQtyField.val()) + parseFloat(item.count);
            $(`#child_product_total_qty_div${product.id}${item.id}`).html(newChildQty);
            $(`#child_product_total_price${product.id}${item.id}`).val((newChildQty * (item.price / item.count)).toFixed(2));
        } else {
            childItemsDiv.append(childItemTemplate(product.id, item));
        }
    });

    calculateNetTotal();
}

// Add new cart item
function addNewCartItem(product, extraItems, netAmount) {
    const markup = `
        <tr>
            <td style="text-align: center; border:0">
                <div class="remove-cart-item" style="color: white; user-select:none; padding: 5px; background: red; width: 35px; display: flex; align-items: center; margin-right:5px; justify-content: center; border-radius: 4px; cursor: pointer;">X</div>
            </td>
            <td style="text-align: left; border:0; width:60%" colspan="2">
                ${product.name}
                <input type="hidden" name="parent_product_name[]" value="${product.name}">
                <input type="hidden" id="parent_product_id${product.id}" name="parent_product_id[]" value="${product.id}">
                <div class="childitems${product.id}" id="childitems${product.id}"></div>
            </td>
            <td style="text-align: center; border:0">
                <input type="number" id="parent_product_qty${product.id}" name="parent_product_qty[]" min="1" value="${product.qty}" class="form-control parent_product_qty">
            </td>
            <td style="text-align: center; border:0">
                <div id="parent_product_total_price_div${product.id}" class="parent_product_total_price_div">${netAmount}</div>
                <input type="hidden" id="parent_product_price${product.id}" name="parent_product_price[]" value="${product.price}" class="form-control parent_product_price" readonly>
                <input type="hidden" id="parent_product_total_price${product.id}" name="parent_product_total_price[]" value="${netAmount}" class="form-control net_amount_with_child_item" readonly>
                <input type="hidden" id="child_items_total_amnt${product.id}" name="child_items_total_amnt[]" value="${product.childTotal}" class="form-control child_items_total_amnt" readonly>
            </td>
        </tr>
    `;
    $('#cardinner').append(markup);

    const childItemsDiv = $(`#childitems${product.id}`);
    $.each(extraItems, function (_, item) {
        childItemsDiv.append(childItemTemplate(product.id, item));
    });

    calculateNetTotal();
}

// Child item template
function childItemTemplate(parentId, item) {
    return `
        <div>
            <input type="hidden" name="related_parent_id[]" value="${parentId}">
            <input type="hidden" id="child_product_id${parentId}${item.id}" name="child_product_id[]" value="${item.id}">
            <input type="hidden" id="child_product_qty${parentId}${item.id}" name="child_product_qty[]" value="${item.count}">
            <input type="hidden" name="child_product_name[]" value="${item.itemname}">
            <input type="hidden" id="child_product_total_price${parentId}${item.id}" name="child_product_total_price[]" value="${item.price}">
            ${item.itemname}: <span>Price:${(item.price / item.count).toFixed(2)}</span> X <span id="child_product_total_qty_div${parentId}${item.id}">Qty:${item.count}</span>
        </div>
    `;
}

// Save cart to session
function saveCartToSession() {
    const sessionData = $('#cardinner').html();
    $.ajax({
        url: '{{ URL::to("/add-to-session-card-item") }}',
        method: 'POST',
        data: { sessionData },
        success: function (data) {
            if (data.status === 300) {
                console.log('Cart saved to session');
            }
        },
        error: function (error) {
            console.error('Error saving cart to session:', error);
        }
    });
}

// Remove cart item
function removeCartItem(event) {
    const row = $(event.target).closest('tr');
    row.remove();
    calculateNetTotal();
    $.ajax({
        url: '{{ URL::to("/clear-session-data") }}',
        method: 'POST',
        data: { data: $('#cardinner').html() },
        success: function () {
            setTimeout(() => location.reload(), 200);
        },
        error: function (error) {
            console.error('Error clearing session:', error);
        }
    });
}

// Update cart item quantity
function updateCartItemQuantity(input) {
    const row = input.closest('tr');
    let quantity = parseFloat(input.val()) || 1;
    if (quantity < 1) quantity = 1;
    const price = parseFloat(row.find('.parent_product_price').val());
    const childTotal = parseFloat(row.find('.child_items_total_amnt').val());
    const newTotal = (price * quantity + childTotal).toFixed(2);
    row.find('.net_amount_with_child_item').val(newTotal);
    row.find('.parent_product_total_price_div').html(newTotal);
    calculateNetTotal();
}

// Calculate net total
function calculateNetTotal() {
    const discountPercent = parseFloat($('#discount_percent').val()) || 0;
    let totalAmount = 0;
    $('.net_amount_with_child_item').each(function () {
        totalAmount += parseFloat($(this).val()) || 0;
    });
    totalAmount = totalAmount.toFixed(2);
    let netAmount = totalAmount;
    let discountAmount = 0;

    if (discountPercent > 0) {
        discountAmount = (totalAmount * discountPercent / 100).toFixed(2);
        netAmount = (totalAmount - discountAmount).toFixed(2);
        $('#dis_div').show();
    } else {
        $('#dis_div').hide();
    }

    $('#grand_total_value').val(totalAmount);
    $('#grand_total_amount').html(totalAmount);
    $('#discount_amount').val(discountAmount);
    $('#discount_div').html(discountAmount);
    $('#net_total_value').val(netAmount);
    $('#net_total_amount').html(netAmount);
    $('#cardfooter').toggle(totalAmount > 0);
}

// Submit order
function submitOrder(event) {
    event.preventDefault();
    $('#loading').show();
    const orderData = {
        collection_date: $('#date').val(),
        collection_time: $('#timeslot').val(),
        name: $('#name').val(),
        email: $('#uemail').val(),
        phone: $('#phone').val(),
        house: $('#house').val(),
        street: $('#street').val(),
        city: $('#city').val(),
        postcode: $('#postcode').val(),
        note: $('#note').val(),
        discount_amount: $('#discount_amount').val(),
        discount_percent: $('#discount_percent').val(),
        delivery_type: $('input[name="collection"]:checked').val(),
        payment_type: $('input[name="payment"]:checked').val() || 'Cash',
        parent_product_name: $('input[name="parent_product_name[]"]').map(function () { return $(this).val(); }).get(),
        parent_product_id: $('input[name="parent_product_id[]"]').map(function () { return $(this).val(); }).get(),
        parent_product_qty: $('input[name="parent_product_qty[]"]').map(function () { return $(this).val(); }).get(),
        parent_product_price: $('input[name="parent_product_price[]"]').map(function () { return $(this).val(); }).get(),
        parent_product_total_price: $('input[name="parent_product_total_price[]"]').map(function () { return $(this).val(); }).get(),
        related_parent_id: $('input[name="related_parent_id[]"]').map(function () { return $(this).val(); }).get(),
        child_product_id: $('input[name="child_product_id[]"]').map(function () { return $(this).val(); }).get(),
        child_product_qty: $('input[name="child_product_qty[]"]').map(function () { return $(this).val(); }).get(),
        child_product_name: $('input[name="child_product_name[]"]').map(function () { return $(this).val(); }).get(),
        child_product_total_price: $('input[name="child_product_total_price[]"]').map(function () { return $(this).val(); }).get()
    };

    const url = orderData.payment_type === 'Paypal' ? '{{ URL::to("/payment") }}' : '{{ URL::to("/order-store") }}';
    $.ajax({
        url: url,
        method: 'POST',
        data: orderData,
        success: function (data) {
            $('#loading').hide();
            $('.ermsg').html(data.message);
            if (data.status === 300) {
                window.open(`https://click.shambleskorner.co.uk/order-confirmation/${data.id}`);
            }
        },
        error: function (error) {
            $('#loading').hide();
            console.error('Error submitting order:', error);
        }
    });
}

// Check postcode
function checkPostcode(postcode) {
    $.ajax({
        url: '{{ URL::to("/check-post-code") }}',
        method: 'POST',
        data: { postcode },
        success: function (data) {
            $('.perrmsg').html(data.message);
            $('#submitDiv').toggle(data.status === 300);
        },
        error: function (error) {
            console.error('Error checking postcode:', error);
        }
    });
}

// Check coupon
function checkCoupon(coupon) {
    $.ajax({
        url: '{{ URL::to("/check-coupon-code") }}',
        method: 'POST',
        data: { coupon },
        success: function (data) {
            $('.couponerrmsg').html(data.message);
            if (data.status === 300) {
                $('#discount_percent').val(data.percentage);
            } else {
                $('#discount_percent').val(0);
                $('#discount_amount').val(0);
                $('#discount_div').html('0.00');
            }
            calculateNetTotal();
        },
        error: function (error) {
            console.error('Error checking coupon:', error);
        }
    });
}


</script>

@endsection