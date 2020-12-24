<form  role="tabpanel"  class="login-form tab-pane active" id="form-login" method="POST" action="{{ route('student.login.post') }}">
    <h1 class="h3 mb-3 font-weight-normal">Login into your account</h1>
{{ csrf_field() }}

    <!--- Error --->
    
    <div id = "errors-div"></div>
    <!----/Error-->
    <div class="form-label-group">
    <div class="input-field col s12">
            <i class="material-icons prefix pt-2">person_outline</i>
            <input id="email" type="text" name="email" value="{{ old('email') }}">
            <label for="username" class="center-align">Username</label>
    </div>
        
    </div>

    <div class="form-label-group">
    <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">lock_outline</i>
                                    <input id="password" type="password" name="password">
                                    <label for="password">Password</label>
                                </div>
        <!--<input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required="">-->
    </div>


    <div class="checkbox mb-3">
                            <div class="row">
                                <div class="col s12 m12 l12 ml-2 mt-1">
                                    <p>
                                        <label>
                                            <input name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                            <span>Remember Me</span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
    <div class="row">
                <div class="input-field col s12">
                <button class="btn  btn-primary btn-block" type="submit">Sign in</button>
                       
                </div>
    </div>
    
                                
        <div class="input-field col s6 m6 l6">
            <p class="margin right-align medium-small"><a href="{{ route('student.password.request') }}">Forgot password ?</a></p>
        </div>
 
   <!-- <button class="btn  btn-primary btn-block" type="submit">Sign in</button>-->
    <p class="text-center mt-4">Or login with</p>
    <div class="social-login-buttons text-center">
        <a href="#{{--{{route('student.social.login',['social'=>'facebook'])}}--}}" class="btn btn-primary btn-facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        <button type="button" class="btn btn-primary">
            <i class="fab fa-twitter"></i>
        </button>
        <a href="{{route('student.social.login',['social'=>'google'])}}" class="btn btn-primary btn-danger">
            <i class="fab fa-google"></i>
        </a>

    </div>
</form>