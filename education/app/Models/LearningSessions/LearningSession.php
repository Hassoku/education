<?php

namespace App\Models\LearningSessions;

use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Students\Student;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Tutors\Tutor;
use App\Models\Users\Tutors\TutorBalance;

class LearningSession  extends BaseModel
{
    protected $fillable = [

        'type', // individual,grouped -> default => individual

        // commented: cause moved to learning_session_participants_table
        /*        'student_id', 'twilio_student_identity',
                    'tutor_id', 'twilio_tutor_identity',*/

        // video
        'twilio_room_sid', 'twilio_room_type', 'twilio_room_status', 'twilio_room_unique_name', 'twilio_room_duration', 'twilio_room_url',
        // chat
        'twilio_chat_channel_unique_name', 'twilio_chat_channel_friendly_name', 'twilio_chat_channel_sid', 'twilio_chat_channel_url', 'twilio_chat_channel_type', 'twilio_chat_channel_member_count', 'twilio_chat_channel_msg_count',
        'consumed_time', 'consumed_slot', 'consumed_amount',
        'moderate_id',
        'start_time', 'end_time',
        'status',
    ];

    /*
     * Define relation for LearningSession with learning_session_request
     * */
    public function learning_session_request(){
        return $this->hasMany(LearningSessionRequest::class,'learning_session_id','id');
    }

    /*
     * Define relation with LearningSessionParticipant
     * */
    public function participants(){
        return $this->hasMany(LearningSessionParticipant::class,'learning_session_id','id');
    }


    /*
     * Define relation for LearningSession with Service Charges
     * */
    public function service_charge(){
        return $this->hasOne(ServiceCharges::class,'learning_session_id','id');
    }


    // commented: cause moved to learning_session_participants_table
    /**
     * Define relation for Learning Session with Student

    public function student(){

        return $this->belongsTo(Student::class,'student_id','id');
    }
    */

    // commented: cause moved to learning_session_participants_table
    /**
     * Define relation for Learning Session with Tutor

    public function tutor(){
        return $this->belongsTo(Tutor::class,'tutor_id','id')->with('profile');
    }*/

    /**
     * Define relation for Learning Session with Admin
     */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
