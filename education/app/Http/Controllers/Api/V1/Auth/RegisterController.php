<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helpers\StudentCommonHelper;
use App\Http\Controllers\Api\V1\BaseController;
use App\Mail\StudentActivation;
use App\Models\Users\Authorization;
use App\Models\Users\Students\Student;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Students\StudentDevice;
use App\Models\Users\Students\StudentPreferences;
use App\Models\Users\Students\StudentProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\Authorization as AuthorizationResource;

class RegisterController extends BaseController
{

    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string', // first name
            'last_name' => 'required|string', // last name
            'email' => 'required|email|unique:students',
            'mobile' => 'required|string',
            'password' => 'required|confirmed',
        ]);
    }

    public function register(Request $request)
    {
        $validator =  $this->validator($request->all());
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $student = $this->create($request->all());
        
        StudentProfile::create([
            'student_id' => $student->id
        ]);
        
        StudentPreferences::create([
            'student_id' => $student->id
        ]);
        
        StudentBalance::create([
            'student_id' => $student->id,
            'remaining_slots' => 20,
            'remaining_amount' =>  0,
            'purchased_slots' => -1 ,
            'purchased_amount'=> -1,
        ]);
        
        event(new Registered($student));

        $credentials = $request->only('email', 'password');
        // Validation failed will return 401
        if (!$token = $this->guard()->attempt($credentials)) {
            $this->response->errorUnauthorized(trans('auth.incorrect'));
        }

        //fcm -
        if ($request->get('fcm_token') != ""){
            $fcm_token = $request->get('fcm_token');
            $student_device = StudentDevice::where('fcm_token', $fcm_token)->first();
            if(!$student_device){
                $student_device = new StudentDevice();
                $student_device->fcm_token = $request->get("fcm_token");
                $student_device->platform =  $request->get("platform");
            }
            $student_device->student_id = $student->id; // connecting the device with logged in user for fcm notification
            $student_device->save();
        }
        // after login,  online_status on
        $student->online_status = 1;
        $student->update();

        $authorization = new Authorization($token);
        return $this->registered($request, $student)
            ?: new AuthorizationResource($authorization);
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
        Mail::to($student->email)->send(new StudentActivation($student));

        return $student;
    }

    protected function guard()
    {
        return Auth::guard('api');
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
            return  ['status' => 'error', 'msg' => 'We sent you an activation code. Check your email and click on the link to verify.']; // will notify the user
        }else {
            $student->online_status = 1;
            $student->update();
        }
    }


}
