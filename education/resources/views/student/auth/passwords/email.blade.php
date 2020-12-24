@extends('student.layout.app')
@section('pageTitle', 'Student Forgot Password')
@section('body_class_atr')class = "login"@endsection
@section('content')
    <div class="text-center mt-4">
        <img class="mb-2" src="{{asset('images/durooos-logo.png')}}" alt="" width="150" >
        <div class="form-signin">
            <form  class="form-horizontal"  method="POST" action="{{ route('student.password.reset.email') }}">
                <h1 class="h3 mb-3 font-weight-normal">Reset Password</h1>
            {{ csrf_field() }}

            <!--- Error --->
                @if ($errors->has('email'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            @endif
            <!----/Error-->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="form-label-group">
                    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" value="{{ old('email') }}" required="" autofocus="">
                </div>

                <button class="btn  btn-primary {{--btn-block--}} mt-3" type="submit">Send Link</button>
            </form>
        </div>
    </div>
@endsection
