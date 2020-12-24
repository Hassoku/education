@extends('student.layout.app')
@section('pageTitle', 'Student')
@section('body_class_atr')login @endsection

{{--The body of login page--}}
@section('content')
    <div class="text-center mt-4">
        <img class="mb-2" src="{{asset('assets/student/images/durooos-logo.png')}}" alt="" width="150" >
    </div>
    <div class="form-signin">
        <div id="form-content" class="tab-content">
            <!-- Registration Form -->
            <form  role="tabpanel"  class="login-form tab-pane active" id="form-register" method="POST" action="{{route('student.invite.register.post')}}">
                <h1 class="h3 mb-3 font-weight-normal">Register your account</h1>
            {{ csrf_field() }}
            <!--- Error --->
                <div id = "errors-div"></div>
                <!----/Error-->

                {{--first name--}}
                <div class="form-label-group">
                    <input type="text" id="name" class="form-control" placeholder="First Name" name="name" value="{{ old('name') }}" required="" autofocus="">
                </div>

                {{--Middle Name--}}
                <div class="form-label-group">
                    <input type="text" id="middle_name" class="form-control" placeholder="Middle Name" name="middle_name" value="{{ old('middle_name') }}" autofocus="">
                </div>

                {{--Last Name--}}
                <div class="form-label-group">
                    <input type="text" id="last_name" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required="" autofocus="">
                </div>

                <div id="mobile-number-div" class="form-label-group">
                    <input type="tel" id="mobile" class="form-control" {{--placeholder="Mobile"--}} name="mobile" value="{{ old('mobile') }}" required="" autofocus="">
                    <span id="valid-mob-num-msg" class="hide">✓ Valid</span>
                    <span id="error-mob-num-msg" class="hide">Invalid number</span>
                </div>

                <div class="form-label-group">
                    <input type="email" id="Email" class="form-control" placeholder="Email address" name="email" value="{{ old('email') }}" required="" autofocus="">
                </div>

                <div class="form-label-group">
                    <input type="password" id="newpassword" class="form-control" placeholder="Password" name="password" required="" autofocus="">
                </div>

                <div class="form-label-group">
                    <input type="password" id="conformpassword" class="form-control" placeholder="Confirm Password" name="password_confirmation" required="" autofocus="">
                </div>

                <div class="form-label-group">
                    <input type="text" id="ref_code" class="form-control"  name="ref_code" value="{{$ref_code}}">
                </div>

                <button class="btn  btn-primary btn-block" type="submit">Register</button>

            </form>
        </div>
    </div>
@endsection
@section('own_js')
    <script>
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
            @if ($errors->has('ref_code'))
                $error_alert += "" +
                "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\n" +
                "            <strong>{{ $errors->first('ref_code') }}</strong>\n" +
                "            <button id='pass-alert-btn' type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                "                <span aria-hidden=\"true\">&times;</span>\n" +
                "            </button>\n" +
                "        </div>";
            @endif
            $('#errors-div').html($error_alert);
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
        }

        $(document).ready(function () {
            // for mobile number field
            forMobileField()

            // if page has errors
            showError();
        });
    </script>
@endsection
