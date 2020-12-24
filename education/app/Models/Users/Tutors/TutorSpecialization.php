<?php

namespace App\Models\Users\Tutors;

use App\Models\BaseModels\BaseModel;
use App\Models\Specialization;
use App\Models\Topic;
use App\Models\Users\Admin\Admin;

class TutorSpecialization extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tutor_specializations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tutor_profile_id',
        //'specialization_id',
        'topic_id',
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
     * Define relation for Tutor Specialization with Tutor Profile
     */
    public function tutor_profile(){
        return $this->belongsTo(TutorProfile::class,'tutor_profile_id','id');
    }

    /**
     * Define relation for Tutor Specialization with specialization
     *
    public function specialization(){
        return $this->belongsTo(Specialization::class,'specialization_id','id');
    }*/

    /**
     * Define relation for Tutor Specialization with topic
     */
    public function topic(){
        return $this->belongsTo(Topic::class,'topic_id','id');
    }


    /*
    * Define relation for Tutor Specialization with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
