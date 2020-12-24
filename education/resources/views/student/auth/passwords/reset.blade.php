@extends('student.layout.app')
@section('pageTitle', 'Student Password Reset')
@section('content')
<div class="container">
    <div class="text-center mt-4">
        <img class="mb-2" src="{{asset('images/durooos-logo.png')}}" alt="" width="150" >
        <div class="form-signin">
            <form  class="form-horizontal" method="POST" action="{{ route('student.password.reset') }}">
                <h1 class="h3 mb-3 font-weight-normal">Reset Password</h1>
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">

                <!--- Error --->
                @if ($errors->has('email') || $errors->has('password'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @if($errors->has('email'))
                            <strong>{{ $errors->first('email') }}</strong>
                        @endif
                        @if($errors->has('password'))
                            <strong>{{ $errors->first('password') }}</strong>
                         @endif
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            @endif
            <!----/Error-->

                <div class="form-label-group">
                    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" value="{{ old('email') }}" required="" autofocus="">
                </div>

                <div class="form-label-group">
                    <input type="password" id="inputPassword" class="form-control mt-3" placeholder="Password" name="password" required="">
                </div>
                <div class="form-label-group">
                    <input type="password" id="inputPasswordCsonfirmation" class="form-control mt-3 " placeholder="Password Confirmation" name="password_confirmation" required="">
                </div>
                <button class="btn  btn-primary mt-3" type="submit">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
