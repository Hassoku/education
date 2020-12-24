<?php

namespace App\Models\Users\Tutors;


use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;

class TutorCertification extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tutor_certifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tutor_profile_id',
        'title',
        'description',
        'issuing_authority',
        'start_time',
        'end_time',
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
     * Define relation for Tutor Certification with Tutor Profile
     */
    public function tutor_profile(){
        return $this->belongsTo(TutorProfile::class,'tutor_profile_id','id');
    }


    /*
    * Define relation for Tutor Certification with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
