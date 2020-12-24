<?php

namespace App\Models\LearningSessions;

use App\Http\Resources\Student;
use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Tutors\Tutor;

class ServiceCharges extends BaseModel
{
    protected $fillable = [
        'learning_session_id',
        'twilio_call_time','twilio_call_amount',
        'tutor_payment', 'student_deduction',
        'service_charges_received',
        'moderate_id'
    ];

    /*
    * Define relation for Service Charges with  Learning Session
    * */
    public function learning_session(){
        return $this->belongsTo(LearningSession::class,'learning_session_id','id');
    }

    /*
    * Define relation for Service Charges with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
