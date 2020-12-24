<?php

namespace App\Models\Users\Students;

use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;

class StudentDevice extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_devices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fcm_token', 'platform', 'moderate_id'
    ];

    /**
     * Define relation for Student Device with Student
     */
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
    /*
    * Define relation for Student Device with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
