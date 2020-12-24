<?php

namespace App\Models;

use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Students\StudentSubscriptionPackage;

class SubscriptionPackage extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscription_packages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'minutes',
        'price',
        'type', // individual,group
        'moderate_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'moderate_id',
        "created_at",
        "updated_at"
    ];

    /*
     * Define relation for Subscription Package with Student Subscription Package
     *
     * **/
    public function student_subscription_package()
    {
        return $this->hasMany(StudentSubscriptionPackage::class, 'subscription_package_id', 'id');
    }

    /*
    * Define relation for Subscription Package with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
