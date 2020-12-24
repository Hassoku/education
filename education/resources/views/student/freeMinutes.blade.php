@extends('student.layout.app')
@section('pageTitle', 'Free Minutes')
@section('body_class_atr')class="main"@endsection
@section('student_layout_topnavbar')
    @include('student.layout.topnavbar')
@endsection
@section('content')
    <main role="main">
        <div class="row mt-5">
            <div class="col-md-2 left-area pl-3"></div>
            <div class="col-md-8 border-right border-left">
                <div class="row">
                    <h3 class="text-center p-2">Share Duroos on social media and get free minutes</h3>
                </div>
                <div class="row">
                    <div class="col-md-2 col-form-label">Your Code</div>
                    <div class="col-md-10">
                        <div class="form-control text-center">{{$ref_code}}</div>
                    </div>
                </div>
                <div class="row text-center p-3">
                    <div class="col-12 social-login-buttons text-center">
                        <a class="btn btn-primary btn-facebook" target="_blank" href="http://www.facebook.com/sharer.php?u={{route('student.invite.register.show',['ref_code' => $ref_code])}}">
                            <i style="color: white" class="fab fa-facebook-f"></i>
                        </a>
                        <a class="btn btn-primary" target="_blank" href="http://twitter.com/share?text=Duroos App&url={{route('student.invite.register.show',['ref_code' => $ref_code])}}">
                            <i style="color: white" class="fab fa-twitter"></i>
                        </a>
                        <a class="btn btn-primary btn-danger" target="_blank" href="https://plus.google.com/share?url={{route('student.invite.register.show',['ref_code' => $ref_code])}}">
                            <i style="color: white" class="fab fa-google"></i>
                        </a>

                        <a class="btn btn-primary btn-linkedin" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url={{route('student.invite.register.show',['ref_code' => $ref_code])}}">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
            {{--Remaining Minutes Aside--}}
            @include('student.layout.remainingMinutesAsideBar');
        </div>
        {{--including footer--}}
        @include('student.layout.footer')
    </main>
@endsection
