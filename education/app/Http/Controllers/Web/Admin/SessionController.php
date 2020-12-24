<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningSessions\LearningSession;
use Illuminate\Http\Request;

class SessionController extends Controller
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
     * Return the admin.tutor with all tutors in json format
     * */
    public function index(Request $request){
        $perPageRecords = ($request->input('per_page'))?$request->input('per_page'):10;

        /*
         * If its search request,
         */
        if($request->has('keyword')){
            $searchKeyword = $request->input('keyword');
            /*$learningSessionsCollection = LearningSession::where('name', 'like', '%'.$searchKeyword.'%')
                ->orWhere('email', 'like', '%'.$searchKeyword.'%')
                ->paginate(20);*/

//            testing
            $learningSessionsCollection = LearningSession::orderBy('status', 'DESC')->paginate($perPageRecords);
        }else{
            //Execute query with pagination
            $learningSessionsCollection = LearningSession::orderBy('status', 'DESC')->paginate($perPageRecords);
            $searchKeyword = '';
        }

        return view('admin.learningSessions.index',[
            'perPageRecords' => $perPageRecords,
            'learningSessionsCollection' => $learningSessionsCollection,
            'searchKeyword' => $searchKeyword
        ]);
    }

    /*
     * get id
     * return: view: admin.learningSessions.show
     * */
    public function show($id, Request $request){

        $currentTabsArray = ['info', 'video', 'chat'];
        if(empty($request->input('tab')) || !in_array($request->input('tab'), $currentTabsArray)){
            $selectedTab = 'info';
        }else{
            $selectedTab = $request->input('tab');
        }

        $session = LearningSession::find($id);
        return view('admin.learningSessions.show',[
            'session' => $session,
            'selectedTab' => $selectedTab
        ]);
    }

    /*
     * get id
     * return: view: admin.learningSessions.edit
     * */
    public function edit($id){
        $session = LearningSession::find($id);
        return view('admin.learningSessions.edit',[
            'session' => $session
        ]);
    }
}