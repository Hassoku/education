<?php

namespace App\Http\Controllers\Api\V1\LearningSession;

use App\Helpers\CommonHelper;
use App\Helpers\LearningSessionCommonHelper;
use App\Http\Controllers\Api\V1\BaseController;
use App\Models\LearningSessions\LearningSession;
use App\Models\LearningSessions\LearningSessionRequest;
use App\Models\Users\Students\Student;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Tutors\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningSessionRequestController extends BaseController
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
        $this->middleware('auth:api');

        /*
         * Verify student is active
         * */
        $this->middleware('verify.student.isActive');
    }

    /*
     * Generate Learning Session Request
     * By student
     * */
    public function generate(Request $request){

        // for grouped call
        $type = ($request->input('type'))?$request->input('type'):'individual';
        if($type == 'individual'){
            //////////////////////////////////////////////////////////////////////////
            /// checking student has slots or not

            // return the last row of StudentBalances of the current students
            $studentBalance_last_entry = StudentBalance::where([['student_id', '=' ,Auth::user()->id],['type' , '=', 'individual']])->get()->last();

            //////////////////////////////////////////////////////////////////////////
            if($studentBalance_last_entry){
                if($studentBalance_last_entry->remaining_slots > 0){
                    $learning_session_request =  LearningSessionRequest::create([
                        // by default type is individual
                        'twilio_room_unique_name' => LearningSessionCommonHelper::generate_twilio_room_unique_name($request),
                        'tutor_id' => $request->get('tutor_id'),
                        'student_id' => Auth::user()->id,//$request->get('student_id'),
                        'request_status' => true
                    ]);
                    $learning_session_request_id = $learning_session_request->id;
                    return $this->send($request, $learning_session_request_id);
                }else{
                    return ["msg" => "Please buy minutes first", "status"=>"error"];
                }
            }
            else{
                return ["msg" => "Please buy minutes first", "status"=>"error"];
            }
        }elseif ($type == 'grouped'){
            return ['status' => 'error', 'msg' => 'cant make grouped call yet'];
        }
    }


    /*
     * Send request to tutor
     * response: send, chat['token', 'identity']
     * */
    public function send(Request $request, $learning_session_request_id){
        $learning_session_request = LearningSessionRequest::find($learning_session_request_id);
        $tutor_id = $learning_session_request->tutor_id;
        $tutor = Tutor::find($tutor_id);
        if($tutor->online_status == 1){

            // check whether : tutor isBusy or not
            if(!$tutor->isBusy){

                // changing tutor !isBusy to isBusy
                $tutor = Tutor::find($learning_session_request->tutor_id);
                $tutor->isBusy = true;
                $tutor->save();

                /// send alert to tutor
                $channel = "tutor.learning_session.request.".$tutor_id;
                $event = "learning_session.request.event";
                $data = [
                    'student_name' => Student::find($learning_session_request->student_id)->name,
                    'learning_session_request_id' => $learning_session_request_id
                ];
                CommonHelper::puhser()->trigger('' . $channel,''.$event, $data);
                return ['status' => 'success', 'request' => 'send',
                    'chat' => LearningSessionCommonHelper::generate_twilio_chat_token($request)];
            }elseif($tutor->isBusy){
                return ['status'=> 'error', 'isBusy' => 0,'msg' => 'Tutor is busy at the moment.'];
            }
        }elseif ($tutor->online_status == 0){
            return ['status'=> 'error', 'online_status' => 0, 'msg' => 'tutor is not available yet'];
        }
    }

    /*
     * Withdraw
     * GET
     * */
    public function withdraw($learning_session_request_id){
        $learning_session_request = LearningSessionRequest::find($learning_session_request_id);
        $learning_session_request->request_status = false;
        $learning_session_request->update();

        // changing tutor isBusy to !isBusy
        $tutor = Tutor::find($learning_session_request->tutor_id);
        $tutor->isBusy = false;
        $tutor->save();

        /// send alert to tutor
        /// informing tutor that call user withdrew the session request
        $tutor_id = $learning_session_request->tutor_id;
        $channel = "tutor.learning_session.request.".$tutor_id;
        $event = "learning_session.request.event.withdraw";
        $data = [
            'learning_session_request_id' => $learning_session_request_id
        ];
        CommonHelper::puhser()->trigger('' . $channel,''.$event, $data);
        return json_encode(['msg' => 'request withdrew']);
    }
}