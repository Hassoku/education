<?php

namespace App\Helpers;

use App\Models\SubscriptionPackage;
use App\Models\Users\Students\StudentBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentCommonHelper
{
    /*
        User ID: 8a829418636e7ff10163826b3c7331b0
        Password: 72hqKS89ZE
        Entity ID  : 8a829418636e7ff10163826b74eb31b4
        PaymentType: DB

        Payment Methods: VISA, MASTER

        Also you need to add the following parameters in the POST request (step number.1 in the guide):
        - testMode=EXTERNAL
        - merchantTransactionId="your unique ID in your database"
        - customer.email = The user's email.
        Testing Cards:
        4005550000000001 05/21 cvv2 123  (Success).
        5204730000002514 05/22 cvv2 251  (Fail).
     */

    /////////////////////////////// COPYandPAY  /////////////////////////

    /*
     * testing check out request
     * */
    public static function checkOutRequest_COPYandPay(Request $request){
        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "authentication.userId=8a829418636e7ff10163826b3c7331b0" .
            "&authentication.password=72hqKS89ZE" .
            "&authentication.entityId=8a829418636e7ff10163826b74eb31b4" .
            "&amount=10.00" .
//            "&currency=EUR" .
            "&currency=SAR" . // Saudi Arab Riyal
             "&paymentType=DB".
            "&testMode=EXTERNAL" .
            "&merchantTransactionId='".$request->get('merchantTransactionId')."'" .
            "&customer.email='".$request->get('customer_email')."'";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // from api
        if(Auth::guard('api')->check()){
            return $responseData;
        }

        // from student
        if(Auth::guard('api')->check()){
            return $responseData;
        }
    }

    /*
     * testing check out request
     * */
    public static function checkOutRequest($subscription_package_id){
        ////////////////////////////////////////
        $subscription_package = SubscriptionPackage::find($subscription_package_id);
            $minutes = $subscription_package->minutes;
            $price = $subscription_package->price;
            $type = $subscription_package->type; // individual,group
        ////////////////////////////////////////
        $url = "https://test.oppwa.com/v1/checkouts";

        if(Auth::guard('student')->check()){
            $data = "authentication.userId=8a829418636e7ff10163826b3c7331b0" .
                "&authentication.password=72hqKS89ZE" .
                "&authentication.entityId=8a829418636e7ff10163826b74eb31b4" .
//            "&amount=10.00" .
                "&amount=". $price .
//            "&currency=EUR" .
                "&currency=SAR" . // Saudi Arab Riyal
                "&paymentType=DB".
                "&testMode=EXTERNAL" .
                "&merchantTransactionId='".(StudentBalance::/*where('student_id', Auth::id())->get()*/all()->last())->id."'" .
                "&customer.email='".Auth::user()->email."'";

        }
        else{
            if(Auth::guard('api')->check()){
                $data = "authentication.userId=8a829418636e7ff10163826b3c7331b0" .
                    "&authentication.password=72hqKS89ZE" .
                    "&authentication.entityId=8a829418636e7ff10163826b74eb31b4" .
//            "&amount=10.00" .
                    "&amount=". $price .
//            "&currency=EUR" .
                    "&currency=SAR" . // Saudi Arab Riyal
                    "&paymentType=DB".
//                    "&shopperResultUrl=http://192.168.1.6:8080/duroosapp/public/api/payment/shopper".
                    "&shopperResultUrl=solidorigins://callback".
                    "&notificationUrl=http://192.168.1.6:8080/duroosapp/public/api/payment/notify";

            }
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // from api
        if(Auth::guard('api')->check()){
            $checkoutId = json_decode($responseData,true)['id'];
//            return redirect()->route('api.checkout',['checkoutId' => $checkoutId,'subscription_package_id' => $subscription_package_id]);
            return $checkoutId;
        }

        // from student
        if(Auth::guard('student')->check()){
            $checkoutId = json_decode($responseData,true)['id'];
            return redirect()->route('student.checkout',['checkoutId' => $checkoutId,'subscription_package_id' => $subscription_package_id]);
        }
    }

    /*
     * des: get payment status
     * method: POST
     * param(s): checkoutId
     * */
    public static function getPaymentStatus_COPYandPay(Request $request){
        $url = "https://test.oppwa.com/v1/checkouts/".$request->get('checkoutId')."/payment";
        $url .= "?authentication.userId=8a829418636e7ff10163826b3c7331b0";
        $url .= "&authentication.password=72hqKS89ZE";
        $url .= "&authentication.entityId=8a829418636e7ff10163826b74eb31b4";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
    }

    public static function getPaymentStatus($checkoutId){
        $url = "https://test.oppwa.com/v1/checkouts/".$checkoutId."/payment";
        $url .= "?authentication.userId=8a829418636e7ff10163826b3c7331b0";
        $url .= "&authentication.password=72hqKS89ZE";
        $url .= "&authentication.entityId=8a829418636e7ff10163826b74eb31b4";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
    }


}