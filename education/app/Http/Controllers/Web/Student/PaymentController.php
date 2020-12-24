<?php
namespace App\Http\Controllers\Web\Student;

use App\Helpers\PaymentCommonHelper;
use App\Http\Controllers\Controller;
use App\Models\LearningSessions\LearningSession;
use App\Models\SubscriptionPackage;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Students\StudentSubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
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
        $this->middleware('auth:student');

        /*
         * Verify student is active
         * */
        $this->middleware('verify.student.isActive');
    }

    /*
     * index
     * */
    public function index($subscription_package_id){
        return PaymentCommonHelper::checkOutRequest($subscription_package_id);
    }

    /*
     * checkOut
     * */
    public function checkOut($checkoutId, $subscription_package_id){
        return view('payment.index',['checkoutId' => $checkoutId,'subscription_package_id' => $subscription_package_id]);
    }

    /*
     * details
     * */
    public function details(Request $request, $subscription_package_id){
        $checkoutId = $request->get('id');
        $paymentStatus =  json_decode(PaymentCommonHelper::getPaymentStatus($checkoutId), true);

        // result code for test mode
        $result_code = $paymentStatus['result']['code'];
        if($result_code == '000.100.112'){
            $student_id = Auth::id(); // student_id

            // activating the student subscription package
            $student_subscription_package = StudentSubscriptionPackage::create([
                'student_id' => $student_id,
                'subscription_package_id' => $subscription_package_id,
                'active' => true,
            ]);

            // getting subscription package for adding minutes in student balance
            $subscription_package = SubscriptionPackage::find($subscription_package_id);

            // individual,group
            $type = $subscription_package->type;
            // individual
            if($type == 'individual'){
                $minutes = $subscription_package->minutes;
                $price = $subscription_package->price;

                // convert in slots
                $slots = $minutes * 4; // 15 secs of a slot

                // getting old student balances

                // commented: because adding grouped minutes functionality
                //$studentBalance_last_entry = StudentBalance::where(['student_id' => $student_id])->get()->last();
                $studentBalance_last_entry = StudentBalance::where([['student_id', '=', $student_id],['type' , '=', 'individual']])->get()->last();
                if($studentBalance_last_entry){

                    // if learningSession_id == 0 it means the last transaction was a purchasing transaction
                    // if it's not 0 it means it is a transaction with a learning session
                    // now check the learning session status is on or off, if it's on means user is buying minutes during call, if it's not, means it a new purchase transaction
                    /*
                     * => Purchase Transaction
                     *      - let learning_session_id, consumed_slots, consumed_amount = 0
                     * => Purchase During Call
                     *      - check last entry has learning_session_id and its not 0
                     *      - it it's not 0, than get the LearningSession and check the status of LearningSession
                     * */

                    // get learning session id
                    $learningSession_id = $studentBalance_last_entry->learning_session_id;

                    if($learningSession_id != 0){
                        $learningSession = LearningSession::find($learningSession_id);
                        if($learningSession->status == true){
                            // just change the last entry
                            $studentBalance_last_entry->remaining_slots += $slots;
                            $studentBalance_last_entry->remaining_amount += $price;
                            $studentBalance_last_entry->purchased_slots = $slots;
                            $studentBalance_last_entry->purchased_amount =  $price;
                            $studentBalance_last_entry->update();

                            //
/*                            return ['status' => 'success',
                                'type' => 'individual',
                                'msg' => 'Minutes successfully purchased',
                                'remaining_minutes' => floor($studentBalance_last_entry->remaining_slots / 4),
                                'remaining_slots' => $studentBalance_last_entry->remaining_slots];*/
                           // return $paymentStatus['result']['description'];
                            return $this->redirectToDashboard($paymentStatus['result']['description']);
                        }else{
                            // create a new one
                            $studentBalance = StudentBalance::create([
                                'student_id' => $student_id,
                                'remaining_slots' => $studentBalance_last_entry->remaining_slots + $slots,
                                'remaining_amount' => $studentBalance_last_entry->remaining_amount + $price,
                                'purchased_slots' => $slots ,
                                'purchased_amount'=> $price,
                                // by default type is individual
                            ]);

/*                            return ['status' => 'success',
                                'type' => 'individual',
                                'msg' => 'Minutes successfully purchased',
                                'remaining_minutes' => floor($studentBalance->remaining_slots / 4),
                                'remaining_slots' => $studentBalance->remaining_slots];*/
                            //return $paymentStatus['result']['description'];
                            return $this->redirectToDashboard($paymentStatus['result']['description']);
                        }
                    }else{
                        // last entry is also a purchased entry
                        // create a new one
                        $studentBalance = StudentBalance::create([
                            'student_id' => $student_id,
                            'remaining_slots' => $studentBalance_last_entry->remaining_slots + $slots,
                            'remaining_amount' => $studentBalance_last_entry->remaining_amount + $price,
                            'purchased_slots' => $slots ,
                            'purchased_amount'=> $price,
                            // by default type is individual
                        ]);
/*                        return ['status' => 'success',
                            'type' => 'individual',
                            'msg' => 'Minutes successfully purchased',
                            'remaining_minutes' => floor($studentBalance->remaining_slots / 4),
                            'remaining_slots' => $studentBalance->remaining_slots];*/

                        //return $paymentStatus['result']['description'];
                        return $this->redirectToDashboard($paymentStatus['result']['description']);
                    }
                }else{
                    // very first entry of the user
                    // create a new one
                    $studentBalance = StudentBalance::create([
                        'student_id' => $student_id,
                        'remaining_slots' => $slots,
                        'remaining_amount' =>  $price,
                        'purchased_slots' => $slots ,
                        'purchased_amount'=> $price,
                        // by default type is individual
                    ]);
/*                    return ['status' => 'success',
                        'type' => 'individual',
                        'msg' => 'Minutes successfully purchased',
                        'remaining_minutes' => floor($studentBalance->remaining_slots / 4),
                        'remaining_slots' => $studentBalance->remaining_slots];*/

//                    return $paymentStatus['result']['description'];
                    return $this->redirectToDashboard($paymentStatus['result']['description']);
                }
            }else{
                // group
                if($type == 'group') {
                    $minutes = $subscription_package->minutes;
                    $price = $subscription_package->price;

                    // convert in slots
                    $slots = $minutes * 4; // 15 secs of a slot

                    // getting previous grouped student_balance
                    $studentBalance_last_entry = StudentBalance::where([['student_id', '=', $student_id],['type' , '=', 'grouped']])->get()->last();
                    if($studentBalance_last_entry){

                        // if learningSession_id == 0 it means the last transaction was a purchasing transaction
                        // if it's not 0 it means it is a transaction with a learning session
                        // now check the learning session status is on or off, if it's on means user is buying minutes during call, if it's not, means it a new purchase transaction
                        /*
                         * => Purchase Transaction
                         *      - let learning_session_id, consumed_slots, consumed_amount = 0
                         * => Purchase During Call
                         *      - check last entry has learning_session_id and its not 0
                         *      - it it's not 0, than get the LearningSession and check the status of LearningSession
                         * */

                        // get learning session id
                        $learningSession_id = $studentBalance_last_entry->learning_session_id;

                        if($learningSession_id != 0){
                            $learningSession = LearningSession::find($learningSession_id);
                            if($learningSession->status == true){
                                // just change the last entry
                                $studentBalance_last_entry->remaining_slots += $slots;
                                $studentBalance_last_entry->remaining_amount += $price;
                                $studentBalance_last_entry->purchased_slots = $slots;
                                $studentBalance_last_entry->purchased_amount =  $price;
                                $studentBalance_last_entry->update();

                                //
                                /*                            return ['status' => 'success',
                                                                'type' => 'individual',
                                                                'msg' => 'Minutes successfully purchased',
                                                                'remaining_minutes' => floor($studentBalance_last_entry->remaining_slots / 4),
                                                                'remaining_slots' => $studentBalance_last_entry->remaining_slots];*/
                                // return $paymentStatus['result']['description'];
                                return $this->redirectToDashboard($paymentStatus['result']['description']);
                            }else{
                                // create a new one
                                $studentBalance = StudentBalance::create([
                                    'student_id' => $student_id,
                                    'remaining_slots' => $studentBalance_last_entry->remaining_slots + $slots,
                                    'remaining_amount' => $studentBalance_last_entry->remaining_amount + $price,
                                    'purchased_slots' => $slots ,
                                    'purchased_amount'=> $price,
                                    'type' => 'grouped'
                                ]);

                                /*                            return ['status' => 'success',
                                                                'type' => 'individual',
                                                                'msg' => 'Minutes successfully purchased',
                                                                'remaining_minutes' => floor($studentBalance->remaining_slots / 4),
                                                                'remaining_slots' => $studentBalance->remaining_slots];*/
                                //return $paymentStatus['result']['description'];
                                return $this->redirectToDashboard($paymentStatus['result']['description']);
                            }
                        }else{
                            // last entry is also a purchased entry
                            // create a new one
                            $studentBalance = StudentBalance::create([
                                'student_id' => $student_id,
                                'remaining_slots' => $studentBalance_last_entry->remaining_slots + $slots,
                                'remaining_amount' => $studentBalance_last_entry->remaining_amount + $price,
                                'purchased_slots' => $slots ,
                                'purchased_amount'=> $price,
                                'type' => 'grouped'
                            ]);
                            /*                        return ['status' => 'success',
                                                        'type' => 'individual',
                                                        'msg' => 'Minutes successfully purchased',
                                                        'remaining_minutes' => floor($studentBalance->remaining_slots / 4),
                                                        'remaining_slots' => $studentBalance->remaining_slots];*/

                            //return $paymentStatus['result']['description'];
                            return $this->redirectToDashboard($paymentStatus['result']['description']);
                        }
                    }else{
                        // very first entry of the user
                        // create a new one
                        $studentBalance = StudentBalance::create([
                            'student_id' => $student_id,
                            'remaining_slots' => $slots,
                            'remaining_amount' =>  $price,
                            'purchased_slots' => $slots ,
                            'purchased_amount'=> $price,
                            'type' => 'grouped'
                        ]);
                        return $this->redirectToDashboard($paymentStatus['result']['description']);
                    }
                }
            }
            return $this->redirectToDashboard($paymentStatus['result']['description']);
        }else{
            if($result_code == '200.300.404'){
                return $paymentStatus['result']['description'];
            }
            return $paymentStatus['result'];
        }
    }

    //
    public function redirectToDashboard($msg){

        if(Auth::guard('student')->check()){
            return redirect()->route('student.dashboard.page',['p_code' => 'tpc','msg' => $msg]);
        }else{
            if(Auth::guard('api')->check()){
                return json_encode(['status' => 'success', 'msg' => $msg]);
            }
        }
    }

    /*
     * History
     * */
    public function history(Request $request){
        $student = Auth::user();
        $student_payments = $student->student_balance_payments;

        $page = $request->has('page') ? $request->get('page') : 1;
        return view('student.paymentHistory',[
            'student_payments' => $this->paginate($student_payments,10, (int) $page, [])->withPath(route('student.paymentHistory'))
        ]);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}