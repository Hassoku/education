<?php

namespace App\Models\LearningSessions;

use App\Models\BaseModels\BaseModel;
use App\Models\Topic;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Students\Student;
use App\Models\Users\Tutors\Tutor;
use Carbon\Carbon;

class LearningSessionReservation extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'learning_session_reservations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'tutor_id',
        'topic_id',
        'date',
        'duration',
        'start_time',
        'end_time',
        'status',
        'moderate_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /*
     * Format the date while retrieving from database
     * */
    public function getDateAttribute( $value ) {
       return (new Carbon($value))->format('Y-m-d');
    }

    /*
     * Format the start_time while retrieving from database
     * */
    public function getStartTimeAttribute( $value ) {
        return (new Carbon($value))->format('g:i A');
    }

    /*
     * Format the end_time while retrieving from database
     * */
    public function getEndTimeAttribute( $value ) {
        return (new Carbon($value))->format('g:i A');
    }


    /*
     * Define relation for Learning Session Reservation with Student
     * */
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }

    /*
     * Define relation for Learning Session Reservation with  Tutor
     * */
    public function tutor(){
        return $this->belongsTo(Tutor::class,'tutor_id','id');
    }
    /*
     * Define relation for Learning Session Reservation with  Topic
     * */
    public function topic(){
        return $this->belongsTo(Topic::class,'topic_id','id');
    }

    /*
    * Define relation for Learning Session Reservation with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
