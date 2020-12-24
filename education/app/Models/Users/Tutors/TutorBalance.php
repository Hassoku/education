<?php

namespace App\Models\Users\Tutors;

use App\Models\LearningSessions\LearningSession;
use App\Models\Users\Admin\Admin;
use Illuminate\Database\Eloquent\Model;

class TutorBalance extends Model
{
    protected $fillable = [
        'tutor_id',
        'learning_session_id',
        'earning_amount',
        'withdraw_amount',
        'type', //['earning','withdraw'] default 'earning'
        'moderate_id'
    ];


    /*
    * Define relation for Tutor balance with  tutor
    * */
    public function tutor(){
        return $this->belongsTo(Tutor::class,'tutor_id','id');
    }
    /*
    * Define relation for Tutor Balance with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
