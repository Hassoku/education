<?php

namespace App\Http\Controllers\Web\Student\Auth;


use App\Helpers\CommonHelper;
use App\Models\Users\Students\Student;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Resources\Student as StudentResources;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
    
    use AuthenticatesUsers;
    
    protected $redirectTo = '/student/dashboard';
    
    public function __construct()
    {
        if (Auth::check()) {
            // if user is logged in
            return redirect()->route('student.dashboard');
        }
        $this->middleware('guest:student')->except('logout');
    }
    
    public function showLoginForm()
    {
        return view('student.auth.login_register');
    }
    
    protected function authenticated(Request $request, $student)
    {
        if (!$student->activated) {
            Auth::logout();
            return redirect('student')->with('warning', 'You need to confirm your account first. We have sent you activation mail');
        } else {
            // student online_status - for inform to students
            $student->online_status = 1;
            $student->update();
            
            // broad cast for online
            $channel = "student.status";
            $event = "student.status.event";
            $data = [
                'student' => new StudentResources($student)
            ];
            CommonHelper::puhser()->trigger('' . $channel, '' . $event, $data);
        }
    }
    
    public function logout(Request $request)
    {
        // student online_status
        $student = Auth::user();
        $student->online_status = 0;
        $student->update();
        
        // broad cast for online
        $channel = "student.status";
        $event = "student.status.event";
        $data = [
            'student' => new StudentResources($student)
        ];
        CommonHelper::puhser()->trigger('' . $channel, '' . $event, $data);
        
        $this->guard()->logout();
//        $request->session()->invalidate();
        
        // checking whether another guard exists or not
        if (Auth::guard('admin')->check() || Auth::guard('tutor')->check()) {
            return redirect()->intended(route('student.home'));
        } else {
            //$request->session()->invalidate();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect()->intended(route('student.home'));
        }
//        return redirect()->intended(route('student.home'));
    }
    
    protected function guard()
    {
        return Auth::guard('student');
    }
    
    /////////
    /// return the form
    ///
    public function getAuthForm($type)
    {
        if ($type == 'lg') {
            return view('student.auth.login_form');
        } elseif ($type == 'rg') {
            return view('student.auth.register_form');
        }
    }
    
    
    // socialite
    /* Handle Social login request
    * @return response
    */
    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }
    
    /**
     * Obtain the user information from Social Logged in.
     * @param $social
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback($social)
    {
        $userSocial = Socialite::driver($social)->user();
        dd($userSocial);
        //return  json_encode($userSocial); //print_r($userSocial,true);
        //return $userSocial->user['gender'];
        //return $userSocial->user['displayName'];
        $student = Student::where(['email' => $userSocial->getEmail()])->first();
        if ($student) {
            Auth::login($student);
            return redirect('/student/dashboard');
        } else {
            return redirect(route('student.home') . '#rg')->with(['status' => $userSocial->getEmail() . ' is not registered.', 'socialEmail' => $userSocial->getEmail()]);
        }
    }
    
}
