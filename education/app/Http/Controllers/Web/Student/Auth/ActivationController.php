<?php

namespace App\Http\Controllers\Web\Student\Auth;


use App\Http\Controllers\Controller;
use App\Models\Users\Students\Student;
use Carbon\Carbon;

class ActivationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:student');
    }

    // activate the student account
    public function index($activation_code)
    {
        // get student of activation_code
        $student = Student::where('activation_code', $activation_code)->first();
        if(isset($student)){
            if(!$student->activated){

                // activating account
                $student->activated = 1;

                // changing status to active
                $student->status = "active";

                // saving time for activation
                $student->activated_at = Carbon::now();

                $student->save();
                $status = "Your e-mail is verified. You can now login.";
            }else{
                $status = "Your e-mail is already verified. You can now login.";
            }
        }else{
            return redirect('student')->with('warning', 'Sorry your email cannot be identified.');
        }

        return redirect('student')->with('status', $status);
    }
}
