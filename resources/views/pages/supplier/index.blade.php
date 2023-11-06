@extends('layouts.main')

@section('title')
Supplier List
@endsection

@section('breadcrumbs')
Supplier List
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
                                <h5>Supplier List</h5>
                                <span>Data about supplier.</span>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-primary float-right rounded" data-toggle="modal" data-target="#newModal" class="btn btn-danger shadow btn-xs sharp"><i class="feather icon-plus"></i> New Supplier</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Supplier</th>
                                        <th>Contact Person</th>
                                        <th>Address</th>
                                        <th>Contact Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($suppliers as $data)
                                    <tr>
                                        <td>{{$data->supplier}}</td>
                                        <td>{{$data->supplier_person}}</td>
                                        <td>{{$data->address}}</td>
                                        <td>{{$data->cpnumber}}</td>
                                        <td>
                                            <a href="" class="btn-sm btn-success text-white" data-toggle="modal" data-target="#editModal{{$data->id}}"><i class="feather icon-edit"></i></a>
                                            <a class="btn-sm btn-danger text-white waves-effect" id="{{$data->id}}" data-toggle="modal" data-target="#modal-del"><i class="feather icon-trash-2"></i></a>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{route('admin.supplier.update')}}" id="edit_frm" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="{{$data->id}}">
                                                        <div class="form-group">
                                                            <label for="add_pro">Supplier Company</label>
                                                            <input type="text" class="form-control" name="supplier" id="add_pro" required="" value="{{$data->supplier}}" placeholder="Enter Company">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="add_pro">Supplier Name</label>
                                                            <input type="text" class="form-control" name="supplier_person" id="add_pro" required="" value="{{$data->supplier_person}}" placeholder="Enter Name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="add_pro">Address</label>
                                                            <input type="text" class="form-control" name="address" id="add_pro" required="" value="{{$data->address}}" placeholder="Enter Address">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="add_pro">Contact Number</label>
                                                            <input type="text" class="form-control" name="cpnumber" id="add_pro" required="" value="{{$data->cpnumber}}" placeholder="Enter Number">
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
                                        <th>Supplier</th>
                                        <th>Contact Person</th>
                                        <th>Address</th>
                                        <th>Contact Number</th>
                                        <th>Action</th>
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
            <form action="{{route('admin.supplier.store')}}" id="add_frm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_pro">Supplier Company</label>
                        <input type="text" class="form-control" name="supplier" id="add_pro" required="" placeholder="Enter Company">
                    </div>
                    <div class="form-group">
                        <label for="add_pro">Supplier Name</label>
                        <input type="text" class="form-control" name="supplier_person" id="add_pro" required="" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="add_pro">Address</label>
                        <input type="text" class="form-control" name="address" id="add_pro" required="" placeholder="Enter Address">
                    </div>
                    <div class="form-group">
                        <label for="add_pro">Contact Number</label>
                        <input type="text" class="form-control" name="cpnumber" id="add_pro" required="" placeholder="Enter Number">
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