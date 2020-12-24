<?php

namespace App\Helpers;
use App\Http\Resources\Tutor;
use App\Models\LearningSessions\LearningSession;
use App\Models\LearningSessions\ServiceCharges;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Tutors\TutorBalance;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;
use Twilio\Rest\Notify;

/*constants*/
define('twilio_sid',config('services.twilio.sid'));
define('twilio_token',config('services.twilio.token'));
define('twilio_key',config('services.twilio.key'));
define('twilio_secret',config('services.twilio.secret'));
/* chat service */
define('twilio_chat_service_id', config('services.twilio.chat_service_id'));
class LearningSessionCommonHelper
{
    /*
     * Generate the Unique name for twilio room
     * */
    public static function generate_twilio_room_unique_name(Request $request){
        $tutor_id = $request->get('tutor_id');
        $student_id = Auth::user()->id;//$request->get('student_id');
        $current_timestamp = Carbon::now()->timestamp; // timestamp 1495062127
        $room_unique_name = 'STD'.$student_id . 'TUT' . $tutor_id . '_' . str_random(5) . '' . $current_timestamp;
        return $room_unique_name;
    }

    /*
     * Generate the Unique identity for twilio room
     * STU
     * TUT
     * */
    public static function generate_twilio_participant_unique_identity($participant_slug ,$id){
        $current_timestamp = Carbon::now()->timestamp; // timestamp 1495062127
        $identity = $participant_slug . $id . '_' . str_random(3) . '' . $current_timestamp;
        return $identity;
    }


    /*
     * Create a twilio video room
     * */
    public static function create_twilio_video_room($room_unique_name){
        $client = new Client(twilio_sid, twilio_token);
        $room = $client->video->rooms->read(['uniqueName' => $room_unique_name]);
        if (empty($room)) {
            $room = $client->video->rooms->create([
                'uniqueName' => $room_unique_name,
                'type' => 'group',
                //'type' => 'peer-to-peer',
                'recordParticipantsOnConnect' => false
//                'recordParticipantsOnConnect' => true
            ]);
        }
        return $room;
    }

    /*
     * join a twilio video room
     * return the twilio room access token
     * */
    public static function join_twilio_video_room($room_unique_name, $identity){
        $token = new AccessToken(twilio_sid, twilio_key, twilio_secret, 3600, ''.$identity);
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($room_unique_name);
        $token->addGrant($videoGrant);

        // room access token
        return $token->toJWT();
    }

    /*
     * Complete a twilio video room
     * */
    public static function complete_twilio_video_room($twilio_room_sid){
        $client = new Client(twilio_sid, twilio_token);
        $room = $client->video
            ->rooms("" . $twilio_room_sid)
            ->update("completed");
        return $room;
    }
    public static function completeAllSessions(){
        $sessions = LearningSession::all();
        //where(['twilio_room_status' => 'completed'])->get();
        foreach ($sessions as $session){
                if($session->twilio_room_status != 'completed'){
                    $room = LearningSessionCommonHelper::complete_twilio_video_room($session->twilio_room_sid);

                    // changing in db
                    $session->twilio_room_status = $room->status;
                    $session->twilio_room_duration = $room->duration;
                    $session->status = false;
                    $session->update();
                }
        }

        return json_encode(['msg' => 'all session completed']);
    }

    /*
     * Remove a participant of room
     * getting participant of room and after retrieving updating its status to 'disconnected'
     * */
    public static function remove_participant_from_twilio_video_room($twilio_room_sid, $participant_identity){
        $client = new Client(twilio_sid, twilio_token);
        $participant = $client->video->rooms($twilio_room_sid)->participants($participant_identity)->fetch();
        $participant->update(['status' => 'disconnected']);
    }


    /**
     * Get video room recordings
     *
     * *
     * @param $learningSession
     * @return array
     */
    public static function get_room_recordings($learningSession){

        $twilio_room_sid = $learningSession->twilio_room_sid;

        $client = new Client(twilio_sid, twilio_token);

        $recordingsCollection = collect();
        $roomParticipants = $client->video->rooms($twilio_room_sid)->participants->read();
        foreach ($roomParticipants as $roomParticipant){
            /*
             * identity: on first 3 alphabets on $roomParticipant->identity
             * TUT: tutor
             * STU: student
             * */
            $identity = (substr($roomParticipant->identity,0, 3) == 'TUT') ? 'tutor' : 'student';

            if($identity == 'tutor'){
                $tutor = $learningSession->participants[0]->tutor;
                $name = $tutor->name . ' ' . $tutor->last_name;
            }
            elseif($identity == 'student'){
                $student = $learningSession->participants[0]->student;
                $name = $student->name .' ' . $student->last_name;
            }

            $recordings = $client->video->v1->recordings->read(array( 'roomSid' => $twilio_room_sid, 'groupingSid' => $roomParticipant->sid));
            if(!$recordings){
                return ['error' => 'error', 'msg' => 'No Recordings Available'];
            }

            $media = collect();
            foreach ($recordings as $recording){
                if($recording->type == 'audio'){
                    $media['audio'] = $client->request('GET', $recording->links['media'])->getContent()["redirect_to"];
                }elseif($recording->type == 'video'){
                    $media['video'] = $client->request('GET', $recording->links['media'])->getContent()["redirect_to"];
                }
            }

            $recordingsCollection[$identity] = ['media' => $media, 'name' => $name];
        }

        return $recordingsCollection;
    }

    /////////// twilio chat helper /////////

    /*
     * generate the chat access token
     * - post: device, identity
     * */
    public static function generate_twilio_chat_token(Request $request){

        $appName = "DuroosChatDemo";
        $deviceId = ($request->input("device")) ? $request->input("device") : 'browser'; // browser, android, iOS .. etc
        $user = Auth::user();
            $id = $user->id;
            $name = $user->name;
        //$identity = str_replace(' ', '_', $request->input("identity"));

        // create the unique identity for users on the basis of slugs
        $slug = "";
        if(Auth::guard('api')->check()){
            $slug = "STU";
        }else{
            if(Auth::guard('tutor')->check()){
                $slug = "TUT";
            }else{
                if(Auth::guard('student')->check()){
                    $slug = "STU";
                }
            }
        }
        $identity = str_replace(' ', '_', $name) . '!#'.$id.'_'.$slug;


        // end point
        $endpointId = $appName . ":" . $identity . ":" . $deviceId;

        // setting identity to access token
        $accessToken = new AccessToken(twilio_sid, twilio_key, twilio_secret, 7200);
        $accessToken->setIdentity($identity);

        // chat grant
        $chatGrant = new ChatGrant();
        $chatGrant->setServiceSid(twilio_chat_service_id);
        $chatGrant->setEndpointId($endpointId);
        $chatGrant->setPushCredentialSid("CRb11d094db27e4ebbbf718b4d8d6faba2");

        // add grant to token
        $accessToken->addGrant($chatGrant);
        return ['identity' => $identity, 'token' => $accessToken->toJWT()];
    }

    public static function chat_user_identity($slug, $userID, $userName){
        $id = $userID;
        $name = $userName;
        //$identity = str_replace(' ', '_', $request->input("identity"));

        $identity = str_replace(' ', '_', $name) . '!#'.$id.'_'.$slug;
        return $identity;
    }


    /*
     * tutor unique identity
     * return the channel_unique_name
     * */
    public static function create_twilio_chat_channel_unique_name($tutor_unique_identity){
        $current_timestamp = Carbon::now()->timestamp; // timestamp 1495062127b
        $channel_unique_name = $tutor_unique_identity . '_' . str_random(3) . '' . $current_timestamp;
        return $channel_unique_name;
    }

    /*
     * $room_unique_name
     * return the channel_friendly_name
     * */
    public static function create_twilio_chat_channel_friendly_name($room_unique_name){
        $current_timestamp = Carbon::now()->timestamp; // timestamp 1495062127*/
        $channel_friendly_name = 'Chat-' . $room_unique_name . '-' . $current_timestamp .'Channel';
        return $channel_friendly_name;
    }

    /*
     * create a twilio chat channel
     * return channel
     * */
    public static function  create_twilio_chat_channel($channel_unique_name, $channel_friendly_name){
        $client = new Client(twilio_sid, twilio_token);
        $channel = $client->chat->services(twilio_chat_service_id)
            ->channels->create([
                'friendlyName' => $channel_friendly_name,
                'uniqueName' => $channel_unique_name
            ]);

        return $channel;
    }

    /*
     * Adding member to twilio channel
     * */
    public static function add_member_to_twilio_chat_channel($channel_sid, $member_identity){
        $client = new Client(twilio_sid, twilio_token);

        $member = $client->chat
            ->services(twilio_chat_service_id)
            ->channels($channel_sid)
            ->members
            ->create($member_identity);
        return $member->identity;
    }

    /*
     * retrieve channel
     * */
    public static function retrieve_twilio_chat_channel($chat_channel_sid){
        $client = new Client(twilio_sid, twilio_token);
        $channel = $client->chat->services(twilio_chat_service_id)
            ->channels($chat_channel_sid)
            ->fetch();

        return $channel;
    }


    /*
     * Learning Session Service charges
     * twilio video rooms + chats charges
     *
     * */
    public static function session_service_charges($learningSession_id){

        // get the learningSession
        $learningSession = LearningSession::find($learningSession_id);

        if($learningSession->type == 'individual'){
            $student_id = $learningSession->participants[0]->student_id; // for individual only
            // getting studentBalance
            $studentBalance = StudentBalance::where(['learning_session_id' => $learningSession_id, 'student_id' => $student_id, 'type' => 'individual'])->first();
            // consumed slots
            $sb_consumed_slots = $studentBalance->consumed_slots;
            // if: consumed slots are < 4 mean less than 1 minute: should be consider as 1 minute of that mean 4 slots will be deducted
            if($sb_consumed_slots < 4){
                //let: $sb_consumed_slots 2

                $sb_consumed_slots = 4 - $sb_consumed_slots; // 4 - 2 = 2

                $studentBalance->consumed_slots += $sb_consumed_slots; // adding in consumed slots
                $studentBalance->consumed_amount += (2.5 * $sb_consumed_slots); // adding the amount of adjusted slots in consumed amount
                $studentBalance->remaining_amount -= (2.5 * $sb_consumed_slots); // adjusting remaining amount
                $studentBalance->remaining_slots -= $sb_consumed_slots;// adjusting remaining slots

                //// in learningSession
                $learningSession->consumed_slot += $sb_consumed_slots;// adding in consumed slots
                $learningSession->consumed_amount += (2.5 * $sb_consumed_slots);// adding the amount of adjusted slots in consumed amount

                $studentBalance->update();
                $learningSession->update();
            }else{

                // if: consumed slots are not dividable of 4
                if($sb_consumed_slots % 4 != 0){
                    /*
                    * if: consumed slots are 17 that means 4 minutes and 15 sec we have to set it 5 minutes
                    * let 17 as N
                    *   so: if N / 4 = ANS and ANS % 4 = R > 0 then floor(ANS) = ANS + 1 = ANS.
                    * mean: if 17 / 4 = 4.25 and 4.25 % 4 = .25 > 0 than floor(4.25) = 4 + 1 = 5
                    * let 5 as M
                    *   so: M * 4 = ANS and ANS - N = adjustedSlots
                    * mean: 5 * 4 = 20 and 20 - 17 = 3
                    */
                    $N = ($sb_consumed_slots / 4);
                    $minutes = (($N % 4) > 0) ? floor($N) + 1 : $N;

                    // convert minutes in slots
                    $sb_consumed_slots = ($minutes * 4) - $sb_consumed_slots; // adjusting slots

                    $studentBalance->consumed_slots += $sb_consumed_slots; // adding in consumed slots
                    $studentBalance->consumed_amount += (2.5 * $sb_consumed_slots); // adding the amount of adjusted slots in consumed amount
                    $studentBalance->remaining_amount -= (2.5 * $sb_consumed_slots); // adjusting remaining amount
                    $studentBalance->remaining_slots -= $sb_consumed_slots;// adjusting remaining slots

                    //// in learningSession
                    $learningSession->consumed_slot += $sb_consumed_slots;// adding in consumed slots
                    $learningSession->consumed_amount += (2.5 * $sb_consumed_slots);// adding the amount of adjusted slots in consumed amount

                    $studentBalance->update();
                    $learningSession->update();
                }
            }

            // calculating expenses
            // twilio
            // 1 to 1
            $twilio_call_time = $learningSession->twilio_room_duration; // secs

            // calculating the mins for twilio video call pay calculation
            $video_call_minutes = $twilio_call_time / 60; // secs to minutes
            if($twilio_call_time % 60 != 0){
                $video_call_minutes++;
            }

            // twilio chats
            // $chat_payments;

            $twilio_call_amount = 0.001 * 2 * $video_call_minutes;

            // tutor payments
            // 70% of session consumed amount
            $tutor_payment = (70 / 100) * $learningSession->consumed_amount;

            // amount from student
            $student_deduction = $studentBalance->consumed_amount;

            // service charges
            $service_charges_received = $student_deduction - $tutor_payment;

            ServiceCharges::create([
                'learning_session_id' => $learningSession_id,
                'twilio_call_time' => $twilio_call_time,
                'twilio_call_amount' => $twilio_call_amount,
                'tutor_payment' => $tutor_payment,
                'student_deduction' => $student_deduction,
                'service_charges_received' => $service_charges_received,
            ]);

            // tutor amounts
            $tutor_id = $learningSession->participants[0]->tutor_id; // for individual only
            TutorBalance::create([
                'tutor_id' => $tutor_id,
                'learning_session_id' => $learningSession_id,
                'earning_amount' => $tutor_payment,
            ]);

        }elseif($learningSession->type == 'grouped'){

            $twilio_call_time = $learningSession->twilio_room_duration; // secs

            ServiceCharges::create([
                'learning_session_id' => $learningSession_id,
                'twilio_call_time' => $twilio_call_time,
                'twilio_call_amount' => 0.0,
                'tutor_payment' => 0.0,
                'student_deduction' => 0.0,
                'service_charges_received' => 0.0,
            ]);
        }

        // send invoice [email] to student
        // send invoice [email] to tutor

    }

}