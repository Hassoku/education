<?php

namespace App\Http\Controllers\Web\Admin;


use App\Http\Controllers\Controller;
use App\Http\Resources\Tutor;
use App\Models\Topic;
use App\Models\Users\Students\Student;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class SubjectController extends Controller
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
     * Return the admin.topic with all topic in json format
     * */
    public function index(Request $request){
        $perPageRecords = ($request->input('per_page'))?$request->input('per_page'):10;

        /*
         * If its search request,
         */
        if($request->has('keyword')){
            $searchKeyword = $request->input('keyword');
            $subjectsCollection = Topic::where(['parent' => 0, 'delete' => 0])
                ->where('topic', 'like', '%'.$searchKeyword.'%')
                ->orWhere('description', 'like', '%'.$searchKeyword.'%')
                ->where(['level' => 0])
                ->paginate($perPageRecords);
        }else{
            //Execute query with pagination
 //           $subjectsCollection = Topic::where(['level' => 1])->paginate($perPageRecords);
           $subjectsCollection = Topic::where(['parent' => 0, 'delete' => 0])->paginate($perPageRecords);
            $searchKeyword = '';
        }

        return view('admin.subjects.index',[
            'perPageRecords' => $perPageRecords,
            'subjectsCollection' => $subjectsCollection,
            'searchKeyword' => $searchKeyword
        ]);
    }

    /*
     * return: view: admin.topics.create
     * */
    public function create(){
        return view('admin.subjects.create',[]);
    }

    /**
     * Store a newly created tutor in storage.
     */
    public function store(Request $request){

        $this->validate($request, [
            'topic' => 'required|string|max:255', // topic
            'parent' => 'required'
        ]);

        $topic = new Topic();
        $topic->topic = $request->get('topic');
        $topic->description = $request->get('description');
        $topic->parent = $request->get('parent');
        $topic->status = $request->get('status');
        $topic->save();

        // update level if parent in not 0
        if($topic->parent == 0){
            $topic->level = 0;
            $topic->save();
        }else{
            // update level with parents level + 1
            $t = Topic::find($topic->parent);

            $topic->level = $t->level+1;
            $topic->save();
        }

        //Return with success
        session()->flash('success', 'Record Inserted successfully.');
        return redirect()->route('admin.subject.show',['id' => $topic->id]);
    }

    /*
     * get: id
     * return: view: admin.topics.show
     * */
    public function show($id, Request $request){
        $topic = Topic::find($id);

        // parent topic
        $parent = Topic::find($topic->parent);

        // sub topics
        $sub_topics = Topic::where(['parent' => $id])->get();

        $tutorsCollection = collect();
        foreach ($topic->tutor_specialization as $tutorSpecialization){
            $tutorsCollection[] = new \App\Http\Resources\Tutor($tutorSpecialization->tutor_profile->tutor);
        }


        $currentTabsArray = ['info','tutors'];
        if(empty($request->input('tab')) || !in_array($request->input('tab'), $currentTabsArray)){
            $selectedTab = 'info';
        }else{
            $selectedTab = $request->input('tab');
        }

        // for pagination
        $page = $request->has('page') ? $request->get('page') : 1;

        return view('admin.subjects.show',[
            'topic' => $topic,
            'parent' => $parent,
            'sub_topics' => $sub_topics,
            'tutorsCollection' => $this->paginate($tutorsCollection,10, (int) $page, [])->withPath(route('admin.topic.show',['id'=>$id,'tab'=>'tutors'])),
            'selectedTab' => $selectedTab
        ]);
    }


    /*
     * get: id
     * return: view: admin.topics.edit
     * */
    public function edit($id){
        $topic = Topic::find($id);
        return view('admin.subjects.edit',[
            'topic' => $topic,
        ]);
    }

    /*
     * Update info
     * */
    public function updateInfo($id, Request $request){

        $this->validate($request, [
            'topic' => 'required|string|max:255', // topic
            'parent' => 'required'
        ]);


        $topic = Topic::find($id);
        $topic->topic = $request->get('topic');
        $topic->description = $request->get('description');
        $topic->parent = $request->get('parent');
        $topic->status = $request->get('status');
        $topic->save();

        // update level if parent in not 0
        if($topic->parent == 0){
            $topic->level = 0;
            $topic->save();
        }else{
            // update level with parents level + 1
            $t = Topic::find($topic->parent);

            $topic->level = $t->level+1;
            $topic->save();
        }

        //Return with success
        session()->flash('success', 'Record updated successfully.');
        return redirect()->route('admin.subject.edit',['id' => $id]);
    }

    public function destroy($id)
    {
        Topic::whereParent($id)->update([
            'delete' => 1,
            'status' => 'deactivate'
        ]);

        Topic::find($id)->update([
            'delete' => 1,
            'status' => 'deactivate'
        ]);

        return response()->json(['success' => true], 200);
    }


    ///////////////// to paginate the list of items ////////////////////////////////////
    public function paginate($items, $perPage = 15, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
