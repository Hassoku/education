<?php

namespace App\Models;


use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Tutors\TutorInterest;

class Interest extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'interest',
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

    /*
     * Define relation for Interest with tutor interest
     *
     * **/
    public function tutor_interest()
    {
        return $this->hasMany(TutorInterest::class, 'interest_id', 'id');
    }

    /*
    * Define relation for Interest with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
