<?php

namespace App\Models\Users\Students;

use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Tutors\Tutor;

class StudentFavoriteTutors extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_favorite_tutors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'tutor_id',
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
     * Define relation for Student Preferences with Student
     */
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }

    /*
    * Define relation with  Tutor
    * */
    public function tutor(){
        return $this->belongsTo(Tutor::class,'tutor_id','id');
    }

    /*
    * Define relation for Student Profile with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
