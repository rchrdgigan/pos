@extends('layouts.user')
@section('breadcrumbs')
Home
@endsection

@push('links')
<link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\css\select2.css')}}">
@endpush

@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5>Product Info</h5>
                                <span>Data about product.</span>
                            </div>
                        </div>
                    </div>
                    <form id="product-form">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="product-select">Product</label>
                                <select class="form-control js-single" id="product-select" name="product" required="" aria-label="Default select example">
                                    <option selected value="" disabled>--- Select Product ---</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-product="{{$product->product_name}}" data-price="{{$product->product_cost ?? 0}}"  data-qty="{{$product->qty}}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="selected-product">
                                <div class="d-flex align-items-center mt-2">
                                    <div class="col-6">
                                        <label for="product-select">Product Price </label>
                                        <input type="text" class="form-control col-12" readonly  id="selected-price">
                                    </div>
                                    <div class="col-6">
                                        <label for="product-select">Product Stock </label>
                                        <input type="text" class="form-control" readonly  id="selected-qty">
                                    </div>
                                </div>
                               
                            </div>
                            <div class="form-group">
                                <label for="add_disc">Discount %</label>
                                <input type="number" class="form-control" min="0" max="99" name="discount" id="product-discount" required="" placeholder="Enter Discount">
                            </div>
                            <div class="form-group">
                                <label for="add_qua">Quantity</label>
                                <input type="number" class="form-control" min="0" name="quantity" id="product-qty" required="" onchange="qtyValidation()" placeholder="Enter Quantity">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Add Item</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                 <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5>Product Transaction List</h5>
                                <span>Data about ordered.</span>
                            </div>
                        </div>
                    </div>
                   
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="product-table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Discount %</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Sub Amount</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <a href="{{route('user.home')}}" class="btn btn-md btn-secondary rounded">Cancel</a>
                            <a type="button" data-toggle="modal" data-target="#modal-cout" class="btn btn-md btn-primary text-white rounded">Check Out</a>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</div>
<div class="modal fade" id="modal-cout" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <label for="t_amount">Total Amount</label>
                    <input type="text" class="form-control" name="t_amount" id="t_amount" required="" placeholder="Auto Generate Total Amount" readonly>
                </div>
                <div class="form-group">
                    <label for="cash">Cash</label>
                    <input type="text" class="form-control" onchange="changedAmount()" name="cash" id="cash" required="" placeholder="Enter Cash">
                </div>
                <div class="form-group">
                    <label for="changed">Changed</label>
                    <input type="text" class="form-control" name="changed" id="changed" required="" placeholder="Auto Generate Changed" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light " onclick="getProductData()">Confirmed</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{asset('vendor\assets\js\select2.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.js-single').select2();
    });
    
    $(document).ready(function() {
        $('#table').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'excelHtml5',
                    title: 'Data Export',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
            columnDefs: [ {
                targets: -1,
            } ]
        } );
    } );

    $('#modal-del').on('show.bs.modal', function (e) {
        var opener=e.relatedTarget;
        var id=$(opener).attr('id');
        $('#del_frm').find('[name="id"]').val(id);
    });
</script>
<!-- data-table js -->
<script src="{{asset('vendor\bower_components\datatables.net\js\jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendor\bower_components\datatables.net-buttons\js\buttons.print.min.js')}}"></script>
<script src="{{asset('vendor\bower_components\datatables.net-buttons\js\buttons.html5.min.js')}}"></script>
<script src="{{asset('vendor\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendor\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendor\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js')}}"></script>
<!-- Add this script to your HTML file after including jQuery -->
<script>

    $(document).ready(function () {
        $('#product-select').on('change', function () {
            var selectedOption = $(this).find(':selected');
            var selectedProduct = selectedOption.data('product');
            var selectedPrice = selectedOption.data('price');
            var selectedQty = selectedOption.data('qty');
            console.log("Selected Product: " + selectedProduct);
            console.log("Selected Price: " + selectedPrice);
            console.log("Selected Qty: " + selectedQty);
            $("#selected-product").val(selectedProduct);
            $("#selected-price").val(selectedPrice);
            $("#selected-qty").val(selectedQty);

            var currentqty = $("#selected-qty").val();
            if (currentqty == 0) {
                document.getElementById("product-qty").disabled = true;
                document.getElementById("product-discount").disabled = true;
            }else{
                document.getElementById("product-qty").disabled = false;
                document.getElementById("product-discount").disabled = false;
            }
        });

        function addProduct() {

            var product_id = $("#product-select").val();
            var product_name = $("#selected-product").val();
            var product_discount = $("#product-discount").val();
            var price = $("#selected-price").val();
            var qty = $("#product-qty").val();
            var currentqty = $("#selected-qty").val();

            if (qty == 0) {
                alertify.set('notifier', 'position', 'top-right');
                alertify.error('<i class="feather icon-info"></i> Opps! No stock to be transact!');
                $("#product-qty").val("");
                $("#product-discount").val("");
            } else if (!product_name || !qty || !price || !product_discount) {
                alert("Please fill in all fields before adding a product.");
                return;
            } else {
                var crstock = parseFloat(currentqty) || 0;
                if (qty > crstock) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.error('<i class="feather icon-info"></i> Opps! Quantity must be less than or equal to the ' + crstock + ' stock qty.');
                    $("#product-qty").val("");
                } else {
                    // Disable the selected product option
                    $("#product-select option[value='" + product_id + "']").prop('disabled', true);

                    var temp_totalAmount = qty * price;
                    var temp_discount = product_discount / 100;
                    var total_discount = temp_discount * temp_totalAmount;
                    var totalAmount = temp_totalAmount - total_discount;

                    var newRow = $("<tr>");
                    newRow.append("<td hidden>" + product_id + "</td>");
                    newRow.append("<td>" + product_name + "</td>");
                    newRow.append("<td>" + product_discount + "</td>");
                    newRow.append("<td>" + qty + "</td>");
                    newRow.append("<td>" + price + "</td>");
                    newRow.append("<td>" + temp_totalAmount + "</td>");
                    newRow.append("<td>" + totalAmount + "</td>");

                    var removeButton = $('<td><a class="btn-sm btn-danger text-white waves-effect"><i class="feather icon-trash-2"></i></a></td></tr>');
                    removeButton.click(function () {
                        removeProduct(newRow);

                        // Enable the product option in the dropdown
                        $("#product-select option[value='" + product_id + "']").prop('disabled', false);

                        var totalSum = 0;
                        $("#product-table tbody tr").each(function () {
                            var rowTotal = parseFloat($(this).find("td:nth-child(7)").text());
                            if (!isNaN(rowTotal)) {
                                totalSum += rowTotal;
                            }
                        });
                        $("#t_amount").val(totalSum);
                    });
                    newRow.append(removeButton);

                    $("#product-table tbody").append(newRow);

                    $("#product-form")[0].reset();

                    var totalSum = 0;
                    $("#product-table tbody tr").each(function () {
                        var rowTotal = parseFloat($(this).find("td:nth-child(7)").text());
                        if (!isNaN(rowTotal)) {
                            totalSum += rowTotal;
                        }
                    });
                    $("#t_amount").val(totalSum);
                }
            }
        }

        function removeProduct(button) {
            $(button).closest("tr").remove();
        }

        $("#product-form").submit(function (event) {
            event.preventDefault();
            addProduct();
        });

    });

    function qtyValidation(){
        var current_stock = $("#selected-qty").val();
        var qty = $("#product-qty").val();
        var crstock = parseFloat(current_stock) || 0;
        if (qty > crstock) {
            alertify.set('notifier','position', 'top-right');
            alertify.error('<i class="feather icon-info"></i> Opps! Quantity must be less than or equal to the '+ crstock +' stock qty.');
            $("#product-qty").val("");
        }
    }

    function changedAmount() {
        var totalAmount = parseFloat($("#t_amount").val()) || 0;
        var cash = parseFloat($("#cash").val()) || 0;

        var changedAmount = cash - totalAmount;

        $("#changed").val(changedAmount);

        if (cash < totalAmount) {
            alertify.set('notifier','position', 'top-right');
            alertify.error('<i class="feather icon-info"></i> Opps! Cash must be greater than or equal to the total amount.');
            $("#cash").val("");
            $("#changed").val("");
        }
    }

    function getProductData() {

        var totalAmount = parseFloat($("#t_amount").val()) || 0;
        var cash = parseFloat($("#cash").val()) || 0;

        var changedAmount = cash - totalAmount;

        $("#changed").val(changedAmount);

        if (cash < totalAmount) {
            alertify.set('notifier','position', 'top-right');
            alertify.error('<i class="feather icon-info"></i> Opps! Cash must be greater than or equal to the total amount.');
            $("#cash").val("");
            $("#changed").val("");
        }

        var productData = [];
       
        $("#product-table tbody tr").each(function () {
            var product = $(this).find("td:nth-child(1)").text();
            var discount = $(this).find("td:nth-child(3)").text();
            var qty = $(this).find("td:nth-child(4)").text();
            var price = $(this).find("td:nth-child(5)").text();
            var subAmount = $(this).find("td:nth-child(6)").text();
            var totalAmount = $(this).find("td:nth-child(7)").text();

            productData.push({
                product: product,
                discount: discount,
                qty: qty,
                price: price,
                subAmount: subAmount,
                totalAmount: totalAmount
            });
        });

        if (productData.length === 0) {
            alertify.set('notifier','position', 'top-right');
            alertify.error('<i class="feather icon-info"></i> Opps Something Wrong! No product data to be transact.');
            return;
        }

        var dataToSend = {
            totalAmount: totalAmount,
            cash: cash,
            changedAmount: changedAmount,
            productData: productData
        }

        var jsonData = JSON.stringify(dataToSend);

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            type: "POST",
            url: "/user/sale/store",
            data: jsonData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            contentType: "application/json",
            success: function (response) {
                console.log("Data sent successfully:", response);

                if (response.transid) {
                    window.location.href = "/user/sale/print/?transid=" + response.transid;
                }
            },
            error: function (error) {
                console.error("Error sending data:", error);
            }
        });
    }

    $("#send-data-button").click(function () {
        getProductData();
    });
</script>
@endpush
