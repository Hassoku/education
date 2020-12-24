@extends('admin.layout.app')
@section('content')
    <div class="center-block w-xxl w-auto-xs p-y-md">
        <!--<div class="navbar">
            <div class="pull-center">
                <div ui-include="'../views/blocks/navbar.brand.html'"></div>
            </div>
        </div>-->
        <div class="p-v-lg text-center">
            <img src="{{ asset('/assets/admin/images/logo/educationpluslogo.jpeg') }}" width="290" height="100" alt="" class="" style="margin-bottom: -5%;border-radius: 3px;/*margin-left: 22%;*/" />
        </div>
        @if (!empty($success_message))
            <div class="alert alert-success">
                {{ $success_message }}
            </div>
        @endif
        @if (!empty($error_message))
            <div class="alert alert-danger">
                {{ $error_message }}
            </div>
        @endif
        <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
            <div class="m-b text-sm"> Sign in with your authorized email and password </div>
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.login.post') }}">
                {{ csrf_field() }}
                <div class="md-form-group float-label">
                    <input type="email" class="md-input" ng-model="user.email" name="email" value="{{ old('email') }}" required>
                    <label>Email</label>
                    @if ($errors->has('email')) <span class="help-block"> <strong>{{ $errors->first('email') }}</strong> </span> @endif
                </div>
                <div class="md-form-group float-label">
                    <input type="password" class="md-input" ng-model="user.password" name="password" placeholder="Password" required>
                    <!--label>Password</label-->
                    @if ($errors->has('password')) <span class="help-block"> <strong>{{ $errors->first('password') }}</strong> </span> @endif
                </div>
                <div class="m-b-md">
                    <label class="md-check">
                        <input type="checkbox" name="remember">
                        <i class="primary"></i> Keep me signed in </label>
                </div>
                <button type="submit" class="btn primary btn-block p-x-md">Sign in</button>
                {{csrf_field()}}
            </form>
        </div>
        <div class="p-v-lg text-center">
            <div class="m-b"><a ui-sref="access.forgot-password" href="{{ route('admin.password.request') }}" class="text-primary _600">Forgot password?</a></div>
            {{--}}<div>Do not have an account? <a ui-sref="access.signup" href="{{route('register') }}" class="text-primary _600">Sign up</a></div>{{--}}
        </div>
    </div>
@endsection