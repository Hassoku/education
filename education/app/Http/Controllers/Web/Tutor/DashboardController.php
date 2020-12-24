<?php

namespace App\Http\Controllers\Web\Tutor;


use App\Helpers\CommonHelper;
use App\Helpers\LearningSessionCommonHelper;
use App\Helpers\TutorCommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tutor as TutorResources;
use App\Models\Chat\IndividualChat;
use App\Models\Users\Tutors\TutorBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

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
        $this->middleware('auth:tutor');

        /*
         * Verify tutor is active
         * */
        $this->middleware('verify.tutor.isActive');
    }

    public function index(){
        return view('tutor.dashboard');
    }

    /*
     * Tab clicked and notification and setting
     * on topnavbar
     * work with ajax only
     * */
    public function tab($tab, Request $request){
        switch ($tab){
            case "res":{
                $tutor = Auth::user();
                $tutor_profile = $tutor->profile;

                // tutor availability
                $tutor_availabilities = [];
                    foreach ($tutor_profile->day_wise_weekly_availabilities() as $day => $values){
                        $timings = [];
                        foreach ($values as $value){
                            $timings[] = date('g:i A', strtotime($value->start_time)) . ' - ' . date('g:i A', strtotime($value->end_time));
                        }
                        switch ($day){
                            case "SUN" : { $day = "Sunday"; } break;
                            case "MON" : { $day = "Monday"; } break;
                            case "TUE" : { $day = "Tuesday"; } break;
                            case "WED" : { $day = "Wednesday"; } break;
                            case "THU" : { $day = "Thursday"; } break;
                            case "FRI" : { $day = "Friday"; } break;
                            case "SAT" : { $day = "Saturday"; } break;
                        }
                        $tutor_availabilities[$day] = $timings;
                    }

                // Learning Session Reservations
                $tutor_learning_session_reservations = new Collection();
                $learning_session_reservations = $tutor->learning_session_reservations;

                foreach ($learning_session_reservations as $learning_session_reservation){
               
                    // only active students reservations will be appear
                    if($learning_session_reservation->student->status == 'active'){
                        $student_id = $learning_session_reservation->student_id;
                        $student_name = $learning_session_reservation->student->name;
                        $session_timing = date('g:ia',strtotime($learning_session_reservation->start_time)) .
                            ' - ' . date('g:ia',strtotime($learning_session_reservation->end_time)) .
                            ' ' . date('d M, Y', strtotime($learning_session_reservation->date));/*.
                        ' Now ' . date('g:ia d M, Y', strtotime(Carbon::now('Asia/Karachi')))*/;

                        // calculating remaining time
                        $date_start_time = Carbon::parse($learning_session_reservation->date . ' ' . $learning_session_reservation->start_time, 'Asia/Karachi'); // will change the zone
                        $now = Carbon::now('Asia/Karachi'); // will change the time zone

                        $remaining_days = $date_start_time->diffInDays($now);
                        if($remaining_days <= 0){
                            $remaining_hours = $date_start_time->diffInHours($now);
                            $remaining_minutes =  $date_start_time->diff($now)->format('%I');
                            if($remaining_minutes > 0){
                                $remaining_time = ($remaining_hours > 1) ? $remaining_hours.' Hours' : $remaining_hours.' Hour';
                                $remaining_time .= " And ";
                                $remaining_time .= ($remaining_minutes > 1) ? $remaining_minutes.' Minutes' : $remaining_minutes.' Minute';
                            }else{
                                $remaining_time = ($remaining_hours > 1) ? $remaining_hours.' Hours' : $remaining_hours.' Hour';
                            }
                            if($remaining_hours <= 0){
                                $remaining_minutes = $date_start_time->diffInMinutes($now);
                                $remaining_time = ($remaining_minutes > 1) ? $remaining_minutes.' Minutes' : $remaining_minutes.' Minute';
                            }
                        }else{
                            $remaining_time = ($remaining_days > 1) ?  $remaining_days.' Days' : $remaining_days.' Day';
                        }

                        // topic
                        $topic = $learning_session_reservation->topic->topic;
                        $reserv_id=$learning_session_reservation->id;

                        $tutor_learning_session_reservations[] = ['reserv_id' => $reserv_id, 'topic' => $topic, 'student_id' => $student_id, 'student_name' => $student_name,'session_timing' => $session_timing, 'remaining_time' => $remaining_time.' Remaining'];
                    }
                }

                $page = $request->has('page') ? $request->get('page') : 1;

                // payments
                $tutor_payments = TutorCommonHelper::tutor_payments_calculation($tutor);
                return (String) view('tutor.reservation',
                    [
                        'payments' => $tutor_payments,
                        'tutor_availabilities' => $tutor_availabilities,
                        'calculate_profile' => TutorCommonHelper::calculate_profile(),
                        'tutor_learning_session_reservations' => $this->paginate($tutor_learning_session_reservations, 4, (int) $page, [])->withPath(route('tutor.dashboard') . "#reservations")
                    ]);
                //return (String) view('tutor.reservation');
            }break;
            case "comm":{
                //$chat = IndividualChat::latest()->first();
                $chat = IndividualChat::where(['tutor_id' => Auth::id()])->first();
                if($chat){
                    $twilio_student_identity = $chat->twilio_student_identity;
                    $twilio_tutor_identity = $chat->twilio_tutor_identity;

                    $chat_channel_unique_name = $chat->twilio_chat_channel_unique_name;
                    $chat_channel_friendly_name = $chat->twilio_chat_channel_friendly_name;
                    $chat_channel_sid = $chat->twilio_chat_channel_sid;
                    $chat_channel_url = $chat->twilio_chat_channel_url;
                    $chat_channel_type = $chat->twilio_chat_channel_type;


                    $chatCollection = IndividualChat::where(['tutor_id' => Auth::id()])->get();
                    return (String) view('tutor.communication',[
                        'student' => $chat->student,
                        'chatCollection' => $chatCollection,
                        'twilio_chat_access' => json_decode(json_encode(LearningSessionCommonHelper::generate_twilio_chat_token($request)), true),
                        'twilio_chat_channel_sid' => $chat_channel_sid,
                        'twilio_chat_channel_unique_name' => $chat_channel_unique_name,
                        'twilio_chat_channel_friendly_name' => $chat_channel_friendly_name
                    ]);
                }
            }break;
            case "pay":{
                $tutor = Auth::user();
                $tutor_profile = $tutor->profile;
                // tutor availability
                $tutor_availabilities = [];
                foreach ($tutor_profile->day_wise_weekly_availabilities() as $day => $values){
                    $timings = [];
                    foreach ($values as $value){
                        $timings[] = date('g:i A', strtotime($value->start_time)) . ' - ' . date('g:i A', strtotime($value->end_time));
                    }
                    switch ($day){
                        case "SUN" : { $day = "Sunday"; } break;
                        case "MON" : { $day = "Monday"; } break;
                        case "TUE" : { $day = "Tuesday"; } break;
                        case "WED" : { $day = "Wednesday"; } break;
                        case "THU" : { $day = "Thursday"; } break;
                        case "FRI" : { $day = "Friday"; } break;
                        case "SAT" : { $day = "Saturday"; } break;
                    }
                    $tutor_availabilities[$day] = $timings;
                }

                // payments
                $tutor_payments = TutorCommonHelper::tutor_payments_calculation($tutor);

                //
                $earningCollection = $tutor->tutor_earning_transactions;
                $withdrawCollection = $tutor->tutor_withdraw_transactions;

                $page = $request->has('page') ? $request->get('page') : 1;

                $currentTabsArray = ['pending', 'received'];
                if(empty($request->input('tab')) || !in_array($request->input('tab'), $currentTabsArray)){
                    $selectedTab = 'pending';
                }else{
                    $selectedTab = $request->input('tab');
                }

                return (String) view('tutor.payment',[
                    'payments' => $tutor_payments,
                    'tutor_availabilities' => $tutor_availabilities,
                    'selectedTab' => $selectedTab,
                    'earningCollection' => $this->paginate($earningCollection, 4, (int) $page, [])->withPath(route('tutor.dashboard') . "#payments"),
                    'withdrawCollection' => $this->paginate($withdrawCollection, 4, (int) $page, [])->withPath(route('tutor.dashboard') . "#payments"),
                ]);
            }break;
            case "ntf":{
                $tutor = Auth::user();
                $tutor_profile = $tutor->profile;

                // tutor availability
                $tutor_availabilities = [];
                foreach ($tutor_profile->day_wise_weekly_availabilities() as $day => $values){
                    $timings = [];
                    foreach ($values as $value){
                        $timings[] = date('g:i A', strtotime($value->start_time)) . ' - ' . date('g:i A', strtotime($value->end_time));
                    }
                    switch ($day){
                        case "SUN" : { $day = "Sunday"; } break;
                        case "MON" : { $day = "Monday"; } break;
                        case "TUE" : { $day = "Tuesday"; } break;
                        case "WED" : { $day = "Wednesday"; } break;
                        case "THU" : { $day = "Thursday"; } break;
                        case "FRI" : { $day = "Friday"; } break;
                        case "SAT" : { $day = "Saturday"; } break;
                    }
                    $tutor_availabilities[$day] = $timings;
                }

                // payments
                $tutor_payments = TutorCommonHelper::tutor_payments_calculation($tutor);
                return (String) view('tutor.notifications',[
                    'payments' => $tutor_payments,
                    'tutor_availabilities' => $tutor_availabilities,
                ]);
            }break;
/*
 *      Note: This code is moved to SettingController
 *             case "stng-act":{
                $tutor = Auth::user();
                $name = ['first_name' => $tutor->name, 'middle_name' => $tutor->middle_name, 'last_name' => $tutor->last_name];
                $mobile = $tutor->mobile;
                $email = $tutor->email;
                return (String) view('tutor.settings-account', ['name' => $name, 'mobile' => $mobile, 'email' => $email]);
            }break;
            case "pref":{
                return (String) view('tutor.preferences');
            }break;
            case "act-dtls":{
                $tutor = Auth::user();
                $name = ['first_name' => $tutor->name, 'middle_name' => $tutor->middle_name, 'last_name' => $tutor->last_name];
                $mobile = $tutor->mobile;
                $email = $tutor->email;
                return (String) view('tutor.account-details',['name' => $name, 'mobile' => $mobile, 'email' => $email]);
            }break;*/
        }
    }
    public function approve($id){
        
        $lsr =    LearningSessionRequest::findOrFail($id);
        $lsr->status = 1; //Approved
        $lsr->save();
        return redirect()->back(); //Redirect user somewhere
     }
     
     public function decline($id){
        $lsr =    LearningSessionRequest::findOrFail($id);
        $lsr->status = 0; //Approved
        $lsr->save();
        return redirect()->back(); //Redirect user somewhere
     }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /*
     * Availability check
     * on topnavbar
     * */
    public function availabilityCheck(Request $request){
        $status = $request->get('status');
        $tutor = Auth::user();
        $tutor->online_status = ($status == 'true') ? 1 : 0;
        $tutor->update();

        // broad cast for online
        $channel = "tutor.status";
        $event = "tutor.status.event";
        $data = [
            'tutor' => new TutorResources($tutor)
        ];
        CommonHelper::puhser()->trigger('' . $channel,''.$event, $data);
        return json_encode(['online_status' => $tutor->online_status]);
    }
    
    /*
     * Busy check
     * on topnavbar
     * */
    public function busyCheck(){
        $tutor = Auth::user();
        $tutor->isBusy = false;
        $tutor->update();
        
        // broad cast for online
        $channel = "tutor.status";
        $event = "tutor.status.event";
        $data = [
            'tutor' => new TutorResources($tutor)
        ];
        CommonHelper::puhser()->trigger('' . $channel,''.$event, $data);
        return json_encode(['online_status' => $tutor->online_status]);
    }
}
