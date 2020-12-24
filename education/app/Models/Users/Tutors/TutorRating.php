<?php

namespace App\Models\Users\Tutors;

use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Students\Student;

class TutorRating extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tutor_ratings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tutor_profile_id',
        'student_id',
        'rating',
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
     * Define relation for Tutor Rating with Tutor Profile
     */
    public function tutor_profile(){
        return $this->belongsTo(TutorProfile::class,'tutor_profile_id','id');
    }
    /**
     * Define relation for Tutor Rating with Tutor Profile
     */
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }

    /*
    * Define relation for Tutor Rating with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
