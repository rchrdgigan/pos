<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Reciept</title>
    <link rel="icon" href="{{asset('imgstatic/logo.jpg')}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\bower_components\bootstrap\css\bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\icon\themify-icons\themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\icon\feather\css\feather.css')}}">
    @stack('links')
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\css\alertify.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\css\default.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\css\semantic.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\css\style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\css\jquery.mCustomScrollbar.css')}}">
</head>
<body>

    <div class="wrapper">
        <div class="card m-2">
            <div class="card-header">
                <div class="d-flex">
                    <img class="mr-2" src="{{asset('imgstatic/logo.png')}}" alt="" height="100" width="100">
                    <h2 class="mt-3">Payment Receipt</h2>
                    <address class="ml-auto text-right">
                        <strong style="font-size:20pt;">G.D.G</strong><br>
                        Juban, Sorsogon<br>
                        Date Transaction :<br>
                        {{\Carbon\Carbon::parse($sale->created_at)->format('M d, Y')}}<br>
                        Transaction Number :<br>
                        {{$sale->trans_no}}
                    </address>
                </div>
                
            </div>
            <div class="card-body">
            
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-sm border">Product</th>
                            <th class="text-sm border">Discount %</th>
                            <th class="text-sm border">Qty</th>
                            <th class="text-sm border">Price</th>
                            <th class="text-sm border">Amount</th>
                            <th class="text-sm border">Total Amount</th>
                        </tr>
                    </thead>
                    <?php $totalSubAmount = 0 ?>
                    <tbody>
                    @foreach($sale_items as $data)
                        <tr>
                            <td class="text-sm border">{{$data->product->product_name}}</td>
                            <td class="text-sm border">{{$data->sal_discount}}</td>
                            <td class="text-sm border">{{$data->sal_qty}}</td>
                            <td class="text-sm border">{{$data->sal_price}}</td>
                            <td class="text-sm border">{{$data->sal_subtotal}}</td>
                            <td class="text-sm border">{{$data->sal_totalprice}}</td>
                        </tr>
                        <?php $totalSubAmount = $totalSubAmount + $data->sal_subtotal ?>
                    @endforeach
                    </tbody>
                </table>

                <div class="row text-right mt-5">
                    <div class="col-6"></div>
                    <div class="col-6"> 
                        <b class="ml-auto">Total Sub Amount : {{$totalSubAmount}}</b>
                    </div>

                    <div class="col-6"></div>
                    <div class="col-6"> 
                        <b class="ml-auto">Total Amount : {{$sale->total_price}}</b>
                    </div>

                    <div class="col-6"></div>
                    <div class="col-6"> 
                        <b class="ml-auto">Cash : {{$sale->cash}}</b>
                    </div>

                    <div class="col-6"></div>
                    <div class="col-6"> 
                        <b class="ml-auto">Changed : {{$sale->change}}</b>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 text-center"> 
                </div>
                <div class="col-6 text-center"> 
                    <b>Cashier : {{auth()->user()->name}}</b><br><br><br><br>
                </div>
                <div class="col-12 text-center"> 
                    <br><br><b>This is system generated receipt</b>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('vendor\bower_components\jquery\js\jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor\bower_components\jquery-ui\js\jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor\bower_components\popper.js\js\popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor\bower_components\bootstrap\js\bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor\bower_components\jquery-slimscroll\js\jquery.slimscroll.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor\bower_components\modernizr\js\modernizr.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor\bower_components\modernizr\js\css-scrollbars.js')}}"></script>
    <script>
        window.addEventListener("load", window.print());
    </script>
    <script>
    window.onafterprint = function(){
        window.location.href = '{{ url()->previous() }}';
    }
    </script>
</body>
</html>
