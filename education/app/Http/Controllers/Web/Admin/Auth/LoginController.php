<?php

namespace App\Http\Controllers\Web\Admin\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        if (Auth::check()) {
            // if user is logged in
            return redirect()->route('admin.dashboard');
        }
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function logout(Request $request)
    {

        $this->guard()->logout();
//        $request->session()->invalidate();

        // checking whether another guard exists or not
        if(Auth::guard('student')->check() || Auth::guard('tutor')->check()){
            return redirect()->intended(route('admin.login.show'));
        }else {
            //$request->session()->invalidate();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect()->intended(route('admin.login.show'));
        }
//        return redirect()->intended(route('student.home'));
    }

}
