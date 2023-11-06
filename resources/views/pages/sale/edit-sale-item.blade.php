@extends('layouts.main')

@section('breadcrumbs')
Edit Sales List
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

            <div class="col-xl-12 col-md-12">
                 <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5>Edit salesed Item List - Transaction #: {{$sale->tracking_no}}</h5>
                                <span>Data about sale items.</span>
                            </div>
                            <div class="col-4">
                                <a  data-toggle="modal" data-target="#newModal" class="btn btn-primary float-right rounded text-white">
                                    <i class="feather icon-plus"></i> New Item Transact
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Discount %</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Amount</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale_items as $data)
                                    <tr>
                                        <td>{{$data->product->product_name}}</td>
                                        <td>{{$data->sal_discount}}</td>
                                        <td>{{$data->sal_qty}}</td>
                                        <td>{{$data->sal_price}}</td>
                                        <td>{{$data->sal_subtotal}}</td>
                                        <td>{{$data->sal_totalprice}}</td>
                                        <td>
                                            <a class="btn-sm btn-success text-white" data-toggle="modal" data-target="#editModal{{$data->id}}"><i class="feather icon-edit"></i></a>
                                            <a class="btn-sm btn-danger text-white waves-effect" data-toggle="modal" data-target="#modal-del{{$data->id}}"><i class="feather icon-trash-2"></i></a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-del{{$data->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            
                                                <form action="{{route('admin.sales.removeEditItem',$data->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="mx-auto">
                                                                <i class="feather icon-alert-triangle display-1 text-danger"></i>
                                                            </div>
                                                        </div>
                                                        <h4 class="text-center">Are you sure want to delete this?</h4>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Yes, Delete it.</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{route('admin.sales.editItemUpdate',$data->id)}}" id="add_frm" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="product-select">Product</label>
                                                            <select class="form-control" id="product-select" name="product" required="" aria-label="Default select example">
                                                                <option selected value="" disabled>--- Select Product ---</option>
                                                                @foreach($products as $product)
                                                                @if($product->id === $data->product->id)
                                                                <option selected value="{{ $product->id }}" data-product="{{$product->product_name}}" data-price="{{$product->product_cost ?? 0}}"  data-qty="{{$product->qty ?? 0}}">{{ $product->product_name }}</option>
                                                                <?php $qty = $product->qty;?>
                                                                <?php $price = $product->product_cost;?>
                                                                @else
                                                                <option value="{{ $product->id }}" data-product="{{$product->product_name}}" data-price="{{$product->product_cost ?? 0}}"  data-qty="{{$product->qty ?? 0}}">{{ $product->product_name }}</option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                            <div class="d-flex align-items-center mt-2">
                                                                <label for="product-select">Product Price : </label>
                                                                <input type="text" class="form-control col-md-8" readonly value="{{$price}}" id="selected-price">
                                                            </div>
                                                            <div class="d-flex align-items-center mt-2">
                                                                <label for="product-select">Product Stock : </label>
                                                                <input type="text" class="form-control col-md-8" readonly value="{{$qty}}" id="selected-qty">
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="add_disc">Discount %</label>
                                                            <input type="number" class="form-control" min="0" max="99" name="discount" id="product-discount" required="" value="{{$data->sal_discount}}" placeholder="Enter Discount">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="add_qua">Quantity</label>
                                                            <input type="number" class="form-control" min="0" name="quantity" id="product-qty" required="" value="{{$data->sal_qty}}" onchange="qtyValidation()" placeholder="Enter Quantity">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-right">Total Sales: </th>
                                        <th>{{$sale->total_price}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div>
                            <a class="btn btn-md btn-secondary rounded" href="{{route('admin.sales')}}">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</div>
<div class="modal fade" id="newModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('admin.sales.addEditedItem',$sale->id)}}" id="add_frm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product-select2">Product</label>
                        <select class="form-control" id="product-select2" name="product" required="" aria-label="Default select example">
                            <option selected value="" disabled>--- Select Product ---</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price2="{{$product->product_cost ?? 0}}" data-qty2="{{$product->qty ?? 0}}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                        <div class="d-flex align-items-center mt-2">
                            <label for="product-select">Product Price : </label>
                            <input type="text" class="form-control col-md-8" name="price" readonly id="selected-price2">
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <label for="product-select">Product Stock : </label>
                            <input type="text" class="form-control col-md-8" readonly  id="selected-qty2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="add_disc">Discount %</label>
                        <input type="number" class="form-control" min="0" max="99" name="discount" id="product-discount" required="" placeholder="Enter Discount">
                    </div>
                    <div class="form-group">
                        <label for="add_qua">Quantity</label>
                        <input type="number" class="form-control" min="0" name="qty" id="product-qty" required="" onchange="qtyValidation()" placeholder="Enter Quantity">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Add</button>
                </div>
            </form>
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
<script>
     $(document).ready(function () {
        $('#product-select').on('change', function () {
            var selectedOption = $(this).find(':selected');
            var selectedQty = selectedOption.data('qty');
            var selectedPrice = selectedOption.data('price');
            console.log("Selected Price: " + selectedPrice);
            console.log("Selected Qty: " + selectedQty);
            $("#selected-price").val(selectedPrice);
            $("#selected-qty").val(selectedQty);
        });
        $('#product-select2').on('change', function () {
            var selectedOption2 = $(this).find(':selected');
            var selectedQty2 = selectedOption2.data('qty2');
            var selectedPrice2 = selectedOption2.data('price2');
            console.log("Selected Qty: " + selectedQty2);
            console.log("Selected Price: " + selectedPrice2);
            $("#selected-qty2").val(selectedQty2);
            $("#selected-price2").val(selectedPrice2);
        });
    });
    function qtyValidation(){
        var current_stock = $("#selected-qty").val();
        var qty = $("#product-qty").val();

        if (current_stock < qty) {
            alertify.set('notifier','position', 'top-right');
            alertify.error('<i class="feather icon-info"></i> Opps! Quantity must be less than or equal to the stock qty.');
            $("#product-qty").val("");
        }
    }

</script>
@endpush