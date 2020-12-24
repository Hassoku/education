<?php

namespace App\Http\Controllers\Web\Tutor\Auth;

use App\Helpers\CommonHelper;
use App\Helpers\TutorCommonHelper;
use App\Http\Resources\Tutor as TutorResources;
use App\Models\Users\Tutors\Tutor;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/tutor/dashboard';

    public function __construct()
    {
        if (Auth::check()) {
            // if user is logged in
            return redirect()->route('tutor.dashboard');
        }
        $this->middleware('guest:tutor')->except('logout');
    }

    public function showLoginForm()
    {
        return view('tutor.auth.login_register');
    }

    protected function authenticated(Request $request, $tutor)
    {

        // tutor online_status - for inform to students
        $tutor->online_status = 1;
        $tutor->update();

        // broad cast for online
        $channel = "tutor.status";
        $event = "tutor.status.event";
        $data = [
            'tutor' => new TutorResources($tutor)
        ];
        CommonHelper::puhser()->trigger('' . $channel,''.$event, $data);

        // sending notification to students: who select the "notify me" option for this tutor
        TutorCommonHelper::sendFCMNotifications($tutor->id);
    }

    public function logout(Request $request)
    {
        // tutor online_status
        $tutor = Auth::user();
        $tutor->online_status = 0;
        $tutor->isBusy = false; // every logout user will be !isBusy
        $tutor->update();

        // broad cast for online - for inform to students
        $channel = "tutor.status";
        $event = "tutor.status.event";
        $data = [
            'tutor' => new TutorResources($tutor)
        ];
        CommonHelper::puhser()->trigger('' . $channel,''.$event, $data);

        $this->guard()->logout();

        // checking whether another guard exists or not
        if(Auth::guard('admin')->check() || Auth::guard('student')->check()){
            return redirect()->intended(route('tutor.home'));
        }else{
            //$request->session()->invalidate();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect()->intended(route('tutor.home'));
        }
    }

    protected function guard()
    {
        return Auth::guard('tutor');
    }

    /////////
    /// return the form
    ///
    public function getAuthForm($type){
        if($type == 'lg'){
            return (String) view('tutor.auth.login_form');
        }elseif($type == 'rg'){
            return (String) view('tutor.auth.register_form');
        }
    }

    /// set online status = 0
    public function offline(Request $request){
        // tutor online_status
        $tutor = Auth::user();
        $tutor->online_status = 0;
        $tutor->update();

        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->intended(route('tutor.home'));
//        return ["msg" => "offline"];
    }


    // socialite
        /* Handle Social login request
        * @return response
        */
        public function socialLogin($social){
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
            $tutor = Tutor::where(['email' => $userSocial->getEmail()])->first();
            if($tutor){
                Auth::login($tutor);
                // sending notification to students: who select the "notify me" option for this tutor
                TutorCommonHelper::sendFCMNotifications($tutor->id);
                return redirect('/tutor/dashboard');
            }else{
                return redirect(route('tutor.home') . '#rg')->with(['status' => $userSocial->getEmail(). ' is not registered.', 'socialEmail' => $userSocial->getEmail()]);
            }
        }
}
