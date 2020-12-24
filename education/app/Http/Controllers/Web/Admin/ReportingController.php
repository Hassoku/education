<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportStudent;
use App\Models\ReportTutor;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ReportingController extends Controller
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

        // count of all tutor/student reports
        $tutorReportsCount = ReportTutor::all()->count();
        $studentReportsCount = ReportStudent::all()->count();

        // count of new tutor/student reports
        $newTutorReportsCount = ReportTutor::where('status','=','pending')->get()->count();
        $newStudentReportsCount = ReportStudent::where('status','=','pending')->get()->count();

        // count of closed tutor/student reports
        $closedTutorReportsCount = ReportTutor::where('status','=','closed')->get()->count();
        $closedStudentReportsCount = ReportStudent::where('status','=','closed')->get()->count();


        //top 5 tutor reporting
        $tutorReportCollection = ReportTutor::where('status','=','pending')->take(5)->get();

        //top 5 student reporting
        $studentReportCollection = ReportStudent::where('status','=','pending')->take(5)->get();

        return view('admin.reporting.index',[
            'tutorReportsCount' => $tutorReportsCount,
            'studentReportsCount' => $studentReportsCount,
            'newTutorReportsCount' => $newTutorReportsCount,
            'newStudentReportsCount' => $newStudentReportsCount,
            'closedTutorReportsCount' => $closedTutorReportsCount,
            'closedStudentReportsCount' => $closedStudentReportsCount,
            'tutorReportCollection' => $tutorReportCollection,
            'studentReportCollection' => $studentReportCollection,
        ]);
    }

    /*
     * All tutor reports
     * */
    public function tutorReports(Request $request){
        $tutorReportCollection = ReportTutor::paginate(20);
        return view('admin.reporting.tutor.index',[
            'tutorReportCollection' => $tutorReportCollection,
        ]);
    }
    public function tutorReportShow(Request $request, $id){
        $tutorReport = ReportTutor::find($id);
        return view('admin.reporting.tutor.show',[
            'tutorReport' => $tutorReport
        ]);
    }
    public function tutorReportEdit(Request $request, $id){
        $tutorReport = ReportTutor::find($id);
        return view('admin.reporting.tutor.edit',[
            'tutorReport' => $tutorReport
        ]);
    }
    public function tutorReportUpdate(Request $request, $id){
        $description = $request->get('description');
        $status = $request->get('status');

        $tutorReport = ReportTutor::find($id);
        $tutorReport->description = $description;
        $tutorReport->status = $status;
        $tutorReport->save();

        //Return with success
        session()->flash('success', 'Record updated successfully.');
        return redirect()->route('admin.tut_std.reporting.tutor.edit',['id' => $id]);
    }

    /*
     * ALl student reports
     * */
    public function studentReports(Request $request){
        $studentReportCollection = ReportStudent::paginate(20);
        return view('admin.reporting.student.index',[
            'studentReportCollection' => $studentReportCollection,
        ]);
    }
    public function studentReportShow(Request $request, $id){
        $studentReport = ReportStudent::find($id);
        return view('admin.reporting.student.show',[
            'studentReport' => $studentReport
        ]);
    }
    public function studentReportEdit(Request $request, $id){
        $studentReport = ReportStudent::find($id);
        return view('admin.reporting.student.edit',[
            'studentReport' => $studentReport
        ]);
    }
    public function studentReportUpdate(Request $request, $id){
        $description = $request->get('description');
        $status = $request->get('status');

        $studentReport = ReportStudent::find($id);
        $studentReport->description = $description;
        $studentReport->status = $status;
        $studentReport->save();

        //Return with success
        session()->flash('success', 'Record updated successfully.');
        return redirect()->route('admin.tut_std.reporting.student.edit',['id' => $id]);
    }


    ///////////////// to paginate the list of items ////////////////////////////////////
    public function paginate($items, $perPage = 15, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}