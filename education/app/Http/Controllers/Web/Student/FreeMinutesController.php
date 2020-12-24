<?php
namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Models\LearningSessions\LearningSession;
use App\Models\SubscriptionPackage;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Students\StudentSubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreeMinutesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*
         * Authorized users only
         */
        $this->middleware('auth:student');

        /*
         * Verify student is active
         * */
        $this->middleware('verify.student.isActive');
    }
    /*
     * index
     * */
    public function index(){
        $student = Auth::user();
        return view('student.freeMinutes',[
            'ref_code' => $student->referral_code
        ]);
    }
}