<?php

namespace App\Models\Chat;

use App\Models\BaseModels\BaseModel;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Students\Student;
use App\Models\Users\Tutors\Tutor;

class IndividualChat extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'individual_chats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'twilio_student_identity',
        'tutor_id', 'twilio_tutor_identity',

        // chat
        'twilio_chat_channel_unique_name', 'twilio_chat_channel_friendly_name',
        'twilio_chat_channel_sid', 'twilio_chat_channel_url',
        'twilio_chat_channel_type', 'twilio_chat_channel_member_count', 'twilio_chat_channel_msg_count',

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
     * Define relation for Individual Chat with Student
     */
    public function student(){

        return $this->belongsTo(Student::class,'student_id','id');
    }

    /**
     * Define relation for Individual Chat with Tutor
     */
    public function tutor(){
        return $this->belongsTo(Tutor::class,'tutor_id','id');
    }

    /*
    * Define relation for Individual Chat with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
