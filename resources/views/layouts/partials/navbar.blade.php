<nav class="navbar header-navbar pcoded-header auth-header" header-theme="theme1">
    <div class="navbar-wrapper">

        <div class="navbar-logo" logo-theme="theme1">
        @guest
        @else
            <a class="mobile-menu col-md-end" id="mobile-collapse" href="#!">
                <i class="feather icon-menu"></i>
            </a>
        @endguest
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{asset('imgstatic/logo.png')}}" alt="logo" width="50"> G. D. G.
            </a>
            <a class="mobile-options">
                <i class="feather icon-more-horizontal"></i>
            </a>
        </div>

        <div class="navbar-container container-fluid">
           
            <ul class="nav-right">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"> <i class="feather icon-user"></i><i class="feather icon-log-in"></i> {{ __('Login') }}</a>
                        </li>
                    @endif
                @else
                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset('imgstatic/profile.png')}}" class="img-radius" alt="User-Profile-Image">
                            <span>{{auth()->user()->name}}</span>
                            <i class="feather icon-chevron-down"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li>
                            @if(auth()->user()->type == 'admin')
                                <a href="{{route('admin.profile')}}">
                                    <i class="feather icon-user"></i> Profile
                                </a>
                             @else
                                <a href="{{route('user.profile')}}">
                                    <i class="feather icon-user"></i> Profile
                                </a>
                            @endif
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="feather icon-log-out"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>

                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>