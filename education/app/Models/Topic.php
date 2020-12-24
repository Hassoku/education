<?php

namespace App\Models;

use App\Http\Resources\LearningSessionReservation;
use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Tutors\TutorSpecialization;

class Topic extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'topics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'topic',
        'description',
        'parent',
        'level',
        'status',
        'delete',
        'moderate_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'moderate_id'
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
     * Define relation for Topic with tutor specialization
     *
     * **/
    public function tutor_specialization()
    {
        return $this->hasMany(TutorSpecialization::class, 'topic_id', 'id');
    }

    /*
     * Define relation for Topic with Learning Session Reservation
     *
     * **/
    public function learning_session_reservations()
    {
        return $this->hasMany(LearningSessionReservation::class, 'tutor_id', 'id');
    }

    /*
    * Define relation for Tutoring Style with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
