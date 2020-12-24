<?php

namespace App\Helpers;

use App\Models\LearningSessions\LearningSessionReservation;
use App\Models\Users\Tutors\Tutor;


class ReservationCommonHelper
{
    /*
     * will find the Tutor's Availabilities Available Slots
     * param: tutor_id, date, duration
     * return:
     * */
    public static function calculate_tutor_availabilities_available_slots($tutor_id, $date, $duration){

        $possible_slots_output = [];
        $possible_slots_output_dummy = [];
        $available_slots = [];

        // get tutor availabilities- from DB
        $tutor = Tutor::find($tutor_id);
        $tutor_profile = $tutor->profile;

        // all_availabilities_slots_on_date
        $all_slots = $tutor_profile->all_availabilities_slots_on_date($date, 15); // default internal calculation 15 duration

        // if all slots are 0; means tutor is not available on that day/ date
        if($all_slots == 0){
            return [
                'status' => 'error',
                'msg' => 'Tutor is not available on ' . date('d-m-Y', strtotime($date))
            ];
        }

        $possible_slots = $tutor_profile->all_availabilities_slots_on_date($date, $duration);

        // formatting output ('from' : '1:00 PM' to 'to' : '1:30 PM' .... )
        if(count($possible_slots) > 0){
            // making start and end pair regarding provided duration
            $last_index = count($possible_slots);
            $i = 0;
            foreach ($possible_slots as $possible_slot){
                $from = date('g:i A', strtotime($possible_slot['slot']));

                $to = date('g:i A', strtotime($possible_slot['slot'] . '+'.$duration.' minutes'));

                // last slots add manually
                if(++$i === $last_index){
                    if($to <= date('g:i A', strtotime($all_slots[count($all_slots)-1]['slot'] . '+15 minutes'))){
                        $possible_slots_output[] = ["from" => $from, "to" => $to];
                    }else{
//                        return ['msg'=>'at last else','to' => $to,'last' => date('g:i A', strtotime($all_slots[count($all_slots)-1]['slot'] . '+15 minutes')),'Available Slots' => $output];
                       // return ['Possible Slots' => $possible_slots_output];
                    }
                }else{
                    $possible_slots_output[] = ["from" => $from, "to" => $to];
                }
            }
        }

        foreach ($possible_slots_output as $test){
            $possible_slots_output_dummy[] = $test;
        }

        // get all (status = true) learning session reservation entries of tutor
        $tutor_active_learningSessionReservations = LearningSessionReservation::where([
            'tutor_id' => $tutor->id,
            'status' => true
        ])->orderBy("start_time")->get();


        foreach ($tutor_active_learningSessionReservations as $tutor_active_learningSessionReservation){
            $t_a_lsR_date = $tutor_active_learningSessionReservation->date;
            $t_a_lsR_duration = $tutor_active_learningSessionReservation->duration;
            $t_a_lsR_start_time = $tutor_active_learningSessionReservation->start_time;
            $t_a_lsR_end_time = $tutor_active_learningSessionReservation->end_time;

            // success_items
            // rejected_items
            for ($i = 0; $i < count($possible_slots_output); ++$i ){
                $possible_slot = $possible_slots_output[$i];
                    // compare date, must be same
                    if($t_a_lsR_date == $date){


                        if(date('H:i:s', strtotime($possible_slot['from'])) <= date('H:i:s', strtotime($t_a_lsR_start_time))) {
                            if(date('H:i:s', strtotime($possible_slot['to'])) == date('H:i:s', strtotime($t_a_lsR_end_time))){
                                //array_splice($possible_slots_output_dummy, $i, 1);
                                if (($key = array_search($possible_slot, $possible_slots_output_dummy)) !== false) {
                                    unset($possible_slots_output_dummy[$key]);
                                }
                            }
                            if(date('H:i:s', strtotime($possible_slot['to'])) > date('H:i:s', strtotime($t_a_lsR_start_time)) && date('H:i:s', strtotime($possible_slot['to'])) < date('H:i:s', strtotime($t_a_lsR_end_time))){
                                //array_splice($possible_slots_output_dummy, $i, 1);
                                if (($key = array_search($possible_slot, $possible_slots_output_dummy)) !== false) {
                                    unset($possible_slots_output_dummy[$key]);
                                }
                            }
                            if(date('H:i:s', strtotime($possible_slot['to'])) > date('H:i:s', strtotime($t_a_lsR_end_time))){
                                //array_splice($possible_slots_output_dummy, $i, 1);
                                if (($key = array_search($possible_slot, $possible_slots_output_dummy)) !== false) {
                                    unset($possible_slots_output_dummy[$key]);
                                }
                            }
                        }

                        if(date('H:i:s', strtotime($possible_slot['from'])) > date('H:i:s', strtotime($t_a_lsR_start_time))) {
                            if(date('H:i:s', strtotime($possible_slot['to'])) == date('H:i:s', strtotime($t_a_lsR_end_time))){
                                //array_splice($possible_slots_output_dummy, $i, 1);
                                if (($key = array_search($possible_slot, $possible_slots_output_dummy)) !== false) {
                                    unset($possible_slots_output_dummy[$key]);
                                }
                            }
                            if(date('H:i:s', strtotime($possible_slot['to'])) < date('H:i:s', strtotime($t_a_lsR_end_time))){
                                //array_splice($possible_slots_output_dummy, $i, 1);
                                if (($key = array_search($possible_slot, $possible_slots_output_dummy)) !== false) {
                                    unset($possible_slots_output_dummy[$key]);
                                }
                            }
                            if(date('H:i:s', strtotime($possible_slot['from'])) < date('H:i:s', strtotime($t_a_lsR_end_time)) && date('H:i:s', strtotime($possible_slot['to'])) > date('H:i:s', strtotime($t_a_lsR_end_time))){
                                //array_splice($possible_slots_output_dummy, $i, 1);
                                if (($key = array_search($possible_slot, $possible_slots_output_dummy)) !== false) {
                                    unset($possible_slots_output_dummy[$key]);
                                }
                            }
                        }




                    }
                //
            }
        }
            foreach ($possible_slots_output_dummy as $key => $value){
                $available_slots[] = $value;
            }
        return [
            'status' => 'success',
//            'available_slots' => $possible_slots_output_dummy,
            'available_slots' => $available_slots,
//            'count' => count($possible_slots_output),
  //          'list' => $tutor_active_learningSessionReservations
         ];
    }

    /*
     * find DateInterval
     * param: duration
     * return: PT15M, PT30M ....
     * */
    public static function find_interval_spec($duration){
        switch ($duration){
            case 15 : {
                return 'PT15M';
            } break;
            case 30 : {
                return 'PT30M';
            } break;
            case 45 : {
                return 'PT45M';
            } break;
            case 60 : {
                return 'PT60M';
            } break;
            default : {
                return 'PT10M';
            } break;
        }
    }
}