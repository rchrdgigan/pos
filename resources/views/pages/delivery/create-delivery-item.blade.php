@extends('layouts.main')

@section('breadcrumbs')
Create Delivery List
@endsection

@push('links')
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\css\buttons.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css')}}">
@endpush

@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <form id="product-form">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="product-select">Product</label>
                                <select class="form-control" id="product-select" name="product" required="" aria-label="Default select example">
                                    <option selected value="" disabled>--- Select Product ---</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-product="{{$product->product_name}}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="selected-product">
                            </div>
                            <div class="form-group">
                                <label for="product-qty">Qty</label>
                                <input type="text" class="form-control" name="qty" id="product-qty" required="" placeholder="Enter Quantity">
                            </div>
                            <div class="form-group">
                                <label for="product-price">Price</label>
                                <input type="text" class="form-control" name="price" id="product-price" required="" placeholder="Enter Price">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-md btn-secondary rounded" href="{{route('admin.deliver')}}">Back</a>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                 <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5>Create Transaction Delivery List</h5>
                                <span>Data about items.</span>
                            </div>
                        </div>
                    </div>
                   
                    <div class="card-block">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="sup_id">Supplier Name</label>
                                    <select class="form-control" id="sup_id" name="sup_id" aria-label="Default select example" required>
                                        <option selected value="" disabled>--- Select Supplier ---</option>
                                        @foreach($suppliers as $supplier)
                                        <option data-company="{{$supplier->supplier}}" data-address="{{$supplier->address}}" value="{{ $supplier->id }}">{{ $supplier->supplier_person }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-4 additional-info">
                                <div class="form-group">
                                    <label for="supplier">Supplier Company</label>
                                    <input type="text" class="form-control outline-0 border-0" name="company" id="supplier" readonly >
                                </div>
                            </div>
                            <div class="col-4 additional-info">
                                <div class="form-group">
                                    <label for="sup_address">Address</label>
                                    <input type="text" class="form-control outline-0 border-0" name="address" id="sup_address" readonly >
                                </div>
                            </div>
                            
                        </div>
                        <div class="dt-responsive table-responsive">
                            <table id="product-table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-md btn-primary rounded" onclick="getProductData()">Confirmed Transaction</button>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
<script src="{{asset('vendor\assets\js\jszip.min.js')}}"></script>
<script src="{{asset('vendor\assets\js\pdfmake.min.js')}}"></script>
<script src="{{asset('vendor\assets\js\vfs_fonts.js')}}"></script>
<script src="{{asset('vendor\assets\js\buttons.colVis.min.js')}}"></script>
<script src="{{asset('vendor\bower_components\datatables.net-buttons\js\buttons.print.min.js')}}"></script>
<script src="{{asset('vendor\bower_components\datatables.net-buttons\js\buttons.html5.min.js')}}"></script>
<script src="{{asset('vendor\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendor\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendor\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js')}}"></script>
<!-- Add this script to your HTML file after including jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $(document).ready(function () {
            $('#product-select').on('change', function () {
                var selectedOption = $(this).find(':selected');
                var selectedProduct = selectedOption.data('product');
                console.log("Selected Product: " + selectedProduct);
                $("#selected-product").val(selectedProduct);
            });

            function addProduct() {

                var product_id = $("#product-select").val();
                var product_name = $("#selected-product").val();
                var qty = $("#product-qty").val();
                var price = $("#product-price").val();

                if (!product_name || !qty || !price) {
                    alert("Please fill in all fields before adding a product.");
                    return;
                }

                var totalAmount = qty * price;

                var newRow = $("<tr>");
                newRow.append("<td hidden>" + product_id + "</td>");
                newRow.append("<td>" + product_name + "</td>");
                newRow.append("<td>" + qty + "</td>");
                newRow.append("<td>" + price + "</td>");
                newRow.append("<td>" + totalAmount + "</td>");

                var removeButton = $('<td><a class="btn-sm btn-danger text-white waves-effect"><i class="feather icon-trash-2"></i></a></td></tr>');
                removeButton.click(function () {
                    removeProduct(newRow);
                });
                newRow.append(removeButton);

                $("#product-table tbody").append(newRow);

                $("#product-form")[0].reset();

                $("#no-data-row").hide();
            }

            function removeProduct(button) {
                $(button).closest("tr").remove();

                if ($("#product-table tbody tr").length === 0) {
                    $("#no-data-row").show();
                }
            }

            $("#product-form").submit(function (event) {
                event.preventDefault();
                addProduct();
            });
        });
    });


    function getProductData() {

        var supplier = $("#sup_id").val();
        if (supplier === null) {
            alertify.set('notifier','position', 'top-right');
            alertify.error('<i class="feather icon-info"></i> Opps! Please select a supplier.');
            return;
        }

        var productData = [];
       
        $("#product-table tbody tr").each(function () {
            var product = $(this).find("td:nth-child(1)").text();
            var qty = $(this).find("td:nth-child(3)").text();
            var price = $(this).find("td:nth-child(4)").text();
            var totalAmount = $(this).find("td:nth-child(5)").text();

            productData.push({
                product: product,
                qty: qty,
                price: price,
                totalAmount: totalAmount
            });
        });

        if (productData.length === 0) {
            alertify.set('notifier','position', 'top-right');
            alertify.error('<i class="feather icon-info"></i> Opps Something Wrong! No product data to be transact.');
            return;
        }

        var dataToSend = {
            supplier_id: supplier,
            productData: productData
        }

        var jsonData = JSON.stringify(dataToSend);

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            type: "POST",
            url: "/admin/deliver/store",
            data: jsonData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            contentType: "application/json",
            success: function (response) {
                console.log("Data sent successfully:", response);

                if (response.message) {
                    window.location.href = "/admin/deliver?success=" + response.message;
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
<script>
    $(document).ready(function () {
        $('#additional-info').hide();

        $('#sup_id').on('change', function () {
            var selectedOption = $(this).find(':selected');
            var selectedCompany = selectedOption.data('company');
            var selectedAddress = selectedOption.data('address');

            console.log("Selected Company: " + selectedCompany);
            console.log("Selected Address: " + selectedAddress);

            if (selectedOption.val() === '') {
                $('#additional-info').hide();
            } else {
                $('#additional-info').show();
                $('#supplier').val(selectedCompany);
                $('#sup_address').val(selectedAddress);
            }
        });
    });
</script>
@endpush