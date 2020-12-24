<?php

namespace App\Models;


use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;

class TutoringStyle extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tutoring_styles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tutoring_style',
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
    * Define relation for Tutoring Style with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
