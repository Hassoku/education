<?php

namespace App\Models\Users\Students;

use App\Models\BaseModels\BaseModel;
use App\Models\LearningSessions\LearningSession;
use App\Models\Users\Admin\Admin;

class StudentBalance extends BaseModel
{
    protected $fillable = [
        'type', // individual,grouped -> default => individual

        'student_id',
        'learning_session_id',
        'consumed_slots', 'consumed_amount',
        'remaining_slots', 'remaining_amount',
        'purchased_slots','purchased_amount',
        'moderate_id'
    ];

    /*
    * Define relation for Student balance with  Student
    * */
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
    /*
    * Define relation for Student Balance with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
