<?php

namespace App\Http\Controllers\Web\Student;


use App\Http\Controllers\Controller;
use App\Models\Users\Students\StudentPreferences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*
         * Authorized users only
         */
        $this->middleware('auth:student');
    }

    public function index(){
        $student = Auth::user();
        $name = ['first_name' => $student->name, 'middle_name' => $student->middle_name, 'last_name' => $student->last_name];
        $mobile = $student->mobile;
        $email = $student->email;
        return view('student.settings', ['name' => $name, 'mobile' => $mobile, 'email' => $email]);
    }

    public function tab($tab, Request $request){
        switch ($tab){
            case "pref":{
                return (String) view('student.preferences');
            }break;
            case "act-dtls":{
                $student = Auth::user();
                $name = ['first_name' => $student->name, 'middle_name' => $student->middle_name, 'last_name' => $student->last_name];
                $mobile = $student->mobile;
                $email = $student->email;
                return (String) view('student.account-details',['name' => $name, 'mobile' => $mobile, 'email' => $email]);
            }break;
        }
    }

    // update preferences
    public function updatePreferences(Request $request){

       $language =  $request->get("language");
       $timezone =  $request->get("timezone");
       $emailNotification = $request->get("emailNotification");
        $desktopNotification =  $request->get("desktopNotification");
        
        $student = Auth::user();
        $studentPreferences =  $student->preferences;
        $studentPreferences->language = $language;
        $studentPreferences->timezone = $timezone;
        $studentPreferences->emailNotification = ($emailNotification == null) ? 0 : 1;
        $studentPreferences->desktopNotification = ($desktopNotification == null) ? 0 : 1;
        $studentPreferences->update();

        return redirect()->route('student.setting',['tab'=>'preferences']);
    }
}