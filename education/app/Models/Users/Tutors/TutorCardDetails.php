<?php

namespace App\Models\Users\Tutors;

use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Traits\EncryptableCardData;

class TutorCardDetails extends BaseModel
{
    use EncryptableCardData;

    protected $fillable = [
        'tutor_id',
        'number', 'expiryDate', 'holder', 'cvv',
        'moderate_id'
    ];

    /**
     * The attributes that should be encrypted[store] and decrypted[retrieve].
     *
     * @var array
     */
    protected $encryptable = [
        'number',
        //'expiryDate',
        'holder',
        'cvv'
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
    * Define relation with  Tutor
    * */
    public function tutor(){
        return $this->belongsTo(Tutor::class,'tutor_id','id');
    }

    /*
    * Define relation with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
