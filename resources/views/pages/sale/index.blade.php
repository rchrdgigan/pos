@extends('layouts.main')

@section('title')
Sales List
@endsection

@section('breadcrumbs')
Sales List
@endsection

@push('links')
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\css\buttons.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                                <h5>Sales Report</h5>
                                <span>Data about sales.</span>
                            </div>
                            <div class="col-4">
                                <form method="GET">
                                    <div class="d-flex float-right col-12">
                                    <input type="text" class="form-control col-8" name="daterange" id="daterange" value="{{ request('daterange', '10/01/2023 - 10/15/2023') }}" />
                                    <button type="submit" class="btn-sm btn btn-primary col-4">Filter by Date</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Cashier</th>
                                        <th>Transaction ID</th>
                                        <th>Cash</th>
                                        <th>Changed</th>
                                        <th>Total Sales</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php $totalAmount = 0; ?>
                                <tbody>
                                    @foreach($sales as $sales)
                                    <tr>
                                        <td>{{\Carbon\Carbon::parse($sales->created_at)->format('Y-m-d')}}</td>
                                        <td>{{$sales->user->name}}</td>
                                        <td>{{$sales->trans_no}}</td>
                                        <td>{{$sales->cash}}</td>
                                        <td>{{$sales->change}}</td>
                                        <td>{{$sales->total_price}}</td>
                                        <td>
                                            <a type="button" class="btn-sm btn-success text-white" href="{{route('admin.sales.show', $sales->id)}}"><i class="feather icon-eye"></i></a>
                                            <!-- <a href="{{route('admin.sales.edit', $sales->id)}}" class="btn-sm btn-success text-white"><i class="feather icon-edit"></i></a> -->
                                            <a class="btn-sm btn-danger text-white waves-effect" id="{{$sales->id}}" data-toggle="modal" data-target="#modal-del"><i class="feather icon-trash-2"></i></a>
                                        </td>
                                    </tr>
                                    <?php $totalAmount = $totalAmount + $sales->total_price ?>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right">Total Amount : </td>
                                        <td colspan="2" >{{$totalAmount}}</td>
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

<div class="modal fade" id="modal-del" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
           
            <form action="{{route('admin.sales.destroy')}}" id="del_frm" method="post">
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush