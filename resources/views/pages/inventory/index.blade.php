@extends('layouts.main')

@section('title')
Inventory List
@endsection

@section('breadcrumbs')
Inventory List
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
                                <h5>Inventory Product List</h5>
                                <span>Data about inventory items.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Product Description</th>
                                        <th>Sales Cost</th>
                                        <th>Delivery SRP</th>
                                        <th>Delivery Qty</th>
                                        <th>Salles Qty</th>
                                        <th>Total Stock</th>
                                        <th>Total Cost Amount</th>
                                        <th>Total SRP Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventories as $data)
                                    <tr>
                                        <td>{{$data->product_name}}</td>
                                        <td>{{$data->desc}}</td>
                                        <td>{{$data->product_cost ?? 0}}</td>
                                        <td>{{$data->product_srp ?? 0}}</td>
                                        <td>{{$data->stock_qty ?? 0}}</td>
                                        <td>{{$data->sal_qty ?? 0}}</td>
                                        <td>{{$data->total_stock ?? $data->stock_qty}}</td>
                                        <td>{{$data->product_cost * $data->sal_qty}}</td>
                                        <td>{{$data->stock_price ?? 0}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Product</th>
                                        <th>Product Description</th>
                                        <th>Sales Cost</th>
                                        <th>Delivery SRP</th>
                                        <th>Salles Qty</th>
                                        <th>Delivery Qty</th>
                                        <th>Total Stock</th>
                                        <th>Total Cost Amount</th>
                                        <th>Total SRP Amount</th>
                                    </tr>
                                </tfoot>
                            </table>
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
            <form action="" id="add_frm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_pro">Supplier Company</label>
                        <input type="text" class="form-control" name="supplier" id="add_pro" required="" placeholder="Enter Product">
                    </div>
                    <div class="form-group">
                        <label for="add_pro">Supplier Name</label>
                        <input type="text" class="form-control" name="supplier_person" id="add_pro" required="" placeholder="Enter Product">
                    </div>
                    <div class="form-group">
                        <label for="add_pro">Address</label>
                        <input type="text" class="form-control" name="address" id="add_pro" required="" placeholder="Enter Product">
                    </div>
                    <div class="form-group">
                        <label for="add_pro">Contact Number</label>
                        <input type="text" class="form-control" name="cpnumber" id="add_pro" required="" placeholder="Enter Product">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-del" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
           
            <form action="{{route('admin.supplier.destroy')}}" id="del_frm" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id">
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