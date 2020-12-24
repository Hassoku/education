<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Topic as TopicResources;
use App\Models\Topic;
use App\Models\Users\Tutors\Tutor;
use App\Http\Resources\Tutor as TutorResource;
use App\Models\Users\Tutors\TutorSpecialization;

class TopicController extends BaseController
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
        $this->middleware('auth:api');

        /*
         * Verify student is active
         * */
        $this->middleware('verify.student.isActive');
    }

    /*
     * Return List of Topics
     * */
    public function index(){
//        $topics = Topic::all();
        $topics = Topic::where(['status' => 'activate'])->get(); // only activated topics
        return json_encode(['status' => 'success', 'topics' => TopicResources::collection($topics)]);
    }

    /*
     * Tutor to related topic
     * */
    public function topic_tutors($topic_id){
        // will return the tutors of topic

        // if topic is active
        $topic = Topic::find($topic_id);
        if($topic->status == 'activate'){
            $tutor_specializations = TutorSpecialization::where(['topic_id' => $topic_id])->get();
            $tutors = collect();
            foreach ($tutor_specializations as $tutor_specialization){
                $tutors->push($tutor_specialization->tutor_profile->tutor);
            }
            return json_encode(['status' => 'success','tutors' => TutorResource::collection($tutors)]);
        }else{
            // if topic is not activated
            return json_encode(['status' => 'error','msg' => 'topic is ' . $topic->status]);
        }
    }
}