<?php

namespace App\Http\Controllers\Web\Student\Auth;



use App\Helpers\StudentCommonHelper;
use App\Http\Controllers\Controller;
use App\Mail\StudentActivation;
use App\Models\Users\Students\Student;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Students\StudentPreferences;
use App\Models\Users\Students\StudentProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;

class RegisterController extends Controller
{
    use RedirectsUsers;

    // after registrations
    protected $redirectTo = '/student/dashboard'; // 'student/profile/add';

    public function __construct()
    {
        if (Auth::check()) {
            // if user is logged in
            return redirect()->route('student.dashboard');
        }
        $this->middleware('guest:student');
    }
     /**
     * Show the step 1 Form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStep1(Request $request)
    {
        $student = $request->session()->get('student');
        return view('student.home',compact('student', $student));
    }

    public function showRegistrationForm(Request $request)
    {
        $student = $request->session()->get('student');
        // return view('student.home',compact('student', $student));
//        return view('student.auth.login');
        return redirect(route('student.home') . '#rg')->compact('student', $student);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string', // first name
            'last_name' => 'required|string', // last name
            'email' => 'required|email|unique:students',
            //'mobile' => 'required|string',
            'mobile' => 'required|numeric|unique:students',
            //'mobile' => 'required|phone',
            'password' => 'required|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        $student =  Student::create([
            'name' => $data['name'], // first name
            'last_name' => $data['last_name'], // last name
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

            // commented: cause of activation by email
            //'active' => 1, /// active

            'activated' => 0, // by default student will not activated
            'activation_code' => str_random(40),// activation code for student

            'referral_code' => StudentCommonHelper::generateReferralCode($data['name'])
        ]);

        if($data['middle_name']){
            $student->middle_name = $data['middle_name'];
            $student->update();
        }

        // activation mail
        // Mail::to($student->email)->send(new StudentActivation($student));

        return $student;
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails()){
            // redirect with errors
            return redirect(route('student.home') . '#rg')->withErrors($validator)->withInput();
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $student)
    {
        // create profile with default pic
        $student_profile = StudentProfile::create([
            'student_id' => $student->id
        ]);

        // creating preferences
        $student_preferences = StudentPreferences::create([
            'student_id' => $student->id
        ]);

        // free 5 minutes
        // entry with -1 of purchased_slots and amount is free minutes entry
        $studentBalance = StudentBalance::create([
            'student_id' => $student->id,
            'remaining_slots' => 20,
            'remaining_amount' =>  0,
            'purchased_slots' => -1 ,
            'purchased_amount'=> -1,
        ]);

        if(!$student->activated){
            Auth::logout();
            return redirect('student')->with('status', 'We sent you an activation code. Check your email and click on the link to verify.');
        }else {
            $student->online_status = 1;
            $student->update();
        }

    }

    protected function guard()
    {
        return Auth::guard('student');
    }

}
