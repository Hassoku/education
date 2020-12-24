<?php

namespace App\Models\Users\Admin;

use App\Models\BaseModels\BaseUserModel;
use App\Models\Chat\IndividualChat;
use App\Models\Interest;
use App\Models\Language;
use App\Models\LearningSessions\LearningSession;
use App\Models\LearningSessions\LearningSessionParticipant;
use App\Models\LearningSessions\LearningSessionRequest;
use App\Models\LearningSessions\LearningSessionReservation;
use App\Models\LearningSessions\ServiceCharges;
use App\Models\Specialization;
use App\Models\SubscriptionPackage;
use App\Models\Users\Students\Student;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Students\StudentDevice;
use App\Models\Users\Students\StudentFavoriteTutors;
use App\Models\Users\Students\StudentPreferences;
use App\Models\Users\Students\StudentProfile;
use App\Models\Users\Tutors\Tutor;
use App\Models\Users\Tutors\TutorAvailability;
use App\Models\Users\Tutors\TutorBalance;
use App\Models\Users\Tutors\TutorCardDetails;
use App\Models\Users\Tutors\TutorInterest;
use App\Models\Users\Tutors\TutorLanguage;
use App\Models\Users\Tutors\TutorPreferences;
use App\Models\Users\Tutors\TutorProfile;
use App\Models\Users\Tutors\TutorRating;
use App\Models\Users\Tutors\TutorSpecialization;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Notifications\Notifiable;

class Admin extends BaseUserModel
{
    use Notifiable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
    public $userType = 'admin';

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
        $name = $this->name;
        $this->notify(new AdminResetPasswordNotification($token, $name));
    }

    /*
     * Define relation for Admin with Student, Student Profile, Student Devices, Student balances
     *
     * **/
    public function student()
    {
        return $this->hasMany(Student::class, 'moderate_id', 'id');
    }
    public function student_profile()
    {
        return $this->hasMany(StudentProfile::class, 'moderate_id', 'id');
    }
    public function student_device()
    {
        return $this->hasMany(StudentDevice::class, 'moderate_id', 'id');
    }
    public function student_balance()
    {
        return $this->hasMany(StudentBalance::class, 'moderate_id', 'id');
    }
    public function student_preferences()
    {
        return $this->hasOne(StudentPreferences::class, 'moderate_id', 'id');
    }
    public function studentFavoriteTutors(){
        return $this->hasMany(StudentFavoriteTutors::class, 'moderate_id','id');
    }

    /*
     * Define relation for Admin with Tutor, Tutor Profile, Tutor balance, Tutor interest, Tutor language, Tutor specialization
     * **/
    public function tutor()
    {
        return $this->hasMany(Tutor::class, 'moderate_id', 'id');
    }
    public function tutor_profile()
    {
        return $this->hasMany(TutorProfile::class, 'moderate_id', 'id');
    }
    public function tutor_balance()
    {
        return $this->hasMany(TutorBalance::class, 'moderate_id', 'id');
    }
    public function tutor_interest()
    {
        return $this->hasMany(TutorInterest::class, 'moderate_id', 'id');
    }
    public function tutor_language()
    {
        return $this->hasMany(TutorLanguage::class, 'moderate_id', 'id');
    }
    public function tutor_specialization()
    {
        return $this->hasMany(TutorSpecialization::class, 'moderate_id', 'id');
    }
    public function tutor_rating()
    {
        return $this->hasMany(TutorRating::class, 'moderate_id', 'id');
    }
    public function tutor_availabilities()
    {
        return $this->hasMany(TutorAvailability::class, 'moderate_id', 'id');
    }
    public function tutor_card_details()
    {
        return $this->hasMany(TutorCardDetails::class, 'moderate_id', 'id');
    }
    public function tutor_preferences()
    {
        return $this->hasOne(TutorPreferences::class, 'moderate_id', 'id');
    }

    /*
     * Define relation for Admin with Learning Session, Learning Session Request, Service Charges, Learning Session Reservation, Individual Chat, Learning Session Participant
     * **/
    public function learning_session()
    {
        return $this->hasMany(LearningSession::class, 'moderate_id', 'id');
    }
    public function learning_session_request()
    {
        return $this->hasMany(LearningSessionRequest::class, 'moderate_id', 'id');
    }
    public function service_charges()
    {
        return $this->hasMany(ServiceCharges::class, 'moderate_id', 'id');
    }
    public function learning_session_reservations()
    {
        return $this->hasMany(LearningSessionReservation::class, 'moderate_id', 'id');
    }
    public function individual_chats()
    {
        return $this->hasMany(IndividualChat::class, 'moderate_id', 'id');
    }
    public function learning_session_participants()
    {
        return $this->hasMany(LearningSessionParticipant::class, 'moderate_id', 'id');
    }

    /*
     * Define Relationship for Admin with Interest, Language, Specialization, SubscriptionPackage
     * */
    public function interest()
    {
        return $this->hasMany(Interest::class, 'moderate_id', 'id');
    }
    public function language()
    {
        return $this->hasMany(Language::class, 'moderate_id', 'id');
    }
    public function specialization()
    {
        return $this->hasMany(Specialization::class, 'moderate_id', 'id');
    }
    public function subscription_packages()
    {
        return $this->hasMany(SubscriptionPackage::class, 'moderate_id', 'id');
    }
}
