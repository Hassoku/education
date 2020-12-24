<?php

namespace App\Models\Users\Students;

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
use App\Models\Users\Tutors\Tutor;
use App\Notifications\StudentResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Student extends BaseUserModel implements JWTSubject
{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'students';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'middle_name', 'last_name', // (first_name, middle_name, last name) - name is using for first_name.
        'mobile', 'email', 'password', 'status',
        'social_id', 'google_social_id',

        // commented: cause of activation by email
        //'active',

        // use for activation by email
        'activated',
        'activation_code',
        'activated_at',

        'online_status','referral_code', 'moderate_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'referral_code','password', 'remember_token',
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
    protected $userType = 'student';

    /**
     * Get user type for this model
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Eloquent Model method
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new StudentResetPasswordNotification($token));
    }

    /**
     * Define relation for Student with Student Profile
     */
    public function profile()
    {
        return $this->hasOne(StudentProfile::class, 'student_id', 'id');
    }

    /**
     * Define relation for Student with Student Devices
     */
    public function device()
    {
        return $this->hasMany(StudentDevice::class, 'student_id', 'id');
    }

    /*
     * Define relation for Student with learning_session
     * **/
    public function learning_session()
    {
        return $this->hasMany(LearningSession::class, 'student_id', 'id');
    }

    public function learning_session_completed()
    {
        $instance = $this->hasMany(LearningSession::class, 'student_id', 'id')->with('tutor');
        $instance->where('status', '!=', 1); // 0 for closed, and 1 for running
        $instance->orderBy('created_at', 'DESC');
        return $instance;
    }

    /*
     * Define relation for Student with learning_session_request
     *
     * **/
    public function learning_session_request()
    {
        return $this->hasMany(LearningSessionRequest::class, 'student_id', 'id');
    }

    /*
     * Define relation for Student with learning_session_request
     *
     * **/
    public function learning_session_participants()
    {
        return $this->hasMany(LearningSessionParticipant::class, 'student_id', 'id')->with('tutor','learning_session');
    }

    /*
     * Define relation for Student with service charge
     *
     * **/
    public function service_charge()
    {
        return $this->hasMany(ServiceCharges::class, 'student_id', 'id');
    }

    /*
     * Define relation for Student with student balance
     *
     * **/
    public function student_balance()
    {
        return $this->hasMany(StudentBalance::class, 'student_id', 'id');
    }
    public function student_balance_payments()
    {
        $instance =  $this->hasMany(StudentBalance::class, 'student_id', 'id');
        $instance->where('purchased_slots', '>', 0);
        $instance->orderBy('updated_at', 'DESC');
        return $instance;
    }
    public function totalPurchasedAmount()
    {
        $instance =  $this->hasMany(StudentBalance::class, 'student_id', 'id');
        $instance->selectRaw('SUM(purchased_amount) as totalPurchasedAmount');
        $instance->where('purchased_slots', '>', 0);
        return $instance;
    }
    /*
     * Define relation for Student with Learning Session Reservation
     *
     * **/
    public function learning_session_reservations()
    {
        return $this->hasMany(LearningSessionReservation::class, 'student_id', 'id');
    }

    /*
     * Define relation for Student with Tutor Ratings
     *
     * **/
    public function tutor_ratings()
    {
        return $this->hasMany(Tutor::class, 'student_id', 'id');
    }

    /**
     * Define relation for Student with Individual Chat
     */
    public function individual_chat()
    {
        return $this->hasMany(IndividualChat::class, 'student_id', 'id');
    }

    /**
     * Define relation for Student with Student Preferences
     */
    public function preferences()
    {
        return $this->hasOne(StudentPreferences::class, 'student_id', 'id');
    }

    /*
     * Define relation ship with Student Favorite Tutors
     * */
    public function favoriteTutors(){
        return $this->hasMany(StudentFavoriteTutors::class, 'student_id','id');
    }

    /*
     * Define relation ship with ReportTutor
     * */
    public function tutor_reports(){
        return $this->hasMany(ReportTutor::class, 'student_id','id');
    }

    /*
     * Define relation ship with ReportStudent
     * */
    public function student_reports(){
        return $this->hasMany(ReportStudent::class, 'student_id','id');
    }

    /*
    * Define relation for Student with  Admin
    * */
    public function admin(){
        return $this->belongsTo(Admin::class,'moderate_id','id');
    }
}
