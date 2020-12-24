<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\PaymentCommonHelper;
use App\Http\Controllers\Controller;
use App\Models\LearningSessions\LearningSession;
use App\Models\SubscriptionPackage;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Students\StudentSubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
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
        $this->middleware('auth:api')->except(['notify']);

        /*
         * Verify student is active
         * */
        $this->middleware('verify.student.isActive');
    }
    

    /*
     * notify
     *
     *  The resourcePath is a path (starting with /) which is related to the server URL. You must call it to get the information about the notification:
     *      GET https://test.oppwa.com{resourcePath}?authentication.userId={userId}&authentication.password={password}&authentication.entityId={entityId}
     * */
    public function notify(Request $request){
        $id = $request->get('id'); // check out id
        $resourcePath = $request->get('resourcePath'); // check out id

    }


    /*
     * Payment History
     * return the payment history of current user
     * */
    public function paymentHistory(){
        $paymentHistory = Auth::user()->student_balance_payments; // get the current users payments history
        return json_encode(['status' => 'success', 'paymentHistory' => $paymentHistory]);
    }

}