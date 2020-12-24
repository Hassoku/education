<?php

namespace App\Models\LearningSessions;


use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Students\Student;
use App\Models\Users\Tutors\Tutor;

class LearningSessionParticipant extends BaseModel
{
    protected $fillable = [
        'learning_session_id',
        'type', // 'individual','grouped' => default => 'individual'
        'student_id', 'twilio_student_identity',
        'tutor_id', 'twilio_tutor_identity',
        'moderate_id'
    ];

    /*
     * Define relation for LearningSessionParticipant with learning_session, student, tutor
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
