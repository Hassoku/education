<?php

namespace App\Http\Controllers\Web\Admin;


use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Admin\excelExports\BalanceReport;
use App\Models\Topic;
use App\Models\Users\Students\Student;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Tutors\Tutor;
use App\Models\Users\Tutors\TutorBalance;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;

class ReportController extends Controller
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

    public function index(Request $request){

        /*
         * tabs selection
         * */
        $currentTabsArray = ['salesReport','tutorBalances','studentBalances','comprehensiveReport'];
        if(empty($request->input('tab')) || !in_array($request->input('tab'), $currentTabsArray)){
            $selectedTab = 'salesReport';
        }else{
            $selectedTab = $request->input('tab');
        }
        // for pagination
        $page = $request->has('page') ? $request->get('page') : 1; // only for sale report
        $perPageRecords = ($request->input('per_page'))?$request->input('per_page'):50;

        //If its search request
        if($request->has('searchTheDate')){
            $theDate = $request->get('searchTheDate');
            $searchTheDate = $theDate;
        }else{
            $theDate = date('Y-m-d');
            $searchTheDate = '';
        }

        if($request->has('searchTheTutor')){
            $searchTheTutor = $request->get('searchTheTutor');
            $tutorsCollection = Tutor::where('name', 'like', '%'.$searchTheTutor.'%')
                ->orWhere('last_name', 'like', '%'.$searchTheTutor.'%')
                ->orWhere('email', 'like', '%'.$searchTheTutor.'%')
                ->orWhere('mobile', 'like', '%'.$searchTheTutor.'%')
                ->orderBy('created_at', 'DESC')
                ->paginate($perPageRecords,['*'],'tut_page');
        }else{
            $searchTheTutor = '';
            // tutor balance report
            $tutorsCollection = Tutor::orderBy('created_at', 'ASC')->paginate($perPageRecords,['*'],'tut_page');
        }

        if($request->has('searchTheStudent')){
            $searchTheStudent = $request->get('searchTheStudent');
            $studentsCollection = Student::where('name', 'like', '%'.$searchTheStudent.'%')
                ->orWhere('last_name', 'like', '%'.$searchTheStudent.'%')
                ->orWhere('email', 'like', '%'.$searchTheStudent.'%')
                ->orWhere('mobile', 'like', '%'.$searchTheStudent.'%')
                ->orderBy('created_at', 'ASC')
                ->paginate($perPageRecords,['*'],'std_page');
        }else{
            // student balance report
            $studentsCollection = Student::orderBy('created_at', 'ASC')->paginate($perPageRecords,['*'],'std_page');
            $searchTheStudent = '';
        }

        // search date for comprehensive report
        if($request->has('searchCRFromDate') && $request->has('searchCRToDate')){
            $theCRFromDate = $request->get('searchCRFromDate');
            $theCRToDate = $request->get('searchCRToDate');
            $searchCRFromDate = $theCRFromDate;
            $searchCRToDate = $theCRToDate;
        }else{
            $theCRFromDate = date('Y-m-d', mktime(0,0,0,1,1,2018));
            $theCRToDate = date('Y-m-d');
            $searchCRFromDate = '';
            $searchCRToDate = '';
        }        
        
        /*
         * If its criteria request
         **/
        $currentCriteriaArray = ['daily', 'weekly', 'monthly', 'quarterly', 'yearly','on_date'];
        if(empty($request->input('criteria')) || !in_array($request->input('criteria'), $currentCriteriaArray)){
            $selectedCriteria = 'daily';
        }else{
            $selectedCriteria = $request->input('criteria');
        }

        // sale data
        $salesData = CommonHelper::salesReport(['criteria' => $selectedCriteria, 'date' => $theDate]);
        $salesDetailCollection = $salesData['salesDetail'];


        // comprehensive report
        // from date
        $fromDate = $theCRFromDate;
            $fromDay = date('d', strtotime($fromDate));
            $fromMonth = date('m', strtotime($fromDate));
            $fromYear = date('Y', strtotime($fromDate));
        $fromDate = date('Y-m-d H:i:s', mktime(0,0,0,$fromMonth,$fromDay,$fromYear));

        // to date
        $toDate = $theCRToDate;
            $toDay = date('d', strtotime($toDate));
            $toMonth = date('m', strtotime($toDate));
            $toYear = date('Y', strtotime($toDate));
        $toDate = date('Y-m-d H:i:s', mktime(23,59,59,$toMonth,$toDay,$toYear));

        //
        $comprehensiveTutorCollection = TutorBalance::whereBetween('created_at',[$fromDate,$toDate])->paginate($perPageRecords,['*'],'tut_CR_page');
        // student balances: only purchased entries
        $comprehensiveStudentCollection = StudentBalance::where('purchased_slots', '>', 0)->whereBetween('created_at',[$fromDate,$toDate])->paginate($perPageRecords,['*'],'std_CR_page');

        $currentCRTabsArray = ['comprehensiveReportTutorTab','comprehensiveReportStudentTab'];
        if(empty($request->input('crTab')) || !in_array($request->input('crTab'), $currentCRTabsArray)){
            $selectedCRTab = 'comprehensiveReportTutorTab';
        }else{
            $selectedCRTab = $request->input('crTab');
        }
        //////////////////////////

        return view('admin.reports.index',[
            'selectedTab' => $selectedTab,
            'selectedCriteria' => $selectedCriteria,
            'salesDataCollection' => [
                'xAxisData' => $salesData['xAxisData'],
                'sales' => $salesData['sales'],
                'totalAmount' => $salesData['totalAmount'],
                'msg' => $salesData['msg']
            ],
            'salesDetailCollection' => $this->paginate($salesDetailCollection,$perPageRecords,(int) $page,[])->withPath(route('admin.reports',['tab'=>'salesReport'])),
            'searchTheDate' => $searchTheDate,

            // tutor balances
            'tutorsCollection' => $tutorsCollection,
            'searchTheTutor' => $searchTheTutor,

            // student balances
            'studentsCollection' => $studentsCollection,
            'searchTheStudent' => $searchTheStudent,

            // comprehensive report
            'selectedCRTab' => $selectedCRTab,
            'searchCRFromDate' => $searchCRFromDate,
            'searchCRToDate' => $searchCRToDate,
            'comprehensiveTutorCollection' => $comprehensiveTutorCollection,
            'comprehensiveStudentCollection' => $comprehensiveStudentCollection,
        ]);
    }

    public function showTutor(Request $request, $id){
        $tutor = Tutor::find($id);
        $tutorBalanceCollection = $tutor->tutor_balance;

        $page = $request->has('page') ? $request->get('page') : 1;
        $perPageRecords = ($request->input('per_page'))?$request->input('per_page'):50;
        return view('admin.reports.tutor.show',[
            'tutor' => $tutor,
            'tutorBalanceCollection' => $this->paginate($tutorBalanceCollection,$perPageRecords ,(int) $page, [])->withPath(route('admin.reports.tutor.show',['id' => $tutor->id]))
        ]);
    } 
    
    public function showStudent(Request $request, $id){
        $student = Student::find($id);
        $studentBalanceCollection = $student->student_balance_payments;

        $page = $request->has('page') ? $request->get('page') : 1;
        $perPageRecords = ($request->input('per_page'))?$request->input('per_page'):50;
        return view('admin.reports.student.show',[
            'student' => $student,
            'studentBalanceCollection' => $this->paginate($studentBalanceCollection,$perPageRecords ,(int) $page, [])->withPath(route('admin.reports.student.show',['id' => $student->id]))
        ]);
    }

    // export reports
    public function exportReport(Request $request, $tab){

        $perPageRecords = ($request->input('per_page'))?$request->input('per_page'):50;
        switch ($tab){
            case 'salesRep' : {
            } break;
            case 'tutBlncRep' : {
                if($request->has('searchTheTutor')){
                    $searchTheTutor = $request->get('searchTheTutor');
                    $tutorsCollection = Tutor::where('name', 'like', '%'.$searchTheTutor.'%')
                        ->orWhere('last_name', 'like', '%'.$searchTheTutor.'%')
                        ->orWhere('email', 'like', '%'.$searchTheTutor.'%')
                        ->orWhere('mobile', 'like', '%'.$searchTheTutor.'%')
                        ->orderBy('created_at', 'DESC')
                        ->paginate($perPageRecords,['*'],'tut_page');
                }else{
                    $searchTheTutor = '';
                    // tutor balance report
                    $tutorsCollection = Tutor::orderBy('created_at', 'ASC')->paginate($perPageRecords,['*'],'tut_page');
                }

                // making report
                $data = collect();
                $tPending = 0;
                $tWithdraw = 0;
                $tTotalAmount = 0;

                $serialNumberCounter = ($tutorsCollection->currentPage()-1) * $tutorsCollection->perPage()+1;
                foreach($tutorsCollection as $tutor){
                    $earning =  $tutor->sumOf_earning_transactions[0]->earning;
                    $withdraw = $tutor->someOf_withdraw_transactions[0]->withdraw;
                    $withdraw = ($withdraw) ? $withdraw : 0;
                    $pending = $earning - $withdraw;
                    $totalAmount = $earning + $withdraw;

                    $row = [
                        $serialNumberCounter++,
                        $tutor->name,
                        $tutor->last_name,
                        $tutor->email,
                        ($pending) ? $pending : '0',
                        ($withdraw) ? $withdraw : '0',
                        ($totalAmount) ? $totalAmount : '0'
                    ];

                    $data->push($row);

                    // for total row
                    $tPending += $pending;
                    $tWithdraw += $withdraw;
                    $tTotalAmount += $totalAmount;
                }

                // total row
                $totalRow = [
                    'Total',
                    '',
                    '',
                    '',
                    ($tPending) ? $tPending : '0',
                    ($tWithdraw) ? $tWithdraw : '0',
                    ($tTotalAmount) ? $tTotalAmount : '0'
                ];
                $data->push($totalRow);

                // export as Excel file
                return Excel::download( new BalanceReport($data,
                                                'All Tutor Balance Report'
                                                 ,['Sno','First Name', 'Last Name', 'Email', 'Pending Amount', 'Withdraw Amount', 'Total Amount'])
                    , date('jFYhms').'-DuroosAllTutorsBalanceReport.xlsx');

                // export as PDF
//                return Excel::download(new BalanceReport($data), 'test.pdf');

            } break;
            case 'stdBlncRep' : {
                if($request->has('searchTheStudent')){
                    $searchTheStudent = $request->get('searchTheStudent');
                    $studentsCollection = Student::where('name', 'like', '%'.$searchTheStudent.'%')
                        ->orWhere('last_name', 'like', '%'.$searchTheStudent.'%')
                        ->orWhere('email', 'like', '%'.$searchTheStudent.'%')
                        ->orWhere('mobile', 'like', '%'.$searchTheStudent.'%')
                        ->orderBy('created_at', 'ASC')
                        ->paginate($perPageRecords,['*'],'std_page');
                }else{
                    // student balance report
                    $studentsCollection = Student::orderBy('created_at', 'ASC')->paginate($perPageRecords,['*'],'std_page');
                    $searchTheStudent = '';
                }

                // making report
                $data = collect();
                $tTotalPurchasedAmount = 0;

                $serialNumberCounter = ($studentsCollection->currentPage()-1) * $studentsCollection->perPage()+1;
                foreach($studentsCollection as $student){
                    $totalPurchasedAmount = $student->totalPurchasedAmount[0]->totalPurchasedAmount;
                    $totalPurchasedAmount = ($totalPurchasedAmount) ? $totalPurchasedAmount : 0;
                    $tTotalPurchasedAmount += $totalPurchasedAmount;

                    $row = [
                        $serialNumberCounter++,
                        $student->name,
                        $student->last_name,
                        $student->email,
                        ($totalPurchasedAmount) ? $totalPurchasedAmount : '0'
                    ];
                    $data->push($row);
                }

                // total row
                $totalRow = [
                    'Total',
                    '',
                    '',
                    '',
                    ($tTotalPurchasedAmount) ? $tTotalPurchasedAmount : '0',
                ];
                $data->push($totalRow);

                // export as Excel file
                return Excel::download( new BalanceReport($data,
                        'All Students Balance Report'
                        ,['Sno','First Name', 'Last Name', 'Email', 'Amount'])
                    , date('jFYhms').'-DuroosAllStudentsBalanceReport.xlsx');

                // export as PDF
//                return Excel::download(new BalanceReport($data), 'test.pdf');
            } break;
            case 'indvTutBlncRep' : {
                $id = $request->get('id');
                $page = $request->has('page') ? $request->get('page') : 1;

                $tutor = Tutor::find($id);
                $tutorBalanceCollection = $tutor->tutor_balance;
                $tutorBalanceCollection = $this->paginate($tutorBalanceCollection,$perPageRecords ,(int) $page, [])->withPath(route('admin.reports.tutor.show',['id' => $tutor->id]));

                // making report
                $data = collect();
                $tAmount = 0;

                $serialNumberCounter = ($tutorBalanceCollection->currentPage()-1) * $tutorBalanceCollection->perPage()+1;
                foreach($tutorBalanceCollection as $tutorBalance){
                    $type = strtoupper($tutorBalance->type);
                    $amount = ($tutorBalance->type == 'earning') ? $tutorBalance->earning_amount : $tutorBalance->withdraw_amount;
                    $date = ($tutorBalance->created_at) ? $tutorBalance->created_at->format('F j, Y'): '';

                    $row = [
                        $serialNumberCounter++,
                        $type,
                        $amount,
                        $date
                    ];
                    $data->push($row);
                    $tAmount += $amount;
                }

                $totalRow = [
                    'Total',
                    '',
                    $tAmount,
                    ''
                ];
                $data->push($totalRow);

                // export as Excel file
                return Excel::download( new BalanceReport($data,
                        'Balance Report For '.$tutor->name
                        ,['Sno','Type', 'Minutes', 'Amount', 'Date'])
                    , date('jFYhms').'-DuroosBalanceReportFor'.$tutor->name.'.pdf');

                // export as PDF
//                return Excel::download(new BalanceReport($data), 'test.pdf');
            } break;
            case 'indvStdBlncRep' : {
                $id = $request->get('id');
                $page = $request->has('page') ? $request->get('page') : 1;

                $student = Student::find($id);
                $studentBalanceCollection = $student->student_balance_payments;
                $studentBalanceCollection =  $this->paginate($studentBalanceCollection,$perPageRecords ,(int) $page, [])->withPath(route('admin.reports.student.show',['id' => $student->id]));

                // making report
                $data = collect();
                $tAmount = 0;

                $serialNumberCounter = ($studentBalanceCollection->currentPage()-1) * $studentBalanceCollection->perPage()+1;
                foreach ($studentBalanceCollection as $studentBalance){
                    $type = strtoupper($studentBalance->type);
                    $minutes = $studentBalance->purchased_slots / 4;
                    $amount = $studentBalance->purchased_amount;
                    $date = ($studentBalance->created_at) ? $studentBalance->created_at->format('F j, Y'): '';

                    $row = [
                        $serialNumberCounter++,
                        $type,
                        $minutes,
                        $amount,
                        $date
                    ];
                    $data->push($row);
                    $tAmount += $amount;
                }

                $totalRow = [
                    'Total',
                    '',
                    '',
                    $tAmount,
                    ''
                ];
                $data->push($totalRow);

                // export as Excel file
                return Excel::download( new BalanceReport($data,
                        'Balance Report For '.$student->name
                        ,['Sno','Type', 'Minutes', 'Amount', 'Date'])
                    , date('jFYhms').'-DuroosBalanceReportFor'.$student->name.'.xlsx');

                // export as PDF
//                return Excel::download(new BalanceReport($data), 'test.pdf');
            } break;
        }
    }

    ///////////////// to paginate the list of items ////////////////////////////////////
    public function paginate($items, $perPage = 15, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}