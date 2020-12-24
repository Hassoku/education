<?php
namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Models\LearningSessions\LearningSession;
use App\Models\SubscriptionPackage;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Students\StudentSubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
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

    /*
     * index
     * */
    public function index(){
        $subscription_packages = SubscriptionPackage::all();
        $individual = [];
        $grouped = [];
        foreach ($subscription_packages as $subscription_package){
            if($subscription_package->type == 'individual'){
                $individual[] = $subscription_package;
            }
            if($subscription_package->type == 'group'){
                $grouped[] = $subscription_package;
            }
        }
        return view('student.subscription',[
            'individualPackages' => $individual,
            'groupedPackages' => $grouped
        ]);
    }

    /*
     * Minutes
     * Packages
     * */
    public function packages(){
        $subscription_packages = SubscriptionPackage::all();
        $individual = [];
        $grouped = [];
        foreach ($subscription_packages as $subscription_package){
            if($subscription_package->type == 'individual'){
                $individual[] = $subscription_package;
            }
            if($subscription_package->type == 'group'){
                $grouped[] = $subscription_package;
            }
        }
        return ['status' => 'success', 'packages' => ['individual' => $individual, 'grouped' => $grouped]];
    }

    /*
     * Buy package
     * */
    public function buy_package(Request $request, $subscription_package_id){
        //$subscription_package_id = $request->get("subscription_package_id");
        //////////////////////////////////////////////////////////////////////////////////////////////////////
//        $student_id = Auth::id(); // student_id
//        $student_subscription_package = StudentSubscriptionPackage::create([
//            'student_id' => $student_id,
//            'subscription_package_id' => $subscription_package_id,
//            'active' => true,
//        ]);
//
//        $subscription_package = SubscriptionPackage::find($subscription_package_id);
//        // individual,group
//        $type = $subscription_package->type;
//        // individual
//        if($type == 'individual'){
//            $minutes = $subscription_package->minutes;
//            $price = $subscription_package->price;
//
//            // convert in slots
//            $slots = $minutes * 4; // 15 secs of a slot
//
//            // getting old student balances
//            $studentBalance_last_entry = StudentBalance::where(['student_id' => $student_id])->get()->last();
//            if($studentBalance_last_entry){
//
//                // if learningSession_id == 0 it means the last transaction was a purchasing transaction
//                // if it's not 0 it means it is a transaction with a learning session
//                // now check the learning session status is on or off, if it's on means user is buying minutes during call, if it's not, means it a new purchase transaction
//                /*
//                 * => Purchase Transaction
//                 *      - let learning_session_id, consumed_slots, consumed_amount = 0
//                 * => Purchase During Call
//                 *      - check last entry has learning_session_id and its not 0
//                 *      - it it's not 0, than get the LearningSession and check the status of LearningSession
//                 * */
//
//                // get learning session id
//                $learningSession_id = $studentBalance_last_entry->learning_session_id;
//
//                if($learningSession_id != 0){
//                    $learningSession = LearningSession::find($learningSession_id);
//                    if($learningSession->status == true){
//                        // just change the last entry
//                        $studentBalance_last_entry->remaining_slots += $slots;
//                        $studentBalance_last_entry->remaining_amount += $price;
//                        $studentBalance_last_entry->purchased_slots = $slots;
//                        $studentBalance_last_entry->purchased_amount =  $price;
//                        $studentBalance_last_entry->update();
//
//                        //
//                        return ['status' => 'success','type' => 'individual', 'msg' => 'Minutes successfully purchased','remaining_minutes' => floor($studentBalance_last_entry->remaining_slots / 4), 'remaining_slots' => $studentBalance_last_entry->remaining_slots];
//                    }else{
//                        // create a new one
//                        $studentBalance = StudentBalance::create([
//                            'student_id' => $student_id,
//                            'remaining_slots' => $studentBalance_last_entry->remaining_slots + $slots,
//                            'remaining_amount' => $studentBalance_last_entry->remaining_amount + $price,
//                            'purchased_slots' => $slots ,
//                            'purchased_amount'=> $price,
//                        ]);
//
//                        return ['status' => 'success','type' => 'individual', 'msg' => 'Minutes successfully purchased','remaining_minutes' => floor($studentBalance->remaining_slots / 4), 'remaining_slots' => $studentBalance->remaining_slots];
//                    }
//                }else{
//                    // last entry is also a purchased entry
//                    // create a new one
//                    $studentBalance = StudentBalance::create([
//                        'student_id' => $student_id,
//                        'remaining_slots' => $studentBalance_last_entry->remaining_slots + $slots,
//                        'remaining_amount' => $studentBalance_last_entry->remaining_amount + $price,
//                        'purchased_slots' => $slots ,
//                        'purchased_amount'=> $price,
//                    ]);
//                    return ['status' => 'success','type' => 'individual', 'msg' => 'Minutes successfully purchased','remaining_minutes' => floor($studentBalance->remaining_slots / 4), 'remaining_slots' => $studentBalance->remaining_slots];
//                }
//            }else{
//                // very first entry of the user
//                // create a new one
//                $studentBalance = StudentBalance::create([
//                    'student_id' => $student_id,
//                    'remaining_slots' => $slots,
//                    'remaining_amount' =>  $price,
//                    'purchased_slots' => $slots ,
//                    'purchased_amount'=> $price,
//                ]);
//                return ['status' => 'success','type' => 'individual', 'msg' => 'Minutes successfully purchased','remaining_minutes' => floor($studentBalance->remaining_slots / 4), 'remaining_slots' => $studentBalance->remaining_slots];
//            }
//        }else{
//            // group
//            if($type == 'group') {
//                return ['status' => 'error','type' => 'group', 'msg' => 'Minutes purchase unsuccessful'];
//            }
//        }
//        return ['status' => 'error', 'msg' => 'Minutes purchase unsuccessful'];
        ///////////////////////////////////////////////////////////////////////////////////////////////////////

        return redirect()->route('student.payment',['subscription_package_id' => $subscription_package_id]);
    }

    /*
     * Remaining Minutes
     * request: get
     * */
    public function remaining_minutes(){
        $student_id = Auth::id(); // student_id
        $studentBalance_last_entry_for_individual = StudentBalance::where([['student_id' ,'=', $student_id],['type','=','individual']])->get()->last();
        $studentBalance_last_entry_for_grouped = StudentBalance::where([['student_id' ,'=', $student_id],['type','=','grouped']])->get()->last();
        // calculating remaining minutes from remaining slots
        $remaining_individual_minutes = ($studentBalance_last_entry_for_individual) ?  floor($studentBalance_last_entry_for_individual->remaining_slots / 4) : 0;
        $remaining_grouped_minutes = ($studentBalance_last_entry_for_grouped) ? floor($studentBalance_last_entry_for_grouped->remaining_slots / 4) : 0;

        return ['status' => 'success', 'group' => $remaining_grouped_minutes, 'individual' => $remaining_individual_minutes];
    }
}
