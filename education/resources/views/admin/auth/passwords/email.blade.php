@extends('admin.layout.app')

<!-- Main Content -->
@section('content')

    <div class="center-block w-xxl w-auto-xs p-y-md">
        <!--<div class="navbar">
            <div class="pull-center">
                <div ui-include="'../views/blocks/navbar.brand.html'"></div>
            </div>
        </div>-->
        <div class="p-v-lg text-center">
            <img src="{{asset('assets/admin/images/logo/durooos-logo.png')}}" width="165" alt="." class="" style="margin-bottom: 5%;/*margin-left: 22%;*/" />
        </div>
        <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
            <div class="m-b"> Forgot your password?
                <p class="text-xs m-t">Enter your email address below and we will send you instructions on how to change your password.</p>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.password.reset.email') }}">
                {!! csrf_field() !!}
                <div class="md-form-group">
                    <input type="email" class="md-input" name="email" value="{{ old('email') }}" required>
                    <label>Your Email</label>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn primary btn-block p-x-md">Send</button>
            </form>
        </div>
        <p id="alerts-container"></p>
        <div class="p-v-lg text-center">Return to <a href="{{route('admin.login.show')}}" class="text-primary _600">Sign in</a></div>
    </div>
@endsection
