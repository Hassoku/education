<?php
namespace App\Http\Controllers\Api\V1\Fcm;


use App\Http\Controllers\Api\V1\BaseController;
use App\Models\Users\Students\StudentDevice;
use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class FcmController extends BaseController
{
    /*
     * Single Notification
     * */
    public function sendNotification(Request $request){

    }

    /*
     *  Notifications to All
     * */
    public function sendNotifications(Request $request){
        $title = $request->get('title');
        $text = $request->get('text');
        $data = $request->get('data');

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

        $tokens = $this->all_fcm_tokens();
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
        $deletedTokens = $this->deleteTokens($tokensToDelete);

        $resp = [
            'numberSuccess' => $numberSuccess,
            'numberFailure' => $numberFailure,
            'numberModification' => $numberModification,
            'tokensToDelete' => $tokensToDelete,
            'tokensToModify' => $tokensToModify,
            'tokensToRetry' => $tokensToRetry,
            'tokensWithError' => $tokensWithError,
            'deletedTokens' => $deletedTokens
        ];
        return Response::makeFromJson(
            JsonResponse::create(['fcm_response' => $resp]))->statusCode(200);
    }
    // return the all fcm_tokens
    public function all_fcm_tokens(){
        $student_devices = StudentDevice::all();
        $fcm_tokens= array();
        foreach ($student_devices as $student_device){
            $fcm_tokens[] = $student_device->fcm_token;
        }
        return $fcm_tokens;
    }
    public function deleteTokens($tokens){
        foreach ($tokens as $token){
            StudentDevice::where('fcm_token', $token)->delete();
        }
        return ['Success'=>'success fully removed!', 'removed token' => $tokens];
    }
}