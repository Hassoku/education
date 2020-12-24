@extends('student.layout.app')
@section('pageTitle', 'Student - Education+')
@section('body_class_atr')login @endsection

{{--The body of login page--}}
@section('content')
    <div class="text-center mt-4">
        <img class="mb-2" src="{{asset('assets/student/images/educationpluslogo.jpeg')}}" alt="" width="260" >
    </div>
    <div class="form-signin">

        <!-- When:  Email Activation -->
        @if (session('status'))
            <div class="">
                <div class="alert alert-info alert-dismissible fade show">
                    {{ session('status') }}
                </div>
            </div>
        @endif

         @if (session('warning'))
            <div class="">
                <div class="alert alert-warning alert-dismissible fade show">
                    {{ session('warning') }}
                </div>
            </div>
        @endif
        <!------------------------>

        <ul class="nav nav-tabs"  role="tablist">
            <li class="nav-item">
                <a id="login-a" class="nav-link active" href="{{route('student.home')}}#lg" {{--role="tab" data-toggle="tab"--}}>Login</a>
            </li>
            <li class="nav-item">
                <a id="register-a" class="nav-link" href="{{route('student.home')}}#rg" {{--role="tab" data-toggle="tab"--}}>Register</a>
            </li>
        </ul>
        <div id="form-content" class="tab-content">
            {{--log in register form will be added here--}}
        </div>
    </div>
@endsection
@section('own_js')
    <script>
        // login with error
        function onloginWithError() {
            $.get(
                '{{route('student.get.auth.form',['type' => 'lg'])}}',
                function (data) {
                    $('#form-content').html(data);
                    $('#login-a').addClass('active');
                    $('#register-a').removeClass('active');
                    showError()
                }
            );
        }
        // login with out error
        function onlogin() {
            $.get(
                '{{route('student.get.auth.form',['type' => 'lg'])}}',
                function (data) {
                    $('#form-content').html(data);
                    $('#login-a').addClass('active');
                    $('#register-a').removeClass('active');
                }
            );
        }
        // Registration with error
        function onRegistrationWithError () {
            $.get(
                '{{route('student.get.auth.form',['type' => 'rg'])}}',
                function (data) {
                    $('#form-content').html(data);
                    $('#register-a').addClass('active');
                    $('#login-a').removeClass('active');
                    showError();
                    setValueOnInputFields();
                    // for mobile number field
                    forMobileField()
                }
            );
        }
        // Registration with out error
        function onRegistration () {
            $.get(
                '{{route('student.get.auth.form',['type' => 'rg'])}}',
                function (data) {
                    $('#form-content').html(data);
                    $('#register-a').addClass('active');
                    $('#login-a').removeClass('active');
                    // for mobile number field
                    forMobileField()
                }
            );
        }
        // show error
        function showError() {
            var $error_alert = "";
            @if ($errors->has('email'))
                $error_alert += "" +
                "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\n" +
                "            <strong>{{ $errors->first('email') }}</strong>\n" +
                "            <button id='email-alert-btn' type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                "                <span aria-hidden=\"true\">&times;</span>\n" +
                "            </button>\n" +
                "        </div>";
            @endif
            @if ($errors->has('password'))
                $error_alert += "" +
                "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\n" +
                "            <strong>{{ $errors->first('password') }}</strong>\n" +
                "            <button id='pass-alert-btn' type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                "                <span aria-hidden=\"true\">&times;</span>\n" +
                "            </button>\n" +
                "        </div>";
            @endif
            @if ($errors->has('mobile'))
                $error_alert += "" +
                "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\n" +
                "            <strong>{{ $errors->first('mobile') }} Mobile</strong>\n" +
                "            <button id='pass-alert-btn' type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                "                <span aria-hidden=\"true\">&times;</span>\n" +
                "            </button>\n" +
                "        </div>";
            @endif
            $('#errors-div').html($error_alert);
        }

        function setValueOnInputFields(){
            $("#name").val('{{ old('name') }}');
            $("#middle_name").val('{{ old('middle_name') }}');
            $("#last_name").val("{{ old('last_name') }}");
            $("#email").val("{{ old('email') }}");

        }
        // registration - from - mobile - field js
        function forMobileField() {
            // for mobile number field
            var telInput = $("#mobile"),
                errorMsg = $("#error-mob-num-msg"),
                validMsg = $("#valid-mob-num-msg");

            // initialise plugin
            telInput.intlTelInput({
                utilsScript: "{{asset('assets/student/mobile_number_field/js/utils.js')}}"
            });

            var reset = function() {
                telInput.removeClass("error-mob-num");
                errorMsg.addClass("hide");
                validMsg.addClass("hide");
            };

            // on blur: validate
            telInput.blur(function() {
                reset();
                if ($.trim(telInput.val())) {
                    if (telInput.intlTelInput("isValidNumber")) {
                        validMsg.removeClass("hide");
                    } else {
                        telInput.addClass("error-mob-num");
                        errorMsg.removeClass("hide");
                    }
                }
            });

            // on keyup / change flag: reset
            telInput.on("keyup change", reset);

            @if(session('socialEmail'))
                $('#Email').val('{{ session('socialEmail') }}');
            @endif
        }

        $(document).ready(function () {
            /*
            * lg: login
            * rg: register
            * */
            var url = window.location.href;
            switch (url.split("#")[1]){
                // will move to login form
                case "lg":{
                    onloginWithError()
                }break;
                // will move to register form
                case "rg":{
                    onRegistrationWithError();
                }break;
                // default shows login
                default:{
                    onloginWithError();
                }
            }

            // click on login-a
            $('#login-a').click(function () {
                onlogin();
            });
            // click on register-a
            $('#register-a').click(function () {
                onRegistration()
            });
        });
    </script>
@endsection
