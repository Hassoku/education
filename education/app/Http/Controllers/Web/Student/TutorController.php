<?php

namespace App\Http\Controllers\Web\Student;


use App\Helpers\ReservationCommonHelper;
use App\Helpers\StudentCommonHelper;
use App\Http\Controllers\Controller;
use App\Models\LearningSessions\LearningSessionReservation;
use App\Models\ReportTutor;
use App\Models\Users\Students\StudentNotifyTA;

use App\Models\Users\Tutors\Tutor;
use App\Http\Resources\Tutor as TutorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;

class TutorController extends Controller
{
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
     * Called from: DashBoardController@page
     * p_code: ttr
     * */
    public function index(){

        $countries = Country::all();
        $states = State::all();
        $tutorsCollections = Tutor::where(['status' => 'active']);
        // $tutorsCollections->withPath('?p_code=ttr');
        return view('student.tutors',['tutorsCollections' => $tutorsCollections]);
    }

    /*
     * Tutor Profile Show
     * */
    public function showTutorProfile($tutor_id){
        $tutor = Tutor::find($tutor_id);
        $tutor_profile = $tutor->profile;
        $tutor_rating = $tutor_profile->rating();

        $tutor_first_name = $tutor->name; // first name
        $tutor_middle_name = $tutor->middle_name; // middle name
        $tutor_last_name = $tutor->last_name; // last name
        $tutor_name  = $tutor_first_name . ' ';
        $tutor_name .= (($tutor_middle_name != null) ? $tutor_middle_name : '') . ' ';
        $tutor_name .= $tutor_last_name;

        $tutor_profile_pic = $tutor_profile->picture;
        $tutor_post = $tutor_profile->tutor_post;
        $tutor_intro = $tutor_profile->tutor_intro;
        $tutor_profile_video = $tutor_profile->video;
        $tutor_specializations = $tutor_profile->tutor_specializations;
        $tutor_languages = $tutor_profile->tutor_languages;
        $tutor_tutoring_styles = $tutor_profile->tutor_tutoring_styles;
        $tutor_interests = $tutor_profile->tutor_interests;
        $tutor_certifications = $tutor_profile->tutor_certifications;
        $tutor_education = $tutor_profile->education;
        $tutor_availabilities = $tutor_profile->tutor_availabilities;

        // notifiable:
        $notifiable = StudentNotifyTA::where([
            ['student_id' ,'=',Auth::id()],
            ['tutor_id' ,'=',$tutor_id],
        ])->first();

        return view('student.tutorProfile',[
            'tutor' => $tutor,
            'tutor_profile_pic'=> $tutor_profile_pic,
            'tutor_profile_video' => $tutor_profile_video,
            'tutor_rating' => $tutor_rating,
            'tutor_name' => $tutor_name,
            'tutor_post' => $tutor_post,
            'tutor_intro' => $tutor_intro,
            'tutor_specializations' => $tutor_specializations,
            'tutor_languages' => $tutor_languages,
            'tutor_tutoring_styles' => $tutor_tutoring_styles,
            'tutor_interests' => $tutor_interests,
            'tutor_certifications' => $tutor_certifications,
            'tutor_education' => $tutor_education,
            'tutor_availabilities' => $tutor_availabilities,
            'notifiable' => ($notifiable) ? true : false,
        ]);
    }

    /*
     * Learning Session request
     * */
    public function learningSessionRequest($tutor_id){
        $tutor = Tutor::find($tutor_id);
        return view('student.dialScreen',['tutor' => $tutor]);
    }

    /*
     * Ajax all list of all tutors
     * */
    public function listAllTutors(){
//        $tutors = Tutor::all();
        $tutors = Tutor::where(['status' => 'active'])->get();
        return ['tutors' => TutorResource::collection($tutors)];
    }

    /*
     * Get tutor Availabilities Available slots - 10:00 AM - 10:15 AM
     * method: post
     * param: tutor_id, duration, date
     * */
    public function get_availabilities_available_slots(Request $request){

        $tutor_id = $request->get('tutor_id');
        $duration = $request->get('duration');
        $date = $request->get('date');

        // calculate tutor availabilities available slots
        return ReservationCommonHelper::calculate_tutor_availabilities_available_slots($tutor_id, $date, $duration);
    }

    /*
     * Reserve a learning session
     * */
    public function reserve_for_learning_session(Request $request){

/*        $validator = Validator::make($request->all(), [
            'tutor_id' => 'required',
            'topic_id' => 'required',
            'duration' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }*/

        $tutor_id = $request->get('tutor_id');
        $topic_id = $request->get('topic_id');
        $duration = $request->get('duration');
        $date = $request->get('date');
        $start_time = $request->get('start_time'); // from
        $end_time = $request->get('end_time'); // to

        $list = LearningSessionReservation::where([
            'date' => $date,
            'start_time' => Carbon::parse($start_time)->format('H:i:s')  ,
            'status' => true
        ])->get();

        if($list->count() > 0){
            return [
                'status' => 'error',
                'msg' => 'Duplication not allowed - Session Reservation Failed'
            ];
        }

        // entry in data base
        $lr_reservation = LearningSessionReservation::create([
            'student_id' => Auth::id(),
            'tutor_id' => $tutor_id,
            'topic_id' => $topic_id,
            'date' => $date,
            'duration' => $duration,
            'start_time' => Carbon::parse($start_time)->format('H:i:s'),
            'end_time' => Carbon::parse($end_time)->format('H:i:s'),
        ]);

        return [
            'status' => 'success',
            'msg' => 'session success fully reserved',
            'detail' => $lr_reservation
        ];
    }

    /*
     * Delete Learning Session Reservation
     * */
    public function delete_learning_session_reservation(Request $request){

/*        $validator = Validator::make($request->all(), [
            'learning_session_reservation_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }*/

        $learning_session_reservation_id = $request->get('learning_session_reservation_id');
        $lsr = LearningSessionReservation::find($learning_session_reservation_id);
        $lsr->delete();

        return ['status' => 'success','msg' => 'Reservation success fully delete.'];
    }

    /*
     * Ajax:
     * report tutor
     * */
    public function reportTutor(Request $request){

        // validate data
        /*$validator = Validator::make($request->all(), [
            'tutor_id' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return json_encode(['status' => 'error', 'msg' => 'please provide valid data']);
        }*/

        // get data from request
        $tutor_id = $request->get('tutor_id');
        $description = $request->get('description');
        $student_id = Auth::id();

        // create ReportTutor
        $reportTutor = ReportTutor::create([
            'tutor_id' => $tutor_id,
            'student_id' => $student_id,
            'description' => $description
        ]);

        return json_encode(['status' => 'success', 'msg' => 'reported successfully.']);
    }

    /*
     * Ajax:
     * notify student: at tutor's availability : add
     *  */
    public function addNotifyStudentTA(Request $request){
        // get data from request
        $tutor_id = $request->get('tutor_id');
        $student_id = Auth::id();

        // create
        $studentNotifyTa =  StudentNotifyTA::create([
            'tutor_id' => $tutor_id,
            'student_id' => $student_id
        ]);

        return json_encode(['status' => 'success', 'msg' => 'successfully added.']);
    }
    /*
     * Ajax:
     * notify student: at tutor's availability : delete
     *  */
    public function deleteNotifyStudentTA(Request $request){
        // get data from request
        $tutor_id = $request->get('tutor_id');
        $student_id = Auth::id();

        StudentNotifyTA::where([
            ['student_id' ,'=',$student_id],
            ['tutor_id' ,'=',$tutor_id],
        ])->delete();

        return json_encode(['status' => 'success', 'msg' => 'successfully deleted.']);
    }
}