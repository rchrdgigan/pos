@extends('layouts.main')

@push('links')
<link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\css\alertify.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\css\default.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\css\semantic.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendor\assets\css\bootstrap.min.css')}}">
@endpush

@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="row mb-4">
            <div class="col-8">
                <h4><i class="feather icon-user"></i> Account</h4>
                <span>Manage your account information.</span>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4><i class="feather icon-user rounded-circle bg-success p-2"></i> Profile</h4>
                        <span>Update your profile information.</span>
                    </div>
                </div>
            </div>
            <div class="card-block">
                @if(auth()->user()->type == 'admin')
                    <form action="{{route('admin.update')}}" method="post">
                @else
                    <form action="{{route('user.update')}}" method="post">
                @endif
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ auth()->user()->name }}" placeholder="Input Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ auth()->user()->email }}" placeholder="Input Email Address" required>
                            </div>
                        </div>
                    </div>
                    <div class="row float-right p-3">
                        <button type="submit" class="btn btn-primary ml-2 rounded" name="createBtn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4><i class="feather icon-lock rounded-circle bg-success p-2"></i> Password</h4>
                        <span>Change your password here.</span>
                    </div>
                </div>
            </div>
            <div class="card-block">
                @if(auth()->user()->type == 'admin')
                    <form action="{{route('admin.changepassword')}}" method="post">
                @else
                    <form action="{{route('user.changepassword')}}" method="post">
                @endif
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="old">Current Password</label>
                                <input type="password" class="form-control" name="old_password" id="old" placeholder="Input Current Password" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" name="new_password" id="password" placeholder="Input New Password" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="new_password_confirmation">Confirmation Password</label>
                                <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" placeholder="Retype New Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row float-right p-3">
                        <button type="submit" class="btn btn-primary ml-2 rounded" name="createBtn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('vendor\assets\js\alertify.min.js')}}"></script>
@endpush