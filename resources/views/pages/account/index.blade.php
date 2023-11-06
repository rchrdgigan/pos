@extends('layouts.main')


@section('title')
Account List
@endsection

@section('breadcrumbs')
Account List
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
                                <h5>Account List</h5>
                                <span>Data about user account.</span>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-primary float-right rounded" data-toggle="modal" data-target="#newModal" class="btn btn-danger shadow btn-xs sharp"><i class="feather icon-plus"></i> New Account</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Cashier Name</th>
                                        <th>Email Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $data)
                                    <tr>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->email}}</td>
                                        <td>
                                            <a class="btn-sm btn-success text-white" id="{{$data->id}}" data-toggle="modal" data-target="#chaModal"><i class="ti-key"></i></a>
                                            <a class="btn-sm btn-success text-white" id="{{$data->id}}" name="{{$data->name}}" email="{{$data->email}}" data-toggle="modal" data-target="#editModal"><i class="feather icon-edit"></i></a>
                                            <a class="btn-sm btn-danger text-white waves-effect" id="{{$data->id}}" data-toggle="modal" data-target="#modal-del"><i class="feather icon-trash-2"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Cashier Name</th>
                                        <th>Email Address</th>
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
            <form action="{{route('admin.account.store')}}" id="add_frm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Cashier Name</label>
                        <input type="text" class="form-control" name="name" id="name" required="" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="email">Cashier Email</label>
                        <input type="text" class="form-control" name="email" id="email" required="" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" name="password" id="password" required="" placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                        <label for="confirmation_password">Confirmation Password</label>
                        <input type="text" class="form-control" name="password_confirmation" id="confirmation_password" required="" placeholder="Enter Confirmation Password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('admin.account.updateProfile')}}" id="edit_frm" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Cashier Name</label>
                        <input type="text" class="form-control" name="name" id="name" required="" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="email">Cashier Email</label>
                        <input type="text" class="form-control" name="email" id="email" required="" placeholder="Enter Email">
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

<div class="modal fade" id="chaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('admin.account.updatePassword')}}" id="ca_frm" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_pass">New Password</label>
                        <input type="text" class="form-control" name="name" id="new_pass" required="" placeholder="Enter New Password">
                    </div>
                    <div class="form-group">
                        <label for="change_pass">Confirm Password</label>
                        <input type="text" class="form-control" name="email" id="change_pass" required="" placeholder="Enter Change Password">
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

<div class="modal fade" id="modal-del" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
           
            <form action="{{route('admin.account.destroy')}}" id="del_frm" method="post">
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
           
        } );
    } );

    $('#modal-del').on('show.bs.modal', function (e) {
        var opener=e.relatedTarget;
        var id=$(opener).attr('id');
        $('#del_frm').find('[name="id"]').val(id);
    });

    $('#chaModal').on('show.bs.modal', function (e) {
        var opener=e.relatedTarget;
        var id=$(opener).attr('id');
        $('#ca_frm').find('[name="id"]').val(id);
    });

    $('#editModal').on('show.bs.modal', function (e) {
        var opener=e.relatedTarget;
        var id=$(opener).attr('id');
        var name=$(opener).attr('name');
        var email=$(opener).attr('email');

        $('#edit_frm').find('[name="id"]').val(id);
        $('#edit_frm').find('[name="name"]').val(name);
        $('#edit_frm').find('[name="email"]').val(email);
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