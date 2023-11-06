@extends('layouts.main')

@section('breadcrumbs')
Edit Delivery Item List
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
                                <h5>Edit Delivered Item List - Transaction #: {{$delivery->tracking_no}}</h5>
                                <span>Data about deliverved items.</span>
                            </div>
                            <div class="col-4">
                                <a  data-toggle="modal" data-target="#newModal" class="btn btn-primary float-right rounded text-white">
                                    <i class="feather icon-plus"></i> New Delivery
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
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($delivery_items as $data)
                                    <tr>
                                        <td>{{$data->product->product_name}}</td>
                                        <td>{{$data->quantity->quantity}}</td>
                                        <td>{{$data->del_price}}</td>
                                        <td>{{$data->del_totalprice}}</td>
                                        <td>
                                            <a class="btn-sm btn-success text-white" data-toggle="modal" data-target="#editModal{{$data->id}}"><i class="feather icon-edit"></i></a>
                                            <a class="btn-sm btn-danger text-white waves-effect" data-toggle="modal" data-target="#modal-del{{$data->id}}"><i class="feather icon-trash-2"></i></a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-del{{$data->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            
                                                <form action="{{route('admin.deliver.removeEditItem',$data->id)}}" method="post">
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
                                                <form action="{{route('admin.deliver.editItemUpdate',$data->id)}}" id="add_frm" method="post">
                                                    @csrf
                                                    @method('PUT')
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
                                                            <input type="text" class="form-control" name="qty" id="product-qty" required="" value="{{$data->quantity->quantity}}" placeholder="Enter Quantity">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="product-price">Price</label>
                                                            <input type="text" class="form-control" name="price" id="product-price" required="" value="{{$data->del_price}}" placeholder="Enter Price">
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
                                        <th colspan="3" class="text-right">Total : </th>
                                        <th>{{$delivery->total_price}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div>
                            <a class="btn btn-md btn-secondary rounded" href="{{route('admin.deliver')}}">Back</a>
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
            <form action="{{route('admin.deliver.addEditedItem',$delivery->id)}}" id="add_frm" method="post">
                @csrf
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
@endpush