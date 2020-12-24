<?php

namespace App\Models\Users\Students;

use App\Models\BaseModels\BaseModel;
use App\Models\SubscriptionPackage;
use App\Models\Users\Admin\Admin;

class StudentSubscriptionPackage extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_subscription_packages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'subscription_package_id',
        'active',
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
     * Define relation for Student Subscription Package with Student
     */
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }


    /**
     * Define relation for Student Subscription Package with Subscription Package
     */
    public function subscription_package(){
        return $this->belongsTo(SubscriptionPackage::class,'subscription_package_id','id');
    }


    /*
    * Define relation for Student Subscription Package with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
