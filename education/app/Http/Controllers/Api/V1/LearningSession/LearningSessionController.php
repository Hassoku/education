<?php

namespace App\Http\Controllers\Api\V1\LearningSession;

use App\Helpers\LearningSessionCommonHelper;
use App\Http\Controllers\Api\V1\BaseController;
use App\Models\LearningSessions\LearningSession;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Tutors\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\LearningSessions\LearningSessionReservation;
use App\Http\Resources\LearningSessionReservation as LearningSessionReservationResource;

class LearningSessionController extends BaseController
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
   * Complete the session
   * */
  public function complete(Request $request){
      $validator = Validator::make($request->all(), [
          'twilio_room_sid' => 'required'
      ]);
      if ($validator->fails()) {
          return $this->errorBadRequest($validator);
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

      return json_encode(['msg' => 'success ended']);
  }

    /// chat token
    public function chatToken(Request $request){
        return json_encode(LearningSessionCommonHelper::generate_twilio_chat_token($request));
    }


    /////////////////
    /*
 * Student Reserved Sessions List
 * method: get
 * */
    public function get_student_reserved_session_list(){
        $student_id = Auth::id();
        $learningSessionReservations = LearningSessionReservation::where([
            'student_id' => $student_id,
            'status' => true
        ])->orderBy("date")->get();
        return ['status' => 'success', 'reservations' => LearningSessionReservationResource::collection($learningSessionReservations)];
    }

    /*
     * Learning Session History
     * return the session history of current user
     * */
    public function sessionArchives(){
        $student = Auth::user();
        $learningSessionCollection = $student->learning_session_participants;
        //$learningSessionCollection =  Auth::user()->learning_session_completed; // list of all completed sessions of the student
        return json_encode(['status' => 'success', 'learningSessionCollection' => $learningSessionCollection]);
    }

}