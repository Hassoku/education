<form  role="tabpanel"  class="login-form tab-pane active" id="form-register" method="POST" action="{{route('student.register.post')}}">
    <h1 class="h3 mb-3 font-weight-normal">Register your account</h1>
{{ csrf_field() }}
<!--- Error --->
    <div id = "errors-div"></div>
<!----/Error-->
    {{--first name--}}
    <div class="form-label-group">
    <div class="input-field col s12">
 
        <input id="username" type="text" namespace value="{{ old('name') }}" >
        <label for="username" class="center-align">First Name</label>
    </div>
        <!--<input type="text" id="name" class="form-control" placeholder="First Name" name="name" value="{{ old('name') }}" required="" autofocus="">-->
    </div>

    {{--Middle Name--}}
    <div class="form-label-group">
    <div class="input-field col s12">
        
        <input id="middlename" type="text" value="{{ old('middle_name') }}">
        <label for="middlename" class="center-align">Middle Name</label>
    </div>
        <!--<input type="text" id="middle_name" class="form-control" placeholder="Middle Name" name="middle_name" value="{{ old('middle_name') }}" autofocus="">-->
    </div>

    {{--Last Name--}}
    <div class="form-label-group">
    <div class="input-field col s12">
        <input type="text" id="last_name" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required="" autofocus="">
    </div>
</div>

    <div id="mobile-number-div" class="form-label-group">
    <div class="input-field col s6">
       <i class="material-icons prefix">phone</i>
        <input name="mobile" id="icon_telephone" type="tel" class="validate">
        <label for="icon_telephone" class="">Telephone</label>
    </div>
    </div>

    <div class="form-label-group">
    <div class="input-field col s12">
        <input type="email" id="email" class="form-control" placeholder="Email address" name="email"
               value="{{ old('email') }}" required="" autofocus="">
</div>
    </div>

    <div class="form-label-group">
    <div class="input-field col s12">
        <input type="password" id="newpassword" class="form-control" placeholder="Password" name="password" required="" autofocus="">
</div>
    </div>

    <div class="form-label-group">
    <div class="input-field col s12">
        <input type="password" id="conformpassword" class="form-control" placeholder="Confirm Password" name="password_confirmation" required="" autofocus="">
    </div>
</div>

{{--    <div class="form-label-group">
    <div class="input-field col s12">
        <input type="text" id="code" class="form-control" placeholder="Referral Code (optional)" name="referral_code"  autofocus="">
</div>
    </div>--}}

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