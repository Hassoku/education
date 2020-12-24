<?php

namespace App\Helpers;


use App\Models\Users\Students\StudentDevice;
use App\Models\Users\Students\StudentNotifyTA;
use App\Models\Users\Tutors\Tutor;
use Camroncade\Timezone\Facades\Timezone;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class TutorCommonHelper
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
                $refcode .= ''. rand(4,1000);
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

    // profile unique video name
    public static function profile_video_name(){
        $current_timestamp = Carbon::now()->timestamp; // timestamp 1495062127
        return Auth::id() . ''.str_random(7) . '' . $current_timestamp;
    }

    // calculate profile completion percentage
    public static function calculate_profile()
    {
        $tutor = Auth::user();
        $profile = $tutor->profile;
        if ( ! $profile) {
            return 0;
        }
        $columns   = preg_grep('/(.+ed_at)|(.*id)/', array_keys($profile->toArray()), PREG_GREP_INVERT);
        $per_column = 100 / count($columns);
        $total      = 0;
        foreach ($profile->toArray() as $key => $value) {
            if ($value !== NULL && $value !== [] && in_array($key, $columns)) {
                $total += $per_column;
            }
        }
        return $total;
    }

    /*
     * Tutor payment calculation:
     * used: reservation, payments, notifications, profile, settings
     * return: array[received_amount, pending_amount]
     * */
    public static function tutor_payments_calculation($tutor){
//        $withdraw_amount = $tutor->tutor_balance->last()->withdraw_amount;
//        $earning_amount = $tutor->tutor_balance->last()->earning_amount;

        $earning =  $tutor->sumOf_earning_transactions[0]->earning;
        $withdraw = $tutor->someOf_withdraw_transactions[0]->withdraw;
        $withdraw_amount = ($withdraw) ? $withdraw : 0;
        $pending_amount = $earning - $withdraw;


        return [
            "received_amount" => $withdraw_amount, "pending_amount" => $pending_amount
        ];
    }

    // preferences
    public static function preferences()
    {
        $tutor = Auth::user();
        $tutorPreferences = $tutor->preferences;

        $selected = $tutorPreferences->timezone;
        $placeholder = 'Select a timezone';
        $formAttributes = array('class' => 'form-control', 'name' => 'timezone');
        $optionAttributes = array('customValue' => 'true');
        $timeZoneSelect = Timezone::selectForm($selected, $placeholder, $formAttributes, $optionAttributes);

        return ['preferences' => $tutorPreferences, 'timeZoneSelect' => $timeZoneSelect];
    }

    // fcm push notification
    /*
     * at availability of tutor : notify the students
     * FCM notifications for mobile devices only
     * */
    public static function sendFCMNotifications($tutor_id){

        $tutor = Tutor::find($tutor_id);
        $tutor_name = $tutor->name . " " . $tutor->last_name;

        $title = "Duroos Notification ";
        $text = $tutor_name . " is available now";
        $data = $tutor_name . " is available now.";

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder(''.$title);
        $notificationBuilder->setBody($text)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $data]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $tokens = TutorCommonHelper::all_fcm_tokens($tutor_id);
        if(count($tokens) > 0){
            $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

            $numberSuccess= $downstreamResponse->numberSuccess();
            $numberFailure = $downstreamResponse->numberFailure();
            $numberModification = $downstreamResponse->numberModification();

            //return Array - you must remove all this tokens in your database
            $tokensToDelete = $downstreamResponse->tokensToDelete();
            //return Array (key : oldToken, value : new token - you must change the token in your database )
            $tokensToModify = $downstreamResponse->tokensToModify();
            //return Array - you should try to resend the message to the tokens in the array
            $tokensToRetry = $downstreamResponse->tokensToRetry();
            // return Array (key:token, value:errror) - in production you should remove from your database the tokens present in this array
            $tokensWithError = $downstreamResponse->tokensWithError();

            // deleting the $tokensToDelete
            //$deletedTokens = deleteTokens($tokensToDelete);

            $resp = [
                'numberSuccess' => $numberSuccess,
                'numberFailure' => $numberFailure,
                'numberModification' => $numberModification,
                'tokensToDelete' => $tokensToDelete,
                'tokensToModify' => $tokensToModify,
                'tokensToRetry' => $tokensToRetry,
                'tokensWithError' => $tokensWithError,
                //'deletedTokens' => $deletedTokens
            ];
            return json_encode(['status' => 'success', 'fcm_response' => $resp]);
        }else{
            return json_encode(['status' => 'error', 'msg' => 'no students']);
        }
    }
    // return the all fcm_tokens
    public static function all_fcm_tokens($tutor_id){
        $dataCollection = StudentNotifyTA::where('tutor_id', $tutor_id)->get();
        $student_ids = collect();
        foreach ($dataCollection as $data){
            $student_ids[] = $data->student_id;
        }

        $student_devices = StudentDevice::whereIN('student_id', $student_ids)->get();
        $fcm_tokens= array();
        foreach ($student_devices as $student_device){
            $fcm_tokens[] = $student_device->fcm_token;
        }


/*        $fcm_tokens = StudentDevice::whereIn('student_id', $student_ids)->lists('fcm_token');*/
        return $fcm_tokens;
    }
}