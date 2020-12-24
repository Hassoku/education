<?php

namespace App\Http\Controllers\Web\Tutor\LearningSession;


use App\Helpers\CommonHelper;
use App\Helpers\LearningSessionCommonHelper;
use App\Helpers\TrackSessionInParallel;
use App\Http\Controllers\Controller;
use App\Jobs\SessionTracker;
use App\Models\LearningSessions\LearningSession;
use App\Models\LearningSessions\LearningSessionParticipant;
use App\Models\LearningSessions\LearningSessionRequest;
use App\Models\Users\Students\Student;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Tutors\Tutor;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Psr\Http\Message\ResponseInterface;

class LearningSessionController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        /*
         * Verify tutor is active
         * */
        $this->middleware('verify.tutor.isActive');
    }
    
    /*
     * index
     * redirect to session
     * */
    public function index(Request $request)
    {
    
    }
    
    
    /*
     * Create a new Learning Session
     * While teacher accept the session request
     * */
    public function createLearningSession(Request $request, $learning_session_request_id)
    {
        $learning_session_request = LearningSessionRequest::find($learning_session_request_id);
        
        // off the request status with accepted true
        $room_unique_name = $learning_session_request->twilio_room_unique_name;
        $learning_session_request->accepted = true;
        $learning_session_request->request_status = false;
        $learning_session_request->update();
        
        // making tutor isBusy
        $tutor = Tutor::find($learning_session_request->tutor_id);
        $tutor->isBusy = true;
        $tutor->save();
        
        // getting student and tutor id and generating the unique identity for twilio room
        $student_id = $learning_session_request->student_id;
        $twilio_student_identity = LearningSessionCommonHelper::generate_twilio_participant_unique_identity('STU', $student_id);
        $tutor_id = $learning_session_request->tutor_id;
        $twilio_tutor_identity = LearningSessionCommonHelper::generate_twilio_participant_unique_identity('TUT', $tutor_id);
        
        // create twilio room
        $twilio_room = LearningSessionCommonHelper::create_twilio_video_room($room_unique_name);
        
        // create twilio chat channel
        
        // check either student and teacher as already have session than the old chat channel will be continued other wise will be created new one.
        
        // commented: cause of grouped session, participants table is separated now.
        //$oldLearningSession = LearningSession::where(['student_id' => $student_id, 'tutor_id' => $tutor_id])->first();
        $oldLearningSession = LearningSessionParticipant::where(['student_id' => $student_id, 'tutor_id' => $tutor_id, 'type' => 'individual'])->first(); // for individual only
        
        // commented: cause no need to get old chat channel, we want to separate the chats of all sessions
        /*if(!$oldLearningSession){
            // if not than create a new one
            $chat_channel_unique_name = LearningSessionCommonHelper::create_twilio_chat_channel_unique_name($twilio_tutor_identity);
            $chat_channel_friendly_name = LearningSessionCommonHelper::create_twilio_chat_channel_friendly_name($room_unique_name);
            // channel
            $chat_channel = LearningSessionCommonHelper::create_twilio_chat_channel($chat_channel_unique_name, $chat_channel_friendly_name);
            $chat_channel_sid = $chat_channel->sid;
            $chat_channel_url = $chat_channel->url;
            $chat_channel_type = $chat_channel->type;
        }else{
            // else get the old one
            $chat_channel_unique_name = $oldLearningSession->twilio_chat_channel_unique_name;
            $chat_channel_friendly_name = $oldLearningSession->twilio_chat_channel_friendly_name;
            $chat_channel_sid = $oldLearningSession->twilio_chat_channel_sid;
            $chat_channel_url = $oldLearningSession->twilio_chat_channel_url;
            $chat_channel_type = $oldLearningSession->twilio_chat_channel_type;
        }*/
        
        // create new chat channel for each session
        $chat_channel_unique_name = LearningSessionCommonHelper::create_twilio_chat_channel_unique_name($twilio_tutor_identity);
        $chat_channel_friendly_name = LearningSessionCommonHelper::create_twilio_chat_channel_friendly_name($room_unique_name);
        // channel
        $chat_channel = LearningSessionCommonHelper::create_twilio_chat_channel($chat_channel_unique_name, $chat_channel_friendly_name);
        $chat_channel_sid = $chat_channel->sid;
        $chat_channel_url = $chat_channel->url;
        $chat_channel_type = $chat_channel->type;
        
        
        // create Learning Session b/w tutor and user
        $learningSession = LearningSession::create([
            
            // commented: cause of grouped session, participants table is separated now.
            /*
                'student_id' => $student_id,
                'twilio_student_identity' => $twilio_student_identity,
                'tutor_id' => $tutor_id,
                'twilio_tutor_identity' => $twilio_tutor_identity,
            */
            'twilio_room_sid'                   => $twilio_room->sid,
            'twilio_room_type'                  => $twilio_room->type,
            'twilio_room_status'                => $twilio_room->status,
            'twilio_room_unique_name'           => $twilio_room->uniqueName,
//            'twilio_room_duration',
            'twilio_room_url'                   => $twilio_room->url,
            
            // chat
            'twilio_chat_channel_unique_name'   => $chat_channel_unique_name,
            'twilio_chat_channel_friendly_name' => $chat_channel_friendly_name,
            'twilio_chat_channel_sid'           => $chat_channel_sid,
            'twilio_chat_channel_url'           => $chat_channel_url,
            'twilio_chat_channel_type'          => $chat_channel_type,
//	        'twilio_chat_channel_member_count',
            //           'twilio_chat_channel_msg_count',

//            'consumed_time',
//            'consumed_slot',
//            'consumed_amount',
//            'moderate_id',
//            'start_time',
//            'end_time',
//            'status',
        ]);
        
        // creating participants entry
        // for individual only
        $participants = LearningSessionParticipant::create([
            'learning_session_id'     => $learningSession->id,
            'type'                    => 'individual',
            'student_id'              => $student_id,
            'twilio_student_identity' => $twilio_student_identity,
            'tutor_id'                => $tutor_id,
            'twilio_tutor_identity'   => $twilio_tutor_identity,
        
        ]);
        
        // adding learningSession id to learningSessionRequest
        $learning_session_request->learning_session_id = $learningSession->id;
        $learning_session_request->update();
        
        // sending room data to student by channel
        $student_access_token = LearningSessionCommonHelper::join_twilio_video_room($room_unique_name, $twilio_student_identity);
        $student = Student::find($student_id);
        if ($student->online_status == 1) {
            /// send session data to student
            $channel = "student.learning_session." . $student_id;
            $event = "learning_session.event.accept";
            $data = [
                'twilio_room_sid'                   => $twilio_room->sid,
                'twilio_room_unique_name'           => $twilio_room->uniqueName,
                'access_token'                      => $student_access_token,
                // chat
                'twilio_chat_channel_sid'           => $chat_channel_sid,
                'twilio_chat_channel_unique_name'   => $chat_channel_unique_name,
                'twilio_chat_channel_friendly_name' => $chat_channel_friendly_name
            ];
            CommonHelper::puhser()->trigger('' . $channel, '' . $event, $data);
        }
        
        // responding the tutor , room data to join
        $tutor_access_token = LearningSessionCommonHelper::join_twilio_video_room($room_unique_name, $twilio_tutor_identity);
//        return json_encode(['twilio_room_sid' => $twilio_room->sid, 'twilio_room_unique_name' => $twilio_room->uniqueName, 'access_token' => $tutor_access_token]);
        
        
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///  Student Balance
        
        //$studentBalance_last_entry = StudentBalance::where(['student_id' => $student_id, 'purchased_slots' => 0])->get()->last();
        
        // commented: cause of grouped call
//        $studentBalance_last_entry = StudentBalance::where(['student_id' => $student_id])->get()->last();
        $studentBalance_last_entry = StudentBalance::where(['student_id' => $student_id, 'type' => 'individual'])->get()->last(); // for individual only
        /*$studentBalance_last_entry = StudentBalance::where([
            ['student_id' , '=' , $student_id],
            ['purchased_slots', '=', 0]
        ])->get()->last();*/
        
        if ($studentBalance_last_entry) {
            $studentBalance = StudentBalance::create([
                // by default type is individual
                'student_id'          => $student_id,
                'learning_session_id' => $learningSession->id,
                'remaining_slots'     => $studentBalance_last_entry->remaining_slots,
                'remaining_amount'    => $studentBalance_last_entry->remaining_amount
            ]);
        }
        
        
        // starting artisan command in parallel
        // Artisan::queue("track:learningSession", ['learningSession_id' => $learningSession->id, '--queue' => 'default']);
//        $this->trackSession($learningSession->id);
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        return view('tutor.learningSession.learningSession',
            [
                'learningSession_id'                => $learningSession->id, // for track the session
                'twilio_room_sid'                   => $twilio_room->sid,
                'twilio_room_unique_name'           => $twilio_room->uniqueName,
                'access_token'                      => $tutor_access_token,
                'twilio_chat_channel_sid'           => $chat_channel_sid,
                'twilio_chat_channel_unique_name'   => $chat_channel_unique_name,
                'twilio_chat_channel_friendly_name' => $chat_channel_friendly_name,
            ]);
    }
    
    /*
     * Join a Learning session
     * When new Participant will join the session
     * - For Grouped session
     * */
    public function joinLearningSession(Request $request)
    {
    
    }
    
    /*
     * Complete session
     * */
    public function completeLearningSession(Request $request)
    {
        try {
            $twilio_room_sid = $request->get('twilio_room_sid');
            
            $room = LearningSessionCommonHelper::complete_twilio_video_room($twilio_room_sid);
            
            // changing in db
            $learningSession = LearningSession::where(['twilio_room_sid' => $twilio_room_sid])->first();
            $learningSession->twilio_room_status = $room->status;
            $learningSession->twilio_room_duration = $room->duration;
            $learningSession->status = false;
            
            // chat
            $chat_channel = LearningSessionCommonHelper::retrieve_twilio_chat_channel($learningSession->twilio_chat_channel_sid);
            $learningSession->twilio_chat_channel_member_count = $chat_channel->membersCount;
            $learningSession->twilio_chat_channel_msg_count = $chat_channel->messagesCount;
            
            
            // updating the learning session
            $learningSession->update();
            
            
            // changing tutor isBusy to !isBusy :
            $tutor_id = $learningSession->participants[0]->tutor_id;
            $tutor = Tutor::find($tutor_id);
            $tutor->isBusy = false;
            $tutor->save();
            
            // session service charges
            //LearningSessionCommonHelper::session_service_charges($learningSession->id);
            
            return redirect()->route('tutor.dashboard');
        } catch (\Exception $exception) {
            return redirect()->route('tutor.dashboard');
        }
    }
    
    /// chat token
    public function chatToken(Request $request)
    {
        return json_encode(LearningSessionCommonHelper::generate_twilio_chat_token($request));
    }
    
    // session tracking
    /*    public function trackSession($learningSession_id){*/
    public function trackSession(Request $request)
    {
        set_time_limit(0); // no time out
        
        $learningSession_id = $request->get("learningSession_id");
        
        // get the learningSession
        $learningSession = LearningSession::find($learningSession_id);
        
        // check twilio video room members
        
        
        // check weather learningSession is off then stop the loop - recursions
        if ($learningSession->status == 0) {
            //trigger_error("");
            
            // session service charges
            LearningSessionCommonHelper::session_service_charges($learningSession_id);
            
            return ["msg" => "done the session", 'learningSession_id' => $learningSession_id];
        }
        
        // getting participants
        //$student_id = $learningSession->student_id;
        
        $student_id = $learningSession->participants[0]->student_id; // for individual only
//        $tutor_id = $learningSession->tutor_id;
        
        // getting studentBalance
        
        // commented: cause of grouped session
        //$studentBalance = StudentBalance::where(['student_id' => $student_id])->get()->last(); // get the latest entry of student
        
        $studentBalance = StudentBalance::where(['student_id' => $student_id, 'type' => 'individual'])->get()->last(); // get the latest entry of student
        $remaining_slots = $studentBalance->remaining_slots;
        $remaining_amount = $studentBalance->remaining_amount;
        
        // rate of per slots
        //$rate_per_slot = $remaining_slots / $remaining_amount;
        $rate_per_slot = $remaining_amount / $remaining_slots;
        
        // deducting the 1 slot from remaining slots of student
        $remaining_slots--;
        
        $studentBalance->remaining_slots = $remaining_slots;
        // deducting the 2.5 of amount from remaining amount
        $remaining_amount -= $rate_per_slot; //2.5;
        $studentBalance->remaining_amount = $remaining_amount;
        $studentBalance->update();
        
        // updating consumed slots
        // in learning session
        $learningSession->consumed_slot++;
        $learningSession->consumed_amount += $rate_per_slot;//2.5; // 10 / 4 = 2.5
        $learningSession->update();
        // in student balances
        $studentBalance->consumed_slots++;
        $studentBalance->consumed_amount += $rate_per_slot; //2.5; // 10 / 4 = 2.5
        $studentBalance->update();
        
        
        // pusher notification to student
        /// send session data to student
        $channel = "student.learning_session." . $student_id;
        $event = "learning_session.event.updates";
        $data = [
            "remaining_slots" => $studentBalance->remaining_slots,
            "consumed_slots"  => $learningSession->consumed_slot
        ];
        CommonHelper::puhser()->trigger('' . $channel, '' . $event, $data);
        
        // check whether remaining_slots are 0  then stop the loop - recursions
        if ($remaining_slots <= 0) {
            $twilio_room_sid = $learningSession->twilio_room_sid;
            $room = LearningSessionCommonHelper::complete_twilio_video_room($twilio_room_sid);
            
            // changing in db
            $learningSession = LearningSession::where(['twilio_room_sid' => $twilio_room_sid])->first();
            $learningSession->twilio_room_status = $room->status;
            $learningSession->twilio_room_duration = $room->duration;
            $learningSession->status = false;
            $learningSession->update();
            
            // session service charges
            LearningSessionCommonHelper::session_service_charges($learningSession_id);
            
            return ["msg" => "done the session", 'learningSession_id' => $learningSession_id];
        } else {
            // sleep for every 14-sec
            sleep(14);
            $this->trackSession($request);
        }
    }
    
}