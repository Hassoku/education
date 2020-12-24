<?php

namespace App\Http\Controllers\Web\Student\Chat;


use App\Helpers\LearningSessionCommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Chat\IndividualChat;
use App\Models\Users\Students\Student;
use App\Models\Users\Tutors\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
         * Authorized users only
         */
        $this->middleware('auth:student');

        /*
         * Verify student is active
         * */
        $this->middleware('verify.student.isActive');
    }

    /*
     * chat with individual tutor
     * */
    public function chat_with_tutor(Request $request, $tutor_id){

        // student id
        $student_id = Auth::id();

        $twilio_student_identity = LearningSessionCommonHelper::chat_user_identity('STU', $student_id, Student::find($student_id)->name);
        $twilio_tutor_identity = LearningSessionCommonHelper::chat_user_identity('TUT', $tutor_id, Tutor::find($tutor_id)->name);

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
                'twilio_chat_channel_type' => $chat_channel_type
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

        $chatCollection = IndividualChat::where(['student_id' => $student_id])->get();

        return view('student.communication',[
            'tutor' => $chat->tutor,
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