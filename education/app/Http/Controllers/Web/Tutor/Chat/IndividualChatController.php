<?php

namespace App\Http\Controllers\Web\Tutor\Chat;


use App\Helpers\LearningSessionCommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Chat\IndividualChat;
use App\Models\Users\Students\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class IndividualChatController extends Controller
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
     * Chat with a specific student
     * */
    public function chat_with_student(Request $request, $student_id){



        // tutor id
        $tutor_id = Auth::id();

        $twilio_student_identity = LearningSessionCommonHelper::generate_twilio_participant_unique_identity('STU', $student_id);
        $twilio_tutor_identity = LearningSessionCommonHelper::generate_twilio_participant_unique_identity('TUT', $tutor_id);

        $chat = IndividualChat::where(['student_id' => $student_id, 'tutor_id' => $tutor_id])->first();
        if(!$chat){
            // if not than create a new one
            $chat_channel_unique_name = LearningSessionCommonHelper::create_twilio_chat_channel_unique_name($twilio_tutor_identity);
            $chat_channel_friendly_name = LearningSessionCommonHelper::create_twilio_chat_channel_friendly_name('TUT' . $tutor_id . '-STU' . $student_id);
            // channel
            $chat_channel = LearningSessionCommonHelper::create_twilio_chat_channel($chat_channel_unique_name, $chat_channel_friendly_name);
            $chat_channel_sid = $chat_channel->sid;
            $chat_channel_url = $chat_channel->url;
            $chat_channel_type = $chat_channel->type;

/*            // join
            LearningSessionCommonHelper::add_member_to_twilio_chat_channel($chat_channel_sid, $twilio_tutor_identity); // tutor
            LearningSessionCommonHelper::add_member_to_twilio_chat_channel($chat_channel_sid, $twilio_student_identity); // student*/

            // create new
            $chat = IndividualChat::create([
                'student_id' => $student_id,
                'twilio_student_identity' => $twilio_student_identity,
                'tutor_id' => $tutor_id,
                'twilio_tutor_identity' => $twilio_tutor_identity,
                'twilio_chat_channel_unique_name' => $chat_channel_unique_name,
                'twilio_chat_channel_friendly_name' => $chat_channel_friendly_name,
                'twilio_chat_channel_sid' => $chat_channel_sid,
                'twilio_chat_channel_url' => $chat_channel_url,
                'twilio_chat_channel_type' => $chat_channel_type,
                //'twilio_chat_channel_member_count',
                //'twilio_chat_channel_msg_count',

            ]);
        }else{
            // else get the old one
            $chat_channel_unique_name = $chat->twilio_chat_channel_unique_name;
            $chat_channel_friendly_name = $chat->twilio_chat_channel_friendly_name;
            $chat_channel_sid = $chat->twilio_chat_channel_sid;
            $chat_channel_url = $chat->twilio_chat_channel_url;
            $chat_channel_type = $chat->twilio_chat_channel_type;
        }



        $chatCollection = IndividualChat::where(['tutor_id' => $tutor_id])->get();

        return view('tutor.individual-chat',[
            'student' => $chat->student,
            'chatCollection' => $chatCollection,
            'twilio_chat_access' => json_decode($this->chatToken($request), true),
            'twilio_chat_channel_sid' => $chat_channel_sid,
            'twilio_chat_channel_unique_name' => $chat_channel_unique_name,
            'twilio_chat_channel_friendly_name' => $chat_channel_friendly_name
        ]);
    }

    /// chat token
    public function chatToken(Request $request){
        return json_encode(LearningSessionCommonHelper::generate_twilio_chat_token($request));
    }
}