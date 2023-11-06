@extends('layouts.main')
@section('breadcrumbs')
Home
@endsection
@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">

            <div class="col-xl-4 col-md-6">
                <div class="card bg-c-green text-white">
                    <div class="card-block">
                        <div class="row align-items-center">
                            <div class="col">
                                <p class="m-b-5">Total Products</p>
                                <h4 class="m-b-0">{{$c_product}}</h4>
                            </div>
                            <div class="col col-auto text-right">
                                <i class="feather icon-shopping-cart f-50 text-c-green"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-c-pink text-white">
                    <div class="card-block">
                        <div class="row align-items-center">
                            <div class="col">
                                <p class="m-b-5">Todays Income</p>
                                <h4 class="m-b-0">{{$c_today_income}}</h4>
                            </div>
                            <div class="col col-auto text-right">
                                <i class="feather icon-file-text f-50 text-c-pink"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12">
                <div class="card bg-c-blue text-white">
                    <div class="card-block">
                        <div class="row align-items-center">
                            <div class="col">
                                <p class="m-b-5">Total Transaction</p>
                                <h4 class="m-b-0">{{$c_transactions}}</h4>
                            </div>
                            <div class="col col-auto text-right">
                                <i class="feather icon-file f-50 text-c-blue"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         
        
            <div class="col-xl-12 col-md-12">
                <div class="card table-card p-4">
                    <div class="card-header">
                        <h5>Cashier's Daily's Income</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Cashier Name</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($today_transaction as $data)
                                    <tr>
                                        <td>{{\Carbon\Carbon::parse($data->created_at)->format('Y-m-d')}}</td>
                                        <td>{{$data->user->name}}</td>
                                        <td>{{$data->total_price}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-right m-r-20">
                                <a href="{{route('admin.sales')}}" class=" b-b-primary text-primary">View All Sales</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</div>

@endsection
@push('scripts')
@endpush
