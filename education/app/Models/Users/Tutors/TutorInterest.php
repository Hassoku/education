<?php

namespace App\Models\Users\Tutors;


use App\Models\BaseModels\BaseModel;
use App\Models\Interest;
use App\Models\Users\Admin\Admin;

class TutorInterest extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tutor_interests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tutor_profile_id',
        'interest_id',
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
     * Define relation for Tutor Interest with Tutor Profile
     */
    public function tutor_profile(){
        return $this->belongsTo(TutorProfile::class,'tutor_profile_id','id');
    }

    /**
     * Define relation for Tutor Interest with Tutor
     */
    public function interest(){
        return $this->belongsTo(Interest::class,'interest_id','id');
    }

    /*
    * Define relation for Tutor Interest with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
