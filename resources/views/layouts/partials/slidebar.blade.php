@if(auth()->user()->type == 'admin')
<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Main</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{(request()->routeIs('admin.home'))?'active':''}}">
                <a href="{{route('admin.home')}}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>
            <li class="{{(request()->routeIs('admin.category'))?'active':''}}">
                <a href="{{route('admin.category')}}">
                    <span class="pcoded-micon"><i class="feather icon-list"></i></span>
                    <span class="pcoded-mtext">Category</span>
                </a>
            </li>
            <li class="{{(request()->routeIs('admin.product'))?'active':''}}">
                <a href="{{route('admin.product')}}">
                    <span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
                    <span class="pcoded-mtext">Product</span>
                </a>
            </li>
            <li class="{{(request()->routeIs('admin.supplier'))?'active':''}}">
                <a href="{{route('admin.supplier')}}">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Supplier</span>
                </a>
            </li>
            <li class="{{(request()->routeIs('admin.deliver'))?'active':''}}{{(request()->routeIs('admin.deliver.create'))?'active':''}}">
                <a href="{{route('admin.deliver')}}">
                    <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                    <span class="pcoded-mtext">New Deliveries</span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigatio-lavel">Report</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{(request()->routeIs('admin.inventory'))?'active':''}}">
                <a href="{{route('admin.inventory')}}">
                    <span class="pcoded-micon"><i class="feather icon-file-text"></i></span>
                    <span class="pcoded-mtext">Inventory</span>
                </a>
            </li>
            <li class="{{(request()->routeIs('admin.sales'))?'active':''}}">
                <a href="{{route('admin.sales')}}">
                    <span class="pcoded-micon"><i class="feather icon-file"></i></span>
                    <span class="pcoded-mtext">Sales Report</span>
                </a>
            </li>
            <li class="{{(request()->routeIs('admin.report'))?'active':''}}">
                <a href="{{route('admin.report')}}">
                    <span class="pcoded-micon"><i class="feather icon-bar-chart"></i></span>
                    <span class="pcoded-mtext">Chart</span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigatio-lavel">Settings</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{(request()->routeIs('admin.account'))?'active':''}}">
                <a href="{{route('admin.account')}}">
                    <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                    <span class="pcoded-mtext">Account</span>
                </a>
            </li>
            <li class="#">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    <span class="pcoded-micon"><i class="feather icon-log-out"></i></span>
                    <span class="pcoded-mtext">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
@else
<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">POS</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{(request()->routeIs('user.home'))?'active':''}}">
                <a href="{{route('user.home')}}">
                    <span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
                    <span class="pcoded-mtext">POS</span>
                </a>
            </li>
        </ul>
        <ul class="pcoded-item pcoded-left-item">
            <li class="#">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    <span class="pcoded-micon"><i class="feather icon-log-out"></i></span>
                    <span class="pcoded-mtext">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
@endif