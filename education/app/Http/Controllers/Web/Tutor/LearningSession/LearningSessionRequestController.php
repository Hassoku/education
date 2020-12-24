<?php

namespace App\Http\Controllers\Web\Tutor\LearningSession;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\LearningSessions\LearningSessionRequest;
use App\Models\Users\Students\Student;
use App\Models\Users\Tutors\Tutor;
use Illuminate\Http\Request;

class LearningSessionRequestController extends Controller
{
    /*
     * response of learning session request by tutor
     * */
    public function response(Request $request){
        $learning_session_request_id = $request->get('learning_session_request_id');
        $learning_session_request_status = $request->get('learning_session_request_status') == 'true' ? true : false;
        $learning_session_request = LearningSessionRequest::find($learning_session_request_id);
        $learning_session_request->request_status = ($learning_session_request_status==true)? 1 : 0;
        $learning_session_request->update();

        if($learning_session_request_status === true){
            /*return redirect()->route('tutor.learning.session.create',[
                'learning_session_request_id' => $learning_session_request_id
            ]);*/
            return redirect()->action('Web\Tutor\LearningSession\LearningSessionController@createLearningSession',[
                'learning_session_request_id' => $learning_session_request_id
            ]);
        }else
            if($learning_session_request_status === false){
//            $learning_session_request = LearningSessionRequest::find($learning_session_request_id);
            $learning_session_request->accepted = false;
            $learning_session_request->request_status = false;
            $learning_session_request->update();

            // tutor isBusy to !isBusy
            $tutor = Tutor::find($learning_session_request->tutor_id);
            $tutor->isBusy = false;
            $tutor->save();

            /// informing student that the call has been rejected
                $student_id = $learning_session_request->student_id;
                $student = Student::find($student_id);
                if($student->online_status == 1){
                    /// send alert to student
                    $channel = "student.learning_session.".$student_id;
                    $event = "learning_session.event.reject";
                    $data = [
                        'msg' => 'session request rejected'
                    ];
                    CommonHelper::puhser()->trigger('' . $channel,''.$event, $data);
                }
                return json_encode(['msg' => 'you reject the session request']);
        }
    }
}