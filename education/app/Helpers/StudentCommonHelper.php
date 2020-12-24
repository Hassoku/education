<?php

namespace App\Helpers;


use Camroncade\Timezone\Facades\Timezone;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class StudentCommonHelper
{
    /*
     * Generate Unique referralCode
     * return string
     * */
    public static function generateReferralCode($student_name){
        $refcode =  (strlen($student_name) > 3 ? substr($student_name, 0, 3) :  $student_name);
        switch (rand(0,5)){
            case 0:{
                $refcode .= '$'. rand(3,1000);
            }break;
            case 1:{
                $refcode .= ''. rand(3,1000);
            }break;
            case 2:{
                $refcode .= '^'. rand(3,1000);
            }break;
            case 3:{
                $refcode .= '%'. rand(3,1000);
            }break;
            case 4:{
                $refcode .= ''. rand(3,1000);
            }break;
            case 5:{
                $refcode .= ''. rand(3,1000);
            }break;
            default:{
                $refcode .= '@'. rand(3,1000);
            }
        }
        switch (rand(0,5)){
            case 0:{
                $refcode .= '@'. rand(2,100);
            }break;
            case 1:{
                $refcode .= '!-'. rand(2,100);
            }break;
            case 2:{
                $refcode .= ')-'. rand(2,100);
            }break;
            case 3:{
                $refcode .= '~)'. rand(2,100);
            }break;
            case 4:{
                $refcode .= '(>'. rand(2,100);
            }break;
            case 5:{
                $refcode .= '*('. rand(3,1000);
            }break;
            default:{
                $refcode .= '<'. rand(2,100);
            }
        }
      return $refcode;
    }

    // profile unique image
    public static function profile_pic_name(){
        $current_timestamp = Carbon::now()->timestamp; // timestamp 1495062127
        return Auth::id() . ''.str_random(5) . '' . $current_timestamp;
    }

    // preferences
    public static function preferences()
    {
        $student = Auth::user();
        $studentPreferences = $student->preferences;

        $selected = $studentPreferences->timezone;
        $placeholder = 'Select a timezone';
        $formAttributes = array('class' => 'form-control', 'name' => 'timezone');
        $optionAttributes = array('customValue' => 'true');
        $timeZoneSelect = Timezone::selectForm($selected, $placeholder, $formAttributes, $optionAttributes);

        return ['preferences' => $studentPreferences, 'timeZoneSelect' => $timeZoneSelect];
    }
}