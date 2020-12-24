<?php

namespace App\Models\Users\Tutors;


use App\Models\BaseModels\BaseModel;
use App\Models\TutoringStyle;
use App\Models\Users\Admin\Admin;

class TutorTutoringStyle extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tutor_tutoring_styles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tutor_profile_id',
        'tutoring_style_id',
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
     * Define relation for Tutor Tutoring Style with Tutor Profile
     */
    public function tutor_profile(){
        return $this->belongsTo(TutorProfile::class,'tutor_profile_id','id');
    }

    /**
     * Define relation for Tutor Tutoring Style with Tutoring Style
     */
    public function tutoring_style(){
        return $this->belongsTo(TutoringStyle::class,'tutoring_style_id','id');
    }

    /*
    * Define relation for Tutor Tutoring Style with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
