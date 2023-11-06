@extends('layouts.main')

@section('title')
Report Chart
@endsection

@section('breadcrumbs')
Report Chart
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
                                <h5>Report Chart</h5>
                                <span>Data about report chart.</span>
                            </div>
                            <div class="col-4">
                                <form method="GET">
                                    <div class="row">
                                        <label class="mt-2 col-form-label text-md-end align-self-center">Filtered by: </label>
                                        <div class="col-md-6 mt-2">
                                            <select name="filter" class="form-control">
                                            <option value="today">Today</option>
                                            <option @if(request('filter')=='yesterday') selected @endif value="yesterday">Yesterday</option>
                                            <option @if(request('filter')=='weekly') selected @endif value="weekly">Last 7 Days</option>
                                            <option @if(request('filter')=='last_30_days') selected @endif value="last_30_days">Last 30 Days</option>
                                            <option @if(request('filter')=='this_mo') selected @endif value="this_mo">This Month</option>
                                            <option @if(request('filter')=='last_mo') selected @endif value="last_mo">Last Month</option>
                                            <option @if(request('filter')=='annual') selected @endif value="annual">Annual</option>
                                            </select>
                                        </div>
                                        <button class="col-md-2 mt-2 btn btn-sm btn-primary align-self-center"><i class="feather icon-search" aria-hidden="true"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="card-body">
                        {!! $chart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</div>

@endsection

@push('scripts')
{!! $chart->script() !!}
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