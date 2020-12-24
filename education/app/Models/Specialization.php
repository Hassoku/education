<?php

namespace App\Models;


use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Tutors\TutorSpecialization;

class Specialization extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'specializations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'specialization',
        'moderate_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /*
     * Define relation for Specialization with tutor specialization
     *
     * **
    public function tutor_specialization()
    {
        return $this->hasMany(TutorSpecialization::class, 'specialization_id', 'id');
    }*/

    /*
    * Define relation for Specialization with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
