<?php

namespace App\Http\Controllers\Web\Admin;


use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tutor as TutorResources;
use App\Models\LearningSessions\LearningSession;
use App\Models\Topic;
use App\Models\Users\Students\Student;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Tutors\Tutor;
use App\Models\Users\Tutors\TutorBalance;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
        $this->middleware('auth:admin');
    }

    public function index(){

        // yearly student Joined collection
        $yearlyStudentJoinedCollection = collect();

        // yearly tutor Joined collection
        $yearlyTutorJoinedCollection = collect();

        // yearly session occurred collection
        $yearlySessionOccurredCollection = collect();

        //Loop through each month
        for ($loopMonth = 1;$loopMonth <= 12; $loopMonth++) {

            $startMonthOfCurrentYear = date("Y-m-d H:i:s", mktime(0, 0, 0, $loopMonth, 1, date('Y')));
            $endMonthOfCurrentYear = date("Y-m-d H:i:s", mktime(0, 0, 0, $loopMonth + 1, 1, date('Y')));

            //Get student created records for current month
                $studentJoinedRecordByMonth = Student::whereBetween('created_at', [$startMonthOfCurrentYear, $endMonthOfCurrentYear])
                    //->groupBy(Student::getTableName() . '.id')
                    ->count();
                if ($studentJoinedRecordByMonth > 0) {
                    $totalMonthlyJoinedStudents = $studentJoinedRecordByMonth;
                } else {
                    $totalMonthlyJoinedStudents = 0;
                }
                $yearlyStudentJoinedCollection->push($totalMonthlyJoinedStudents);

             // Get tutors created records for current month
                $tutorsJoinedRecordByMonth = Tutor::whereBetween('created_at', [$startMonthOfCurrentYear, $endMonthOfCurrentYear])
                    //->groupBy(Tutor::getTableName() . '.id')
                    ->count();
                if ($tutorsJoinedRecordByMonth > 0) {
                    $totalMonthlyJoinedTutors = $tutorsJoinedRecordByMonth;
                } else {
                    $totalMonthlyJoinedTutors = 0;
                }
                $yearlyTutorJoinedCollection->push($totalMonthlyJoinedTutors);

            // Get sessions created records for current month
                $sessionOccurredRecordByMonth = LearningSession::whereBetween('created_at', [$startMonthOfCurrentYear, $endMonthOfCurrentYear])
                    //->groupBy(LearningSession::getTableName() . '.id')
                    ->count();
                if ($sessionOccurredRecordByMonth > 0) {
                    $totalMonthlyOccurredSession = $sessionOccurredRecordByMonth;
                } else {
                    $totalMonthlyOccurredSession = 0;
                }
                $yearlySessionOccurredCollection->push($totalMonthlyOccurredSession);
        }

        ///////////////////////////////////////////////////////////////

        // week days - today to last day
        $weekDaysCollection = collect();

        // weekly sales - receivable
        $weeklySalesCollection = collect();

        // weekly payments - payable
        $weeklyPaymentCollection = collect();

        /*
         * Last week report
         * startDay: the last day of week from today(LAST-FRI) - date 20
         * endDay: day of today(THIS-FRI)- date 13
         * */
         //$startDayOfLastWeek = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m'), date('d')-7,date('Y')));
        $w = date('Y-m-d H:i:s', strtotime("-1 week")); // one week ago
        $startDayOfLastWeek = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m', strtotime($w)), date('d',strtotime($w)), date('Y',strtotime($w))));
        $endDayOfLastWeek = date("Y-m-d H:i:s", mktime(23, 59, 59, date('m'), date('d'), date('Y')));

            //loop through each day of week to finding the day
//            for($loopDay = date('d',strtotime($startDayOfLastWeek)); $loopDay <= date('d',strtotime($endDayOfLastWeek)); $loopDay++){
            for($loopDate = $startDayOfLastWeek; strtotime($loopDate) <= strtotime($endDayOfLastWeek); $loopDate=date('Y-m-d H:i:s',strtotime("+1 day", strtotime($loopDate)))){

                $loopDay = date('d',strtotime($loopDate));

                // making the date
                $date = '' . date('Y-m-d H:i:s', mktime(0,0,0,date('m', strtotime($loopDate)),$loopDay,date('Y',strtotime($loopDate))));
                $endOfDate = '' . date('Y-m-d H:i:s', mktime(23,59,59,date('m',strtotime($loopDate)),$loopDay,date('Y',strtotime($loopDate))));
                // find  the day of date - XXX(SUN,MUN ...)
                $day = date('D', strtotime($date)); // string 'Thu' (length=3)
                $day = strtoupper($day);
                $weekDaysCollection->push("'".$day."'");

                /*
                * weeklySales:
                * student subscription of week will be displayed
                * */
                $dayWiseSale = 0;
                $studentBalances = StudentBalance::where('purchased_slots', '>', 0)->whereBetween('created_at',[$date,$endOfDate])->get();
                if($studentBalances->count() > 0){
                    foreach ($studentBalances as $studentBalance){
                        $dayWiseSale += $studentBalance->purchased_amount; // sold amount
                    }
                }else{
                    $dayWiseSale = 0;
                }
                $weeklySalesCollection->push($dayWiseSale);

                /*
                 * weekly payments
                 * tutor session payments of week will be displayed
                 * */
                $dayWisePayments = 0;
                $tutorBalances = TutorBalance::whereBetween('created_at',[$date,$endOfDate])->get();
                if($tutorBalances->count() > 0){
                    foreach ($tutorBalances as $tutorBalance){
                        //$dayWisePayments += $tutorBalance->withdraw_amount; // paid amount
                        $dayWisePayments += $tutorBalance->earning_amount; // payable amount
                    }
                }else{
                    $dayWisePayments = 0;
                }
                $weeklyPaymentCollection->push($dayWisePayments);
            }

         /*
          * Today report
          * */

            $todaySaleCollection = collect();
            $todayPaymentCollection = collect();

            $startOfToday = '' . date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d'),date('Y')));
            $endOfToday = '' . date('Y-m-d H:i:s', mktime(23,59,59,date('m'),date('d'),date('Y')));

            // today's sale
                $todaySale = 0;

                    $studentBalances = StudentBalance::where('purchased_slots', '>', 0)->whereBetween('created_at',[$startOfToday,$endOfToday])->get();
                    $todaySaleCount = $studentBalances->count();
                    if($todaySaleCount > 0){
                        foreach ($studentBalances as $studentBalance){
                            $todaySale += $studentBalance->purchased_amount; // sold amount
                        }
                    }else{
                        $todaySale = 0;
                    }

                    $todaySaleCollection['saleCount'] = $todaySaleCount;
                    $todaySaleCollection['sale'] = $todaySale;

            // today's payment
                $todayPayable = 0;
                $todayPaid = 0;

                $tutorBalances = TutorBalance::whereBetween('created_at',[$startOfToday,$endOfToday])->get();
                $todayPaymentCount = $tutorBalances->count();
                if($todayPaymentCount > 0){
                    foreach ($tutorBalances as $tutorBalance){
                        $todayPaid += $tutorBalance->withdraw_amount; // paid amount
                        $todayPayable += $tutorBalance->earning_amount; // payable amount
                    }
                }else{
                    $todayPayment = 0;
                }
                $todayPaymentCollection['paymentCount'] = $todayPaymentCount;
                $todayPaymentCollection['payable'] = $todayPayable;
                $todayPaymentCollection['paid'] = $todayPaid;



        ///////////////////////////////////////////////////////////////
        $total_tutors = Tutor::count();
        $new_tutors = Tutor::where(['status' => 'under_review'])->count();
        $total_students = Student::count();
        $new_students = Student::where(['status' => 'under_review'])->count();
        $total_learning_sessions = LearningSession::count();
        $active_learning_session = LearningSession::where(['status' => 1])->count();

        return view('admin.dashboard', [
            'total_tutors' => $total_tutors,
            'new_tutors' => $new_tutors,
            'total_students' => $total_students,
            'new_students' => $new_students,
            'total_learning_sessions' => $total_learning_sessions,
            'active_learning_session' => $active_learning_session,
            'yearlyStudentJoinedCollection' => $yearlyStudentJoinedCollection,
            'yearlyTutorJoinedCollection' => $yearlyTutorJoinedCollection,
            'yearlySessionOccurredCollection' => $yearlySessionOccurredCollection,
            'tutorsCollection' => Tutor::all()->take(5), // will take 5 rows only
            'studentsCollection' => Student::all()->take(5), // will take 5 rows only
            'topicsCollection' => Topic::where(['level' => 0])->take(5)->get(), // will take 5 rows only

            'todaySaleCollection' => $todaySaleCollection,
            'todayPaymentCollection' => $todayPaymentCollection,
            'weekDaysCollection' => $weekDaysCollection,
            'weeklySalesCollection' => $weeklySalesCollection,
            'weeklyPaymentCollection' => $weeklyPaymentCollection,
            'startDayOfLastWeek' => $startDayOfLastWeek
        ]);
    }
}