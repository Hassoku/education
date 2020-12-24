<?php

namespace App\Models\LearningSessions;

use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Students\Student;
use App\Models\Users\Tutors\Tutor;


class LearningSessionRequest extends BaseModel
{
    protected $fillable = [

        'type', // individual,grouped -> default => individual

        'learning_session_id',
        'twilio_room_unique_name',
        'student_id','tutor_id',
        'accepted','request_status',
        'moderate_id'
    ];

    /*
     * Define relation for LearningSessionRequest with learning_session, student, tutor
     * */
    public function learning_session(){
        return $this->belongsTo(LearningSession::class,'learning_session_id','id');
    }

    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }

    public function tutor(){
        return $this->belongsTo(Tutor::class,'tutor_id','id');
    }

    /**
     * Define relation for Learning Session Request with Admin
     */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
