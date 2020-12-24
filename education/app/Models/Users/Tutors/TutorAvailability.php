<?php

namespace App\Models\Users\Tutors;

use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;

class TutorAvailability extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tutor_availabilities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        // tutor profile
        'tutor_profile_id',

        // timing
        'start_time',
        'end_time',
        // days
        'SUN',
        'MON',
        'TUE',
        'WED',
        'THU',
        'FRI',
        'SAT',

        // admin
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
     * Define relation for Tutor Availability with Tutor Profile
     */
    public function tutor_profile(){
        return $this->belongsTo(TutorProfile::class,'tutor_profile_id','id');
    }

    /*
    * Define relation for Tutor Availability with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
