<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ReservationCommonHelper;
use App\Http\Resources\Tutor as TutorResource;
use App\Models\LearningSessions\LearningSessionReservation;
use App\Models\ReportTutor;
use App\Models\Users\Students\Student;
use App\Models\Users\Students\StudentFavoriteTutors;
use App\Models\Users\Students\StudentNotifyTA;
use App\Models\Users\Tutors\Tutor;
use App\Models\Users\Tutors\TutorRating;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TutorController extends BaseController
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

    public function index(){
        $tutors = Tutor::where(['status' => 'active'])->paginate(25);
        return json_encode(['status' => 'success','tutors' => TutorResource::collection($tutors)]);
    }

    /*
     * Get tutor Availabilities Available slots - 10:00 AM - 10:15 AM
     * method: post
     * param: tutor_id, duration, date
     * */
    public function get_availabilities_available_slots(Request $request){

        $validator = Validator::make($request->all(), [
            'tutor_id' => 'required',
            'duration' => 'required',
            'date' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

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

        $validator = Validator::make($request->all(), [
            'tutor_id' => 'required',
            'topic_id' => 'required',
            'duration' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

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

        $validator = Validator::make($request->all(), [
            'learning_session_reservation_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $learning_session_reservation_id = $request->get('learning_session_reservation_id');
        $lsr = LearningSessionReservation::find($learning_session_reservation_id);
        $lsr->delete();

        return json_encode(['status' => 'success']);
    }

    /*
     * Tutor Ratings
     * */
    public function rating(Request $request){
        $validator = Validator::make($request->all(), [
            'tutor_id' => 'required',
            'rating' => 'required|integer|min:1|max:5'
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $tutor_id = $request->get('tutor_id');
        $rating = $request->get('rating');

        $tutor_profile_id = Tutor::find($tutor_id)->profile->id;
        $student_id = Auth::id();

        $tutor_rating = TutorRating::create([
            'tutor_profile_id' => $tutor_profile_id,
            'student_id' => $student_id,
            'rating' => $rating
        ]);

        return json_encode(['status' => 'success']);
    }

    /*
     * chat
     * one to one
     * */
    public function chatting(Request $request){
        $tutor_id = $request->get('tutor_id');
        $student_id = Auth::id();
    }

    /*
     * Add to favorite
     * : tutor_id
     *
     * */
    public function addToFav(Request $request){
        $student_id = Auth::id();
        $tutor_id = $request->get('tutor_id');

        $oldOne = StudentFavoriteTutors::where([
            'student_id' => $student_id,
            'tutor_id' => $tutor_id,
        ])->first();

        if($oldOne){
            return json_encode(['status' => 'error', 'msg' => 'Already added to favorite']);
        }

        // adding to fav
        $studentFavoriteTutors = StudentFavoriteTutors::create([
            'student_id' => $student_id,
            'tutor_id' => $tutor_id,
        ]);

        return json_encode(['status' => 'success', 'msg' => 'successfully added to favorite']);
    }

    /*
     * Remove to favorite
     * : tutor id
     * */
    public function removeToFav(Request $request){
        $student_id = Auth::id();
        $tutor_id = $request->get('tutor_id');

        // deleting to fav
        $studentFavoriteTutors = StudentFavoriteTutors::where([
            'student_id' => $student_id,
            'tutor_id' => $tutor_id,
        ])->delete();

        if($studentFavoriteTutors){
            return json_encode(['status' => 'success', 'msg' => 'successfully removed from favorite']);
        }else{
            return json_encode(['status' => 'error', 'msg' => 'record does not exists.']);
        }
    }

    /*
     * Favorite Tutors list
     *
     * */
    public function favTutors(Request $request){
        $student = Auth::user();
        $favoriteTutors = $student->favoriteTutors;
        $tutorCollection = collect();
        foreach ($favoriteTutors as $favoriteTutor){
            $tutorCollection->push(new \App\Http\Resources\Tutor($favoriteTutor->tutor));
        }

        return json_encode(['status' => 'success', 'favoriteTutors' => $tutorCollection]);
    }

    /*
     * report tutor
     * */
    public function reportTutor(Request $request){

        // validate data
        $validator = Validator::make($request->all(), [
            'tutor_id' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

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