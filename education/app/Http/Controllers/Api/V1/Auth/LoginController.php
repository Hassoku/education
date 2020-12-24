<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helpers\StudentCommonHelper;
use App\Mail\StudentActivation;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Students\StudentPreferences;
use App\Models\Users\Students\StudentProfile;
use Exception;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Api\V1\BaseController;
use App\Models\Users\Authorization;
use App\Models\Users\Students\Student;
use App\Http\Resources\Student as StudentResources;
use App\Models\Users\Students\StudentDevice;
use Dingo\Api\Http\Response;
use Google_Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Authorization as AuthorizationResource;
use Laravel\Socialite\Facades\Socialite;
use Pusher\PusherException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends BaseController
{
    
    public function validator(array $data)
    {
        return Validator::make($data, [
            $this->username() => 'required|email',
            'password'        => 'required',
        ]);
    }
    
    public function login(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        // check user is active or not
        $student = Student::where([
            [$this->username(), '=', $request->email],
            ['activated', '=', 1]
        ])->first();
        // email is not registered if user is empty
        if (!$student) {
            return Response::makeFromJson(JsonResponse::create(['error-msg' => 'in-valid email']))->setStatusCode(401);
        }
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            
            if (!$student->activated) {
                Auth::logout();
                return json_encode(['status' => 'error', 'msg' => 'You need to confirm your account first. We have sent you activation mail']);
            } else {
                //fcm -
                if ($request->get('fcm_token') != "") {
                    $fcm_token = $request->get('fcm_token');
                    $student_device = StudentDevice::where('fcm_token', $fcm_token)->first();
                    if (!$student_device) {
                        $student_device = new StudentDevice();
                        $student_device->fcm_token = $request->get("fcm_token");
                        $student_device->platform = $request->get("platform");
                    }
                    $student_device->student_id = $student->id; // connecting the device with logged in user for fcm notification
                    $student_device->save();
                }
                // after login,  online_status on
                $student->online_status = 1;
                $student->update();
                
                // broad cast for online
                $channel = "student.status";
                $event = "student.status.event";
                $data = [
                    'student' => new StudentResources($student)
                ];
                CommonHelper::puhser()->trigger('' . $channel, '' . $event, $data);
                
                $authorization = new Authorization($token);
                return new AuthorizationResource($authorization);
            }
        } else {
            return response()->json(['error-msg' => 'wrong password'])->setStatusCode(401);
        }
    }
    
    
    public function username()
    {
        return 'email';
    }
    
    public function logout(Request $request)
    {
        // offline the student
        $student = Auth::user();
        $status = $student->online_status = 0;
        $student->update();
        
        // broad cast for online
        $channel = "student.status";
        $event = "student.status.event";
        $data = [
            'student' => new StudentResources($student)
        ];
        CommonHelper::puhser()->trigger('' . $channel, '' . $event, $data);
        
        Auth::logout();
        return Response::makeFromJson(JsonResponse::create(['online_status' => $status]))->setStatusCode(200);
    }
    
    protected function guard()
    {
        return Auth::guard('api');
    }
    
    
    // social login
    /*public function socialLogin(Request $request){

        $validator = Validator::make($request->all(), [
            'provider' => 'required|in:facebook,twitter,google', // required but only with value of facebook or twitter or google
            'id_token' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $provider = $request->get('provider');
        $idToken = $request->get('id_token');
        $authCode = $request->get('auth_code');
        try{

            $client = new Google_Client([
                'client_id' => config('services.'.$provider.'.client_id'),
                'client_secret' => config('services.'.$provider.'.client_secret')
            ]);
//            if($client->verifyIdToken($idToken)){
                $data = $client->fetchAccessTokenWithAuthCode($authCode);
                if(isset($data['access_token']))
                    $socialUser = Socialite::driver($provider)->scopes(['profile','email'])->userFromToken($data['access_token']);
                else
                    return response()->json(['status'=>'error','error' => $data,'msg' => "Some thing went wrong."]);
//            }else{
//                return response()->json(['status'=>'error','error' => "In-valid id_token",'msg' => "Some thing went wrong."]);
//            }

            //$access_token = Socialite::driver($provider)->getAccessTokenResponse($accessToken);
            //$socialUser =  Socialite::driver($provider)->userFromToken($access_token['access_token']);
            //$socialUser =  Socialite::driver($provider)->userFromToken($idToken);
            //$socialUser = Socialite::driver($accessToken)->user();
        }catch (Exception $exception){
            return response()->json(['status'=>'error','msg' => 'Exp: '.$exception->getMessage()])->setStatusCode(401);
        }
        if($socialUser){
            // get user
            $student = Student::where(['email' => $socialUser->getEmail()])->first();
            if($student){
                // token from user with JWTAuth
                if ($token = JWTAuth::fromUser($student)) {

                    if(!$student->activated){
                        Auth::logout();
                        return json_encode(['status'=> 'error',  'msg' => 'You need to confirm your account first. We have sent you activation mail']);
                    }else{
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

                        // broad cast for online
                        $channel = "student.status";
                        $event = "student.status.event";
                        $data = [
                            'student' => new StudentResources($student)
                        ];

                        try {
                            CommonHelper::puhser()->trigger('' . $channel, '' . $event, $data);
                        } catch (PusherException $e) {}

                        $authorization = new Authorization($token);
                        return new AuthorizationResource($authorization);
                    }
                }else{
                    return response()->json(['error-msg' => 'Some thing went wrong.'])->setStatusCode(401);
                }
            }else{
                return response()->json(['status'=>'error','msg' => 'You are not registered. please register your self first.'])->setStatusCode(401);
            }
        }
        return response()->json(['status'=>'error','msg' => 'Some thing went wrong.'])->setStatusCode(401);
    }*/
    
    public function checkSocialId(Request $request)
    {
        try {
            Student::where($request->only('social_id'))->firstOrFail();
            return response()->json(['message' => true], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => false], 200);
        }
    }
    
    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'             => 'required|string', // first name
            'last_name'        => 'required|string', // last name
            "social_id"        => "required_without:google_social_id",
            "google_social_id" => "required_without:social_id",
            "fcm_token"        => "required",
            "platform"         => "required",
            "provider"         => "required|in:facebook,google",
        ]);
        
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        
        $mobile = $request->get("mobile");
        $email = $request->get("email");
        $social_id = $request->get("social_id");
        
        
        $where = ["email" => $email, "google_social_id" => $social_id];
        
        $socialProvider = $request->get('provider');
        if ($socialProvider == 'facebook') {
            $where = ["social_id" => $social_id];
        }
        
        $student = Student::where($where)->first();
        
        $remaining = [];
        
        if (!$student) {
            $where = ['email' => $email];
            $student = Student::where($where)->first();
            if ($student)
                if ($socialProvider == 'facebook')
                    $student->update(['social_id' => $social_id]);
                else
                    $student->update(['google_social_id' => $social_id]);
            
        }
        
        if (!$student) {
            
            if (!$email) {
                $remaining[] = "email";
            }
            if (!$mobile) {
                $remaining[] = "mobile";
            }
            $student = $this->create($request->all(), $socialProvider);
        }
        
        if ($token = JWTAuth::fromUser($student)) {
            if ($request->get('fcm_token') != "") {
                $fcm_token = $request->get('fcm_token');
                $student_device = StudentDevice::where('fcm_token', $fcm_token)->first();
                if (!$student_device) {
                    $student_device = new StudentDevice();
                }
                $student_device->fcm_token = $request->get("fcm_token");
                $student_device->platform = $request->get("platform");
                $student_device->student_id = $student->id; // connecting the device with logged in user for fcm notification
                $student_device->save();
            }
            // after login,  online_status on
            $student->online_status = 1;
            $student->update();
            
            // broad cast for online
            $channel = "student.status";
            $event = "student.status.event";
            $data = [
                'student' => new StudentResources($student)
            ];
            
            try {
                CommonHelper::puhser()->trigger('' . $channel, '' . $event, $data);
            } catch (PusherException $e) {
            }
            
            $authorization = new Authorization($token, $remaining);
            return new AuthorizationResource($authorization);
        }
        
    }
    
    protected function create(array $data, $provider)
    {
        $studentOption = [
            'name'          => $data['name'], // first name
            'last_name'     => $data['last_name'], // last name
            'password'      => Hash::make(mt_rand()),
            'activated'     => 1,
            'referral_code' => StudentCommonHelper::generateReferralCode($data['name'])
        ];
        if ($provider == 'facebook') {
            $studentOption['social_id'] = $data['social_id'];
        } else {
            $studentOption['google_social_id'] = $data['social_id'];
            
        }
        if (isset($data['mobile'])) {
            $studentOption['mobile'] = $data['mobile'];
        }
        if (isset($data['email'])) {
            $studentOption['email'] = $data['email'];
        }
        $student = Student::create($studentOption);
    
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
        
        return $student;
    }
    
}
