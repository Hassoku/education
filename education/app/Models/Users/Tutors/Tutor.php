<?php

namespace App\Models\Users\Tutors;

use App\Models\BaseModels\BaseUserModel;
use App\Models\Chat\IndividualChat;
use App\Models\LearningSessions\LearningSession;
use App\Models\LearningSessions\LearningSessionParticipant;
use App\Models\LearningSessions\LearningSessionRequest;
use App\Models\LearningSessions\LearningSessionReservation;
use App\Models\LearningSessions\ServiceCharges;
use App\Models\ReportStudent;
use App\Models\ReportTutor;
use App\Models\Users\Admin\Admin;
use App\Models\Users\Students\StudentFavoriteTutors;
use App\Notifications\TutorResetPasswordNotification;
use Illuminate\Notifications\Notifiable;

class Tutor extends BaseUserModel
{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tutors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'middle_name', 'last_name', // (first_name, middle_name, last name) - name is using for first_name.
        'charge', 'is_percentage',
        'mobile', 'email', 'password', 'status', 'active', 'online_status', 'isBusy', 'referral_code' ,'moderate_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'last_login_at'
    ];

    /**
     * The user type for this user.
     *
     * @var string
     */
    public $userType = 'tutor';

    /**
     * Get user type for this model
     */
    public function getUserType(){
        return $this->userType;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new TutorResetPasswordNotification($token));
    }

    /**
     * Define relation for Tutor with Tutor Profile
     */
    public function profile(){
        return $this->hasOne(TutorProfile::class,'tutor_id','id');
    }

    /*
     * Define relation for Tutor with learning_session
     * **/
    public function learning_session()
    {
        return $this->hasMany(LearningSession::class, 'tutor_id', 'id');
    }

    public function learning_session_completed()
    {
        $instance = $this->hasMany(LearningSession::class, 'tutor_id', 'id');
        $instance->where('status', '!=', 1); // 0 for closed, and 1 for running
        $instance->orderBy('created_at', 'DESC');
        return $instance;
    }

    /*
     * Define relation for Tutor with learning_session_request
     *
     * **/
    public function learning_session_request()
    {
        return $this->hasMany(LearningSessionRequest::class, 'tutor_id', 'id');
    }

    /*
     * Define relation for Tutor with learning_session_request
     *
     * **/
    public function learning_session_participants()
    {
        return $this->hasMany(LearningSessionParticipant::class, 'tutor_id', 'id');
    }

    /*
     * Define relation for Tutor with service charge
     *
     * **/
    public function service_charge()
    {
        return $this->hasMany(ServiceCharges::class, 'tutor_id', 'id');
    }

    /*
     * Define relation for Tutor with tutor balance
     *
     * **/
    public function tutor_balance()
    {
        return $this->hasMany(TutorBalance::class, 'tutor_id', 'id');
    }
    public function tutor_earning_transactions(){
        $instance =  $this->hasMany(TutorBalance::class, 'tutor_id', 'id');
        $instance->where(['type' => 'earning']);
        return $instance;
    }
    public function tutor_withdraw_transactions(){
        $instance =  $this->hasMany(TutorBalance::class, 'tutor_id', 'id');
        $instance->where(['type' => 'withdraw']);
        return $instance;
    }
    public function sumOf_earning_transactions(){
        $instance =  $this->hasMany(TutorBalance::class, 'tutor_id', 'id');
        $instance->selectRaw('SUM(earning_amount) as earning');
        $instance->where(['type' => 'earning']);
        return $instance;
    }
    public function someOf_withdraw_transactions(){
        $instance =  $this->hasMany(TutorBalance::class, 'tutor_id', 'id');
        $instance->selectRaw('SUM(withdraw_amount) as withdraw');
        $instance->where(['type' => 'withdraw']);
        return $instance;
    }

    /*
     * Define relation for Tutor with Learning Session Reservation
     *
     * **/
    public function learning_session_reservations()
    {
        return $this->hasMany(LearningSessionReservation::class, 'tutor_id', 'id');
    }


    /**
     * Define relation for Tutor with Individual Chat
     */
    public function individual_chat()
    {
        return $this->hasMany(IndividualChat::class, 'tutor_id', 'id');
    }

    /*
     * Defining relation with Card details
     * : a tutor has one card
     * */
    public function card_details()
    {
        return $this->hasOne(TutorCardDetails::class, 'tutor_id', 'id');
    }

    /**
     * Define relation for Tutor with Tutor Preferences
     */
    public function preferences()
    {
        return $this->hasOne(TutorPreferences::class, 'tutor_id', 'id');
    }

    /*
     * Define relation ship with Student Favorite Tutors
     * */
    public function favoriteTutors(){
        return $this->hasMany(StudentFavoriteTutors::class, 'tutor_id','id');
    }

    /*
     * Define relation ship with ReportTutor
     * */
    public function tutor_reports(){
        return $this->hasMany(ReportTutor::class, 'tutor_id','id');
    }

    /*
     * Define relation ship with ReportStudent
     * */
    public function student_reports(){
        return $this->hasMany(ReportStudent::class, 'tutor_id','id');
    }

    /*
    * Define relation for Tutor with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'id','moderate_id');
    }
}
