<?php

namespace App\Http\Controllers\Web\Student;


use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Student as StudentResources;
use App\Models\Topic;
use App\Models\Users\Country;
use App\Models\Users\State;
use App\Models\EventModel;
use App\Models\Users\Tutors\Tutor;
use App\Models\Users\Tutors\TutorProfile;
use App\Models\Users\Tutors\TutorSpecialization;
use App\Models\Users\Tutors\TutorAvailability;
use App\Models\Users\Students\StudentAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Acaronlex\LaravelCalendar\Event;
use Acaronlex\LaravelCalendar\Src\Facedes\Calendar;
class DashboardController extends Controller
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
    

    public function index(Request $request){

      $tutorsCollections = Tutor::where(['status' => 'active'])->take(3)->get();
      $student = Auth::user();
      $learningSessionReservationCollection = $student->learning_session_reservations;

        return view('student.dashboard',['tutorsCollections' => $tutorsCollections,'learningSessionReservationCollection' => $learningSessionReservationCollection] );
        return redirect(route('student.dashboard.page',['p_code' => 'tpc']));

    }
    
// Profile Update
    public function update(Request $request){
        $city = request()->get('city');
        $country = request()->get('country');
        $grade = request()->get('grade');
        $subject = request()->get('subject');
        $hobbies = request()->get('hobbies');
        $school = request()->get('school');
        $student_profile = Auth::user();
        $student_profile->city = $city;
        $student_profile->country = $country;
        $student_profile->grade = $grade;
        $student_profile->subject = $subject;
        $student_profile->hobbies = $hobbies;
        $student_profile->school = $school;
        $student_profile->update();

        
        return redirect()->route('student.dashboard');


    }
    public function autocomplete(Request $request){

        $search = $request->search;


        if($search == ''){
  
           $autocomplete = Topic::orderby('topic','asc')->select('id','topic')->limit(5)->get();
  
        }else{
  
           $autocomplete = Topic::orderby('topic','asc')->select('id','topic')->where('topic', 'like', '%' .$search . '%')->where('status', '=' , 1)->where('parent', '=',0)->limit(5)->get();
  
        }
  
  
        $response = array();
  
        foreach($autocomplete as $autocomplete){
  
           $response[] = array("value"=>$autocomplete->id,"label"=>$autocomplete->topic);
  
        }
  
  
        echo json_encode($response);
  
        exit;
  
    }
    /*
     * Pages: topics, tutors, reservations
     * method: get
     * */
    public function page(Request $request){
        $p_code = $request->get('p_code');
        switch ($p_code){
            // topics
            case 'tpc' :{
                //$topics = Topic::all();

                // active topics only
                $topics = Topic::where('status', '=' , 1)->get();

                /*
                 * - 0 indexed elements are first level elements has no parent
                 * - 1 indexed elements are second level elements has parent(0 indexed elements)
                 * - 2 indexed elements are third level elements has parent(1 indexed elements)
                 * - ...
                 * - .....
                 * - ........
                 * */
                $levelFrequency = [];

                /*
                 * - Child parent relation
                 * - 0 indexed elements has no parent
                 * - 1 indexed elements has parent( 0 indexed)
                 * - 2 indexed elements has parent( 1 indexed)
                 * - 3 indexed elements has parent( 2 indexed)
                 * - ...
                 * - .....
                 * - ........
                 * */
                $parentFrequency = [];
                $parentFrequency[0] = [];

                /*
                 * Id wise topics
                 * */
                $idWiseTopics = [];

                /*
                 * Topic wise tutors
                 * */
                $topicWiseTutors = [];

                foreach ($topics as $topic){

                    // level
                    if( ! isset($levelFrequency[$topic->level]) ){
                        $levelFrequency[$topic->level] = []; // will hold the topic of level
                    }
                    $levelFrequency[$topic->level][] = $topic; // adding topic

                    // child parent relation
                    if(!isset($parentFrequency[$topic->id])){
                        $parentFrequency[$topic->id] = []; // will hold the child topics
                    }
                    $parentFrequency[$topic->parent][] = $topic; // adding topic

                    // id wise topics
                    $idWiseTopics[$topic->id] = $topic;

                    // id wise tutors
                    $topicWiseTutorSpecializations = TutorSpecialization::where(['topic_id' => $topic->id])->get();
                    if(!isset($topicWiseTutors[$topic->id])){
                        $topicWiseTutors[$topic->id] = [];
                    }
                    foreach ($topicWiseTutorSpecializations as $tutorSpecialization){
                        $t =  $tutorSpecialization->tutor_profile->tutor;
                        //  $topicWiseTutors[$topic->id][] = ['tutor' => $tutorSpecialization->tutor_profile->tutor, 'tutor_profile' => $tutorSpecialization->tutor_profile->tutor->profile] ;

                        // if tutor is active
                        if($t->status == 'active')
                            $topicWiseTutors[$topic->id][] = new \App\Http\Resources\Tutor($tutorSpecialization->tutor_profile->tutor);
                    }
                }


                $topicsCollection = new collection(['levelFrequency' => $levelFrequency, 'parentFrequency' => $parentFrequency, 'idWiseTopics' => $idWiseTopics,'topicWiseTutors' => $topicWiseTutors]);
                return view('student.topics',['topicsCollection' => $topicsCollection]);
            } break;

            // tutors
            case 'ttr' :{
                $countries = Country::all();
                $states = State::all();
              
                $tutor_profiles = TutorProfile::get(["education","id"]);
                  // return (new TutorController())->index();
                  $tutorsCollections = Tutor::where(['status' => 'active'])->paginate(10);
                  $tutorsCollections->withPath('?p_code=ttr');
                  return view('student.tutors',['tutorsCollections' => $tutorsCollections],compact('countries', 'states','tutor_profiles'));
            } break;

            // reservations
            case 'rsrv' :{
              
                $student = Auth::user();
                $learningSessionReservationCollection = $student->learning_session_reservations;
                return view('student.reservations',['learningSessionReservationCollection' => $learningSessionReservationCollection]);
            } break;
            
        } 
    }

    public function searchTutor(Request $request)
    {
      
         $country =  $request->get('country');
         $state =  $request->get('state');
         $level =  $request->get('level');

         $tutorSearchCollections = Tutor::  whereHas('profile', function ($query) use ($country,$state,$level) {
         $query->where('country', 'like', "%{$country}%")
                    ->where('state', 'like', "%{$state}%")
                    ->where('education', 'like', "%{$level}%");
                  })->where(['status' => 'active'])->paginate(10);
                  $tutorSearchCollections->withPath('?p_code=ttr');
      $tutor_profiles = TutorProfile::get(["education","id"]);
        // return (new TutorController())->index();
        $tutorsCollections = Tutor::where(['status' => 'active'])->paginate(10);
        $tutorsCollections->withPath('?p_code=ttr');
      
      return view('student.tutors',['tutorsCollections' => $tutorsCollections, 'tutorSearchCollections' => $tutorSearchCollections],compact('tutor_profiles'));
  
   
    }

    public function search(Request $request)
    {
        $search = $request->get('topic');
        
        $topic = Topic::where('topic', 'like', '%' .$search . '%')->where('status', '=' , 1)->get();
        // $topics = Topic::where('topic', 'like' , "%$search%")->get();
        return view('student.dsd', compact('topic'));
    }

    /*
     * Availability check
     * on topnavbar
     * */
    public function availabilityCheck(Request $request){
        $status = $request->get('status');
        $student = Auth::user();
        $student->online_status = ($status == 'true') ? 1 : 0;
        $student->update();

        // broad cast for online
        $channel = "student.status";
        $event = "student.status.event";
        $data = [
            'student' => new StudentResources($student)
        ];
        CommonHelper::puhser()->trigger('' . $channel,''.$event, $data);

        return json_encode(['online_status' => $student->online_status]);
    }

    public function tutorall()
    {
        $tutorsCollections = Tutor::where(['status' => 'active'])->paginate(10);
       
        return view('student.tutors',['tutorsCollections' => $tutorsCollections]);
    }

    ////////////////////////////// THE CALENDAR //////////////////////////////////////

    public function event(){
        $event = \Calendar::event(
            "Valentine's Day", //event title
            true, //full day event?
            '2015-02-14', //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
            '2015-02-14', //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
            1, //optional event ID
            [
                'url' => 'http://full-calendar.io'
            ]
        );
    }

}