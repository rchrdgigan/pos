<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS</title>
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
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="pcoded" class="pcoded load-height">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            @include('layouts.partials.usernavbar')
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    @include('layouts.partials.slidebar')
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            @include('layouts.partials.userbreadcrumbs')
                            <div class="main-body">
                            @yield('content')
                            </div>
                        </div>
                    </div>
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
    <script src="{{asset('vendor\assets\js\chartjs.js')}}"></script>
    @stack('scripts')
    <script src="{{asset('vendor\assets\js\alertify.min.js')}}"></script>
    @if (session('success'))
    <script>
        alertify.set('notifier','position', 'top-right');
        alertify.success('<i class="feather icon-check"></i> Success! {{ session("success") }}');
    </script>
    @endif
    @if (session('error'))
    <script>
        alertify.set('notifier','position', 'top-right');
        alertify.error('<i class="feather icon-info"></i> Opps Something Wrong! {{ session("error") }}');
    </script>
    @endif
    @if (session('warning'))
    <script>
        alertify.set('notifier','position', 'top-right');
        alertify.warning('<i class="feather icon-info"></i> Warning! {{ session("warning") }}');
    </script>
    @endif
    <script src="{{asset('vendor\assets\js\pcoded.min.js')}}"></script>
    <script src="{{asset('vendor\assets\js\vartical-layout.min.js')}}"></script>
    <script src="{{asset('vendor\assets\js\jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor\assets\js\script.js')}}"></script>
</body>
</html>