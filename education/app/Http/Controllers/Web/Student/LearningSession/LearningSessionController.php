<?php
namespace App\Http\Controllers\Web\Student\LearningSession;


use App\Helpers\LearningSessionCommonHelper;
use App\Http\Controllers\Controller;
use App\Models\LearningSessions\LearningSession;
use App\Models\Users\Tutors\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Validator;

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
         * Authorized users only
         */
        $this->middleware('auth:student');

        /*
         * Verify student is active
         * */
        $this->middleware('verify.student.isActive');
    }

    /*
     * Join a Learning session
     * */
    public function joinLearningSession(Request $request){

        $twilio_room_sid = $request->get('twilio_room_sid');
        $twilio_room_unique_name = $request->get('twilio_room_unique_name');;
        $access_token = $request->get('access_token');
        // chat
        $twilio_chat_channel_sid = $request->get('twilio_chat_channel_sid');
        $twilio_chat_channel_unique_name = $request->get('twilio_chat_channel_unique_name');
        $twilio_chat_channel_friendly_name = $request->get('twilio_chat_channel_friendly_name');

        return view('student.learningSession.learningSession',
            [
                'twilio_room_sid' => $twilio_room_sid,
                'twilio_room_unique_name' => $twilio_room_unique_name,
                'access_token' => $access_token,
                'twilio_chat_channel_sid' => $twilio_chat_channel_sid,
                'twilio_chat_channel_unique_name' => $twilio_chat_channel_unique_name,
                'twilio_chat_channel_friendly_name' => $twilio_chat_channel_friendly_name,
            ]);
    }

    /*
     * Complete the session
     * */
    public function complete(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'twilio_room_sid' => 'required'
            ]);
            if ($validator->fails()) {
                //
            }
    
            $twilio_room_sid = $request->get('twilio_room_sid');
            // video
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
            // LearningSessionCommonHelper::session_service_charges($learningSession->id);
    
            return redirect(route('student.dashboard'));
        }catch (\Exception $exception){
            return redirect(route('student.dashboard'));
        }
    }

    /// chat token
    public function chatToken(Request $request){
        return json_encode(LearningSessionCommonHelper::generate_twilio_chat_token($request));
    }

    // session archives
    public function sessionArchives(Request $request){
        $student = Auth::user();
        $completed_learning_sessions = $student->learning_session_participants;

        $page = $request->has('page') ? $request->get('page') : 1;
        return view('student.learningSession.sessionArchives',[
            'completed_learning_sessions' => $this->paginate($completed_learning_sessions,10, (int) $page, [])->withPath(route('student.learning.session.archives')),
        ]);
    }
    // session archive
    public function sessionArchive(Request $request, $id){

        $learningSession = LearningSession::find($id);

        // video room
        $recordingsCollection = LearningSessionCommonHelper::get_room_recordings($learningSession);

        // chat
        $twilio_chat_channel_unique_name = $learningSession->twilio_chat_channel_unique_name;
        $twilio_chat_channel_friendly_name = $learningSession->twilio_chat_channel_friendly_name;

        return view('student.learningSession.sessionArchive',[
            'recordingsCollection' => $recordingsCollection,
            'twilio_chat_channel_unique_name' => $twilio_chat_channel_unique_name,
            'twilio_chat_channel_friendly_name' => $twilio_chat_channel_friendly_name,
        ]);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}