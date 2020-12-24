<?php

namespace App\Http\Controllers\Web\Student\Auth;



use App\Helpers\StudentCommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Users\Students\Student;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Students\StudentProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class InvitationController extends Controller
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

    public function showRegistrationForm(Request $request, $ref_code)
    {
        // check referral code
        $checkReferralCode = Student::where(['referral_code' => $ref_code])->first();
        if(!$checkReferralCode){
            abort(404);
        }

        return view('student.auth.invite',[
            'ref_code' => $ref_code
        ]);
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
            'ref_code' => 'required'
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
            'active' => 1, /// active
            'referral_code' => StudentCommonHelper::generateReferralCode($data['name'])
        ]);

        if($data['middle_name']){
            $student->middle_name = $data['middle_name'];
            $student->update();
        }
        return $student;
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails()){
            // redirect with errors
            return redirect(route('student.invite.register.show',[
                'ref_code' => $request->get('ref_code')
            ]))->withErrors($validator)->withInput();
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

        // free 5 minutes
        // entry with -1 of purchased_slots and amount is free minutes entry
        $studentBalance = StudentBalance::create([
            'student_id' => $student->id,
            'remaining_slots' => 20,
            'remaining_amount' =>  0,
            'purchased_slots' => -1 ,
            'purchased_amount'=> -1,
        ]);

        $student->online_status = 1;
        $student->update();

    }

    protected function guard()
    {
        return Auth::guard('student');
    }

}
