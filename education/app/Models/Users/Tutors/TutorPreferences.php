<?php

namespace App\Models\Users\Tutors;

use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;

class TutorPreferences extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tutor_preferences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tutor_id',
        'language',
        'timezone',
        'desktopNotification',
        'emailNotification',
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
     * Define relation for tutor Preferences with tutor
     */
    public function tutor(){
        return $this->belongsTo(Tutor::class,'tutor_id','id');
    }
    /*
    * Define relation for tutor Profile with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
