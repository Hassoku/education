<!-- Registration Form -->
<form  role="tabpanel"  class="login-form tab-pane active" id="form-register" method="POST" action="{{route('tutor.register.post')}}">
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
        <input type="text" id="code" class="form-control" placeholder="Referral Code (optional)" name="referral_code"  autofocus="">
    </div>

    <button class="btn  btn-primary btn-block" type="submit">Register</button>

    <p class="text-center mt-4">Or Register with</p>
    <div class="social-login-buttons text-center">
        <button type="button" class="btn btn-primary btn-facebook">
            <i class="fab fa-facebook-f"></i>
        </button>
        <button type="button" class="btn btn-primary">
            <i class="fab fa-twitter"></i>
        </button>
        <button type="button" class="btn btn-primary btn-danger">
            <i class="fab fa-google"></i>
        </button>
    </div>
</form>