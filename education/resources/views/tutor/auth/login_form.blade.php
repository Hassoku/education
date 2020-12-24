<!-- Login Form-->
<form  role="tabpanel"  class="login-form tab-pane active" id="form-login" method="POST" action="{{ route('tutor.login.post') }}">
    <h1 class="h3 mb-3 font-weight-normal">Login into your account</h1>
{{ csrf_field() }}

    <!--- Error --->
    <div id = "errors-div"></div>
    <!----/Error-->

    <div class="form-label-group">
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" value="{{ old('email') }}" required="" autofocus="">
    </div>

    <div class="form-label-group">
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required="">
    </div>

    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
        </label>
        <a href="{{ route('tutor.password.request') }}" class="float-right">Forgot Password?</a>

    </div>
    <button class="btn  btn-primary btn-block" type="submit">Sign in</button>
    <p class="text-center mt-4">Or login with</p>
    <div class="social-login-buttons text-center">
        <a href="{{--{{route('tutor.social.login',['social'=>'facebook'])}}--}}" class="btn btn-primary btn-facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        <button type="button" class="btn btn-primary">
            <i class="fab fa-twitter"></i>
        </button>
        <button type="button" class="btn btn-primary btn-danger">
            <i class="fab fa-google"></i>
        </button>

    </div>
</form>