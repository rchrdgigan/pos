@extends('layouts.main')


@section('title')
Product List
@endsection

@section('breadcrumbs')
Product List
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
                                <h5>Product List</h5>
                                <span>Data about product.</span>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-primary float-right rounded" data-toggle="modal" data-target="#newModal" class="btn btn-danger shadow btn-xs sharp"><i class="feather icon-plus"></i> New Product</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>SRP</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product as $data)
                                    <tr>
                                        <td>{{$data->product_name}}</td>
                                        <td>{{$data->category->category_name}}</td>
                                        <td>{{$data->product_cost}}</td>
                                        <td>{{$data->product_srp}}</td>
                                        <td>{{$data->desc}}</td>
                                        <td>
                                            <a href="" class="btn-sm btn-success text-white" data-toggle="modal" data-target="#editModal{{$data->id}}"><i class="feather icon-edit"></i></a>
                                            <a class="btn-sm btn-danger text-white waves-effect" id="{{$data->id}}" data-toggle="modal" data-target="#modal-del"><i class="feather icon-trash-2"></i></a>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{route('admin.product.update')}}" id="edit_frm" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="{{$data->id}}">
                                                        <div class="form-group">
                                                            <label for="add_pro">Product Name</label>
                                                            <input type="text" class="form-control" name="product_name" id="add_pro" placeholder="Enter Product" value="{{$data->product_name}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="add_desc">Description</label>
                                                            <textarea name="description" class="form-control" id="add_desc" cols="30" rows="5">{{$data->desc}}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="price">Product Cost</label>
                                                            <input type="text" class="form-control" name="product_cost" id="price" placeholder="Enter Product Price" value="{{$data->product_cost}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="product_srp">Product SRP</label>
                                                            <input type="text" class="form-control" name="product_srp" id="product_srp" placeholder="Enter Product SRP" value="{{$data->product_srp}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="add_cat">Category</label>
                                                            <select class="form-control" id="add_cat" name="category" aria-label="Default select example">
                                                                <option selected disabled>--- Select Category ---</option>
                                                                @foreach($category as $data)
                                                                <option value="{{$data->id}}">{{$data->category_name}}</option>
                                                                @endforeach
                                                            </select>
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
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>SRP</th>
                                        <th>Description</th>
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
            <form action="{{route('admin.product.store')}}" id="add_frm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_pro">Product Name</label>
                        <input type="text" class="form-control" name="product_name" id="add_pro" required="" placeholder="Enter Product">
                    </div>
                    <div class="form-group">
                        <label for="add_cat">Category</label>
                        <select class="form-control" id="add_cat" name="category" required="" aria-label="Default select example">
                            <option selected disabled>--- Select Category ---</option>
                            @foreach($category as $data)
                            <option value="{{$data->id}}">{{$data->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Product Cost</label>
                        <input type="text" class="form-control" name="product_cost" id="price" placeholder="Enter Product Price">
                    </div>
                    <div class="form-group">
                        <label for="price">Product SRP</label>
                        <input type="text" class="form-control" name="product_srp" id="price" placeholder="Enter Product SRP">
                    </div>
                    <div class="form-group">
                        <label for="add_desc">Description</label>
                        <textarea name="description" class="form-control" id="add_desc" cols="30" rows="5"></textarea>
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
            <form action="{{route('admin.product.destroy')}}" id="del_frm" method="post">
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