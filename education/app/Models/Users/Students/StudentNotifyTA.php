<?php

namespace App\Models\Users\Students;


use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Tutors\Tutor;

class StudentNotifyTA extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_notify_tas';

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Define relation with Student
     */
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }

    /**
     * Define relation with Tutor
     */
    public function tutor(){
//        return $this->belongsTo(Tutor::class,'tutor_id','id')->with('profile');
        return $this->belongsTo(Tutor::class,'tutor_id','id');
    }

    /*
    * Define relation with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
