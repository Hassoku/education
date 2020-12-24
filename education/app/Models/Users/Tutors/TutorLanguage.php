<?php

namespace App\Models\Users\Tutors;

use App\Models\BaseModels\BaseModel;
use App\Models\Language;
use App\Models\Users\Admin\Admin;

class TutorLanguage extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tutor_languages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tutor_profile_id',
        'language_id',
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
     * Define relation for Tutor Language with Tutor Profile
     */
    public function tutor_profile(){
        return $this->belongsTo(TutorProfile::class,'tutor_profile_id','id');
    }

    /**
     * Define relation for Tutor Language with Tutor
     */
    public function language(){
        return $this->belongsTo(Language::class,'language_id','id');
    }

    /*
    * Define relation for Tutor Language with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
