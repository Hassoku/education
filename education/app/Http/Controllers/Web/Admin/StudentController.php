<?php
namespace App\Http\Controllers\Web\Admin;


use App\Helpers\StudentCommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Users\Students\Student;
use App\Models\Users\Students\StudentBalance;
use App\Models\Users\Students\StudentPreferences;
use App\Models\Users\Students\StudentProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
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

    /*
     * Return the admin.student with all student in json format
     * */
    public function index(Request $request){
        $perPageRecords = ($request->input('per_page'))?$request->input('per_page'):10;

        /*
         * If its search request,
         */
        if($request->has('keyword')){
            $searchKeyword = $request->input('keyword');
            $studentsCollection = Student::where('name', 'like', '%'.$searchKeyword.'%')
                ->orWhere('last_name', 'like', '%'.$searchKeyword.'%')
                ->orWhere('email', 'like', '%'.$searchKeyword.'%')
                ->orWhere('mobile', 'like', '%'.$searchKeyword.'%')
                ->orderBy('created_at', 'DESC')
                ->paginate(20);
        }else{
            //Execute query with pagination
            $studentsCollection = Student::orderBy('created_at', 'DESC')->paginate($perPageRecords);
            $searchKeyword = '';
        }

        return view('admin.students.index',[
            'perPageRecords' => $perPageRecords,
            'studentsCollection' => $studentsCollection,
            'searchKeyword' => $searchKeyword
        ]);
    }

    /*
     * return: view: admin.students.create
     * */
    public function create(){
        return view('admin.students.create');
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|string', // first name
            'last_name' => 'required|string', // last name
            'email' => 'required|email|unique:students',
            'mobile' => 'required|numeric|unique:students',
            'password' => 'required|confirmed',
        ]);

        $student =  Student::create([
            'name' => $request->get('name'), // first name
            'last_name' => $request->get('last_name'), // last name
            'mobile' => $request->get('mobile'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            //'active' => 1, /// active
            'status' => $request->get('status'),
            'referral_code' => StudentCommonHelper::generateReferralCode($request->get('name'))
        ]);

        if($request->get('middle_name')){
            $student->middle_name = $request->get('middle_name');
            $student->update();
        }

        // activation: no need to email verification
        $student->activated = 1;
        $student->status = "active"; // changing status to active
        $student->activation_code = str_random(40);// activation code for student
        $student->activated_at = Carbon::now(); // saving time for activation
        $student->save();

        // create profile with default pic
        $student_profile = StudentProfile::create([
            'student_id' => $student->id
        ]);

        // creating preferences
        $student_preferences = StudentPreferences::create([
            'student_id' => $student->id
        ]);

        // free 5 minutes
        // entry with -1 of purchased_slots and amount is free minutes entry
        $studentBalance = StudentBalance::create([
            'student_id' => $student->id,
            'remaining_slots' => 20,
            'remaining_amount' =>  0,
            'purchased_slots' => -1 ,
            'purchased_amount'=> -1,
        ]);

        // on success will return to the showing the student
        return redirect()->route('admin.student.show',['id' => $student->id]);
    }

    /*
     * get id
     * return view: admin.student.show
     * */
    public function show($id){
        $student = Student::find($id);
        return view('admin.students.show',[
            'student' => $student
        ]);
    }

    /*
     * get: id
     * return: view: admin.student.edit
     * */
    public function edit($id, Request $request){
        $student = Student::find($id);

        $currentTabsArray = ['info'/*, 'profile'*/];
        if(empty($request->input('tab')) || !in_array($request->input('tab'), $currentTabsArray)){
            $selectedTab = 'info';
        }else{
            $selectedTab = $request->input('tab');
        }
        return view('admin.students.edit',[
            'student' => $student,
            'selectedTab' => $selectedTab
        ]);
    }

    /*
     * Update info
     * */
    public function updateInfo($id, Request $request){

        $this->validate($request, [
            'name' => 'required|string|max:255', // first name
            'last_name' => 'required|string|max:255', // last name
            'email' => 'required|email',
            'mobile' => 'required|numeric',
        ]);

        $student = Student::find($id);
        $student->name = $request->get('name');
        if($request->has('middle_name')){ $student->middle_name = $request->get('middle_name');}
        $student->last_name = $request->get('last_name');
        $student->email = $request->get('email');
        $student->mobile = $request->get('mobile');
        //$student->active = ($request->get('status') == '1') ? true : false;
        $student->status = $request->get('status');
        $student->save();

        //Return with success
        session()->flash('success', 'Record updated successfully.');
        return redirect()->route('admin.student.edit',['id' => $id,'tab' => 'info']);
    }

    public function updateStatus($id, Request $request){
        $student = Student::find($id);
        $student->status = $request->get('status');
        $student->save();
        echo true;
    }

    public function destroy($id){
        Student::find($id)->delete();
        StudentProfile::where('student_id',$id)->delete();
        StudentPreferences::where('student_id',$id)->delete();
        StudentBalance::where('student_id',$id)->delete();
        echo true;
    }

    // Testing
    /*
     *     Assign free minutes
     * ===============================
     * $id => student tid
     *
     */
    public function assignFreeMinutes($id){

        // free 5 minutes
        // entry with -1 of purchased_slots and amount is free minutes entry
        $studentBalance = StudentBalance::create([
            'student_id' => $id,
            'remaining_slots' => 240,
            'remaining_amount' =>  0,
            'purchased_slots' => -1 ,
            'purchased_amount'=> -1,
        ]);

        return redirect()->route('admin.student.show',['id' => $id]);
    }

}
