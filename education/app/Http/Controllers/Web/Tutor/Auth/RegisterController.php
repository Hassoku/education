<?php

namespace App\Http\Controllers\Web\Tutor\Auth;


use App\Helpers\CommonHelper;
use App\Helpers\TutorCommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Users\Tutors\Tutor;
use App\Http\Resources\Tutor as TutorResources;
use App\Models\Users\Tutors\TutorPreferences;
use App\Models\Users\Tutors\TutorProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class RegisterController extends Controller
{
    use RedirectsUsers;

    // after registrations
    protected $redirectTo = 'tutor/profile/add';//'/tutor/dashboard';

    public function __construct()
    {
        if (Auth::check()) {
            // if user is logged in
            return redirect()->route('tutor.dashboard');
        }
        $this->middleware('guest:tutor');
    }

    public function showRegistrationForm()
    {
//        return view('tutor.auth.login');
        return redirect(route('tutor.home') . '#rg');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string', // first name
            'last_name' => 'required|string', // last name
            'email' => 'required|email|unique:tutors',
            //'mobile' => 'required|string',
            'mobile' => 'required|numeric|unique:tutors',
            //'mobile' => 'required|phone',
            'password' => 'required|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        $tutor =  Tutor::create([
            'name' => $data['name'], // first name
            'last_name' => $data['last_name'], // last name
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => 1, /// active
            'referral_code' => TutorCommonHelper::generateReferralCode($data['name'])
        ]);

        if($data['middle_name']){
            $tutor->middle_name = $data['middle_name'];
            $tutor->update();
        }

        return $tutor;
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails()){
            // redirect with errors
            return redirect(route('tutor.home') . '#rg')->withErrors($validator)->withInput();
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }


    protected function registered(Request $request, $tutor)
    {
        // create profile with default pic
        $tutor_profile = TutorProfile::create([
            'tutor_id' => $tutor->id
        ]);

        // creating preferences
        $tutor_preferences = TutorPreferences::create([
            'tutor_id' => $tutor->id
        ]);

        $tutor->online_status = 1;
        $tutor->update();

        // broad cast for online - for inform to students
/*            $channel = "tutor.status";
            $event = "tutor.status.event";
            $data = [
                'tutor' => new TutorResources($tutor)
            ];
            CommonHelper::puhser()->trigger('' . $channel,''.$event, $data);*/
    }

    protected function guard()
    {
        return Auth::guard('tutor');
    }



}
