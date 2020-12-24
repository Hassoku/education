<?php

namespace App\Http\Controllers\Web\Admin;


use App\Helpers\TutorCommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Interest;
use App\Models\Language;
use App\Models\Topic;
use App\Models\TutoringStyle;
use App\Models\Users\Tutors\Tutor;
use App\Models\Users\Tutors\TutorAvailability;
use App\Http\Resources\TutorAvailability as TutorAvailabilityResources;
use App\Models\Users\Tutors\TutorCertification;
use App\Models\Users\Tutors\TutorInterest;
use App\Models\Users\Tutors\TutorLanguage;
use App\Models\Users\Tutors\TutorPreferences;
use App\Models\Users\Tutors\TutorProfile;
use App\Models\Users\Tutors\TutorSpecialization;
use App\Models\Users\Tutors\TutorTutoringStyle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TutorController extends Controller
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
            $tutorsCollection = Tutor::where('name', 'like', '%'.$searchKeyword.'%')
                ->orWhere('last_name', 'like', '%'.$searchKeyword.'%')
                ->orWhere('email', 'like', '%'.$searchKeyword.'%')
                ->orWhere('mobile', 'like', '%'.$searchKeyword.'%')
                ->orderBy('created_at', 'DESC')
                ->paginate(20);
        }else{
            //Execute query with pagination
            $tutorsCollection = Tutor::orderBy('created_at', 'DESC')->paginate($perPageRecords);
            $searchKeyword = '';
        }

        return view('admin.tutors.index',[
            'perPageRecords' => $perPageRecords,
            'tutorsCollection' => $tutorsCollection,
            'searchKeyword' => $searchKeyword
        ]);
    }

    /*
     * return: view: admin.tutors.create
     * */
    public function create(){
        return view('admin.tutors.create');
    }

    /**
     * Store a newly created tutor in storage.
     */
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|string', // first name
            'last_name' => 'required|string', // last name
            'email' => 'required|email|unique:tutors',
            'mobile' => 'required|numeric|unique:tutors',
            'password' => 'required|confirmed',
        ]);
        $is_percentage = 1;
        if(is_null($request->get("is_percentage"))){
            $is_percentage = 0;
        }

        $tutor =  Tutor::create([
            'name' => $request->get('name'), // first name
            'last_name' => $request->get('last_name'), // last name
            'mobile' => $request->get('mobile'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'active' => 1, /// active
            'is_percentage' => $is_percentage,
            'charge' => $request->get("charge"),
            'status' => $request->get('status'),
            'referral_code' => TutorCommonHelper::generateReferralCode($request->get('name'))
        ]);

        if($request->get('middle_name')){
            $tutor->middle_name = $request->get('middle_name');
            $tutor->update();
        }

        // create profile with default pic
        $tutor_profile = TutorProfile::create([
            'tutor_id' => $tutor->id
        ]);

        // creating preferences
        $tutor_preferences = TutorPreferences::create([
            'tutor_id' => $tutor->id
        ]);

        // on success will return to the showing the student
//        return redirect()->route('admin.tutor.show',['id' => $tutor->id]);
        return redirect()->route('admin.tutor.edit',['id' => $tutor->id,'tab'=>'profile']);
    }

    /*
     * get: id
     * return: view: admin.tutor.show
     * */
    public function show($id){
        $tutor = Tutor::find($id);
        return view('admin.tutors.show',[
            'tutor' => $tutor
        ]);
    }

    /*
     * get: id
     * return: view: admin.tutor.edit
     * */
    public function edit($id, Request $request){
        $tutor = Tutor::find($id);

        $currentTabsArray = ['info', 'profile'];
        if(empty($request->input('tab')) || !in_array($request->input('tab'), $currentTabsArray)){
            $selectedTab = 'info';
        }else{
            $selectedTab = $request->input('tab');
        }

        return view('admin.tutors.edit',[
            'tutor' => $tutor,
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

        $is_percentage = 1;
        if(is_null($request->get("is_percentage"))){
            $is_percentage = 0;
        }

        $tutor = Tutor::find($id);
        $tutor->name = $request->get('name');
        if($request->has('middle_name')){ $tutor->middle_name = $request->get('middle_name');}
        $tutor->last_name = $request->get('last_name');
        $tutor->email = $request->get('email');
        $tutor->mobile = $request->get('mobile');
//        $tutor->active = ($request->get('status') == '1') ? true : false;
        $tutor->status = $request->get('status');
        $tutor->is_percentage = $is_percentage;
        $tutor->charge = $request->get('charge');
        $tutor->save();

        //Return with success
        session()->flash('success', 'Record updated successfully.');
        return redirect()->route('admin.tutor.edit',['id' => $id,'tab' => 'info']);
    }

    public function updateStatus($id, Request $request){
        $tutor = Tutor::find($id);
        $tutor->status = $request->get('status');
        $tutor->save();
        echo true;
    }

    public function destroy($id)
    {
        Tutor::find($id)->delete();
        TutorProfile::where('tutor_id',$id)->delete();
        TutorPreferences::where('tutor_id',$id)->delete();
        return response()->json(['success'=>true], 200);
    }


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                            Profile picture/video                                      //
    ///////////////////////////////////////////////////////////////////////////////////////////

    /*
 * change profile picture
 * */
    public function changeProfilePicture($id,Request $request){
        if($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');
            $fileExtension = $file->getClientOriginalExtension();
            $file_name = TutorCommonHelper::profile_pic_name().'.'.$fileExtension;

            // deleting the current user profile image from uploaded media
            // if old profile pic is != to default profile picture
            $tutor = Tutor::find($id);
            $tutor_profile = $tutor->profile;
            if($tutor_profile->picture != 'assets/tutor/images/users/default_tutor_image.jpg'){
                // delete old image from file system
                Storage::Delete('public/'.$tutor_profile->picture);
            }
            $file = file_get_contents($file);
            file_put_contents("assets/tutor/uploaded-media/profile-pics/".$file_name, $file);
            $tutor_profile->picture = "assets/tutor/uploaded-media/profile-pics/".$file_name;
            $tutor_profile->update();
            return ['status' => 'success','pic_path' => asset($tutor_profile->picture)]; // return the full public path of picture
        }else{
            return ['status' => 'error','msg' => 'picture not set'];
        }
    }

    /*
     * Remove profile picture
     * */
    public function removeProfilePicture($id){
        // deleting the current user profile picture from uploaded media
        // if old profile video is set
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        if($tutor_profile->picture && $tutor_profile->picture != 'assets/tutor/images/users/default_tutor_image.jpg'){
            // delete old image from file system
            Storage::Delete('public/'.$tutor_profile->picture);
            $tutor_profile->picture = 'assets/tutor/images/users/default_tutor_image.jpg';
            $tutor_profile->update();
            return ['status' => 'success','msg' => 'picture successfully removed','pic_path' => asset($tutor_profile->picture)];
        }else{
            return ['status' => 'error','msg' => 'can not remove picture'];
        }
    }

    /*
     * change profile video
     * */
    public function changeProfileVideo($id,Request $request){
        if($request->hasFile('profile_video')){

            /*
             * Sets the value of the given configuration option.
             *  The configuration option will keep this new value during the script's execution, and will be restored at the script's ending.
             * */
            ini_set('memory_limit','256M');

            $file = $request->file('profile_video');
            $fileExtension = $file->getClientOriginalExtension(); // must have mp4 format
            $file_name = TutorCommonHelper::profile_pic_name().'.'.$fileExtension;

            // deleting the current user profile video from uploaded media
            // if old profile video is set
            $tutor = Tutor::find($id);
            $tutor_profile = $tutor->profile;
            if($tutor_profile->video){
                // delete old video from file system
                Storage::Delete('public/'.$tutor_profile->video);
            }
            $file = file_get_contents($file);
            file_put_contents("assets/tutor/uploaded-media/profile-vids/".$file_name, $file);
            $tutor_profile->video = "assets/tutor/uploaded-media/profile-vids/".$file_name;
            $tutor_profile->update();
            return ['status' => 'success','video_path' => asset($tutor_profile->video)]; // return the full public path of video
        }else{
            return ['status' => 'error','msg' => 'video not set'];
        }
    }

    /*
     * Remove profile video
     * */
    public function removeProfileVideo($id){
        // deleting the current user profile video from uploaded media
        // if old profile video is set
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        if($tutor_profile->video){
            // delete old image from file system
            Storage::Delete('public/'.$tutor_profile->video);
            $tutor_profile->video = null;
            $tutor_profile->update();
            return ['status' => 'success','msg' => 'video successfully removed'];
        }else{
            return ['status' => 'error','msg' => 'not set'];
        }
    }


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                               Specialization                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * add tutor specialization
     * */
    public function addSpecialization($id, Request $request){
        $topic_id = $request->get('topic_id');
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        TutorSpecialization::create([
            'tutor_profile_id' => $tutor_profile->id,
            'topic_id' => $topic_id
        ]);

        $tutor_specializations = $tutor_profile->tutor_specializations;
        $topics = [];
        foreach ($tutor_specializations as $tutor_specialization){
            $topics[] = Topic::find($tutor_specialization->topic_id);
        }
        return [
            'status' => 'success',
            'msg' => 'success',
            'tutor_specializations' => $tutor_specializations,
            'topics' => $topics
        ];
    }

    /*
     * method: delete
     * Remove Tutor Specialization id
     * */
    public function removeSpecialization($id, Request $request){
        $tutor_specialization_id = $request->get('tutor_specialization_id');
        // delete the tutor specialization
        TutorSpecialization::find($tutor_specialization_id)->delete();

        // data
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $tutor_specializations = $tutor_profile->tutor_specializations;
        $topics = [];
        foreach ($tutor_specializations as $tutor_specialization){
            $topics[] = Topic::find($tutor_specialization->topic_id);
        }
        return [
            'status' => 'success',
            'msg' => 'success',
            'tutor_specializations' => $tutor_specializations,
            'topics' => $topics,
            'getTopics' => $this->getTopics($id)
        ];
    }

    /*
     * method get
     * get specialization
     * */
    public function getTopics($id){
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $tutor_specializations = $tutor_profile->tutor_specializations;

        $topics = [];
        if($tutor_specializations->count() > 0){
            $topic_ids = [];
            foreach ($tutor_specializations as $tutor_specialization){
                $topic_ids[] = $tutor_specialization->topic_id;
            }
            $topics = Topic::whereNotIn('id', $topic_ids)->where('status','=','activate')->where('parent','!=',0)->get();
        }else{
            $topics = Topic::where('status','=','activate')->where('parent','!=',0)->get();
        }

        return ['topics' => $topics];
    }


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                     Language                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * Add tutor language
     * */
    public function addLanguage($id,Request $request){
        $language_id = $request->get('language_id');
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        TutorLanguage::create([
            'tutor_profile_id' => $tutor_profile->id,
            'language_id' => $language_id
        ]);
        $tutor_languages = $tutor_profile->tutor_languages;
        $languages = [];
        foreach ($tutor_languages as $tutor_language){
            $languages[] = Language::find($tutor_language->language_id);
        }
        return [
            'status' => 'success',
            'msg' => 'success',
            'tutor_languages' => $tutor_languages,
            'languages' => $languages
        ];
    }

    /*
     * method: delete
     * Remove Tutor Language id
     * */
    public function removeLanguage($id,Request $request){
        $tutor_language_id = $request->get('tutor_language_id');
        // delete the tutor language
        Tutorlanguage::find($tutor_language_id)->delete();

        // data
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $tutor_languages = $tutor_profile->tutor_languages;
        $languages = [];
        foreach ($tutor_languages as $tutor_language){
            $languages[] = Language::find($tutor_language->language_id);
        }
        return [
            'status' => 'success',
            'msg' => 'success',
            'tutor_languages' => $tutor_languages,
            'languages' => $languages,
            'getLanguages' => $this->getLanguages($id)
        ];
    }

    /*
     * method get
     * get language
     * */
    public function getLanguages($id){
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $tutor_languages = $tutor_profile->tutor_languages;

        $languages = [];
        if($tutor_languages->count() > 0){
            $language_ids = [];
            foreach ($tutor_languages as $tutor_language){
                $language_ids[] = $tutor_language->language_id;
            }
            $languages = language::whereNotIn('id', $language_ids)->get();
        }else{
            $languages = language::all();
        }

        return ['languages' => $languages];
    }


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                               Tutoring Style                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////

    /*
     * Add Tutoring Style
     * */
    public function addTutoringStyle($id,Request $request){
        $tutoring_style_id = $request->get('tutoring_style_id');
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        TutorTutoringStyle::create([
            'tutor_profile_id' => $tutor_profile->id,
            'tutoring_style_id' => $tutoring_style_id
        ]);
        $tutor_tutoring_styles =$tutor_profile->tutor_tutoring_styles;
        $tutoring_styles = [];
        foreach ($tutor_profile->tutor_tutoring_styles as $tutor_tutoring_style){
            $tutoring_styles[] = TutoringStyle::find($tutor_tutoring_style->tutoring_style_id);
        }
        return [
            'status' => 'success',
            'msg' => 'success',
            'tutor_tutoring_styles' => $tutor_tutoring_styles,
            'tutoring_styles' => $tutoring_styles
        ];
    }

    /*
     * method: delete
     * Remove Tutor Tutoring Style id
     * */
    public function removeTutoringStyle($id,Request $request){
        $tutor_tutoring_style_id = $request->get('tutor_tutoring_style_id');
        // delete the tutor tutoring style
        TutorTutoringStyle::find($tutor_tutoring_style_id)->delete();

        // data
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $tutor_tutoring_styles = $tutor_profile->tutor_tutoring_styles;
        $tutoring_styles = [];
        foreach ($tutor_tutoring_styles as $tutor_tutoring_style){
            $tutoring_styles[] = TutoringStyle::find($tutor_tutoring_style->tutoring_style_id);
        }
        return [
            'status' => 'success',
            'msg' => 'success',
            'tutor_tutoring_styles' => $tutor_tutoring_styles,
            'tutoring_styles' => $tutoring_styles,
            'getTutoringStyles' => $this->getTutoringStyles($id)
        ];
    }

    /*
     * method get
     * get tutoring style
     * */
    public function getTutoringStyles($id){
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $tutor_tutoring_styles = $tutor_profile->tutor_tutoring_styles;

        $tutoring_styles = [];
        if($tutor_tutoring_styles->count() > 0){
            $tutoring_style_ids = [];
            foreach ($tutor_tutoring_styles as $tutor_tutoring_style){
                $tutoring_style_ids[] = $tutor_tutoring_style->tutoring_style_id;
            }
            $tutoring_styles = TutoringStyle::whereNotIn('id', $tutoring_style_ids)->get();
        }else{
            $tutoring_styles = TutoringStyle::all();
        }

        return ['tutoring_styles' => $tutoring_styles];
    }


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                     Interest                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * Add tutor interests
     * */
    public function addInterests($id,Request $request){
        $interest_id = $request->get('interest_id');
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        TutorInterest::create([
            'tutor_profile_id' => $tutor_profile->id,
            'interest_id' => $interest_id
        ]);
        $tutor_interests = $tutor_profile->tutor_interests;
        $interests = [];
        foreach ($tutor_profile->tutor_interests as $tutor_interest){
            $interests[] = Interest::find($tutor_interest->interest_id);
        }
        return [
            'status' => 'success',
            'msg' => 'success',
            'tutor_interests' => $tutor_interests,
            'interests' => $interests
        ];
    }

    /*
     * method: delete
     * Remove Tutor Interest
     * */
    public function removeInterest($id,Request $request){
        $tutor_interest_id = $request->get('tutor_interest_id');
        // delete the tutor tutoring style
        TutorInterest::find($tutor_interest_id)->delete();

        // data
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $tutor_interests = $tutor_profile->tutor_interests;
        $interests = [];
        foreach ($tutor_interests as $tutor_interest){
            $interests[] = Interest::find($tutor_interest->interest_id);
        }
        return [
            'status' => 'success',
            'msg' => 'success',
            'tutor_interests' => $tutor_interests,
            'interests' => $interests,
            'getInterests' => $this->getInterests($id)
        ];
    }

    /*
     * method get
     * get interest
     * */
    public function getInterests($id){
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $tutor_interests = $tutor_profile->tutor_interests;

        $interests = [];
        if($tutor_interests->count() > 0){
            $tutor_interest_ids = [];
            foreach ($tutor_interests as $tutor_interest){
                $tutor_interest_ids[] = $tutor_interest->interest_id;
            }
            $interests = Interest::whereNotIn('id', $tutor_interest_ids)->get();
        }else{
            $interests = Interest::all();
        }

        return ['interests' => $interests];
    }


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                 Certificates                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * Add Certificates
     * */
    public function addCertificate($id,Request $request){
        $title = $request->get('title');
        $description = $request->get('description');
        $issuing_authority = $request->get('issuing_authority');
        $start_date = Carbon::now();  //$request->get('start_date');
        $end_date = Carbon::now(); //$request->get('end_date');
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        TutorCertification::create([
            'tutor_profile_id' => $tutor_profile->id,
            'title' => $title,
            'description' => $description,
            'issuing_authority' => $issuing_authority,
            'start_time' => $start_date,
            'end_time' => $end_date
        ]);

        $tutor_certifications = $tutor_profile->tutor_certifications;

        return ['status' => 'success','tutor_certifications' => $tutor_certifications];
    }

    /*
     * Update Certification
     * */
    public function updateCertificate($id,Request $request){
        $tutor_certificate_id = $request->get('tutor_certificate_id');
        $title = $request->get('title');
        $description = $request->get('description');
        $issuing_authority = $request->get('issuing_authority');
        $start_date = Carbon::now();  //$request->get('start_date');
        $end_date = Carbon::now(); //$request->get('end_date');
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        if($tutor_certificate_id){
            $tutor_certificate = TutorCertification::find($tutor_certificate_id);
            $tutor_certificate->title = $title;
            $tutor_certificate->description = $description;
            $tutor_certificate->issuing_authority = $issuing_authority;
            $tutor_certificate->start_time = $start_date;
            $tutor_certificate->end_time = $end_date;
            $tutor_certificate->update();
        }
        $tutor_certifications = $tutor_profile->tutor_certifications;

        return ['status' => 'success','tutor_certifications' => $tutor_certifications, "title" => $title];
    }

    /*
     * Delete Certificate
     * */
    public function removeCertification($id,Request $request){
        $tutor_certificate_id = $request->get('tutor_certificate_id');
        // delete the tutor certification
        TutorCertification::find($tutor_certificate_id)->delete();

        // data
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $tutor_certifications = $tutor_profile->tutor_certifications;
        return[
            'status' => 'success',
            'msg' => 'success',
            'tutor_certifications' => $tutor_certifications
        ];

    }

    /*
     * method: post
     * param: tutor_certificate_id
     * return tutor_certificate
     * */
    public function getCertificate(Request $request){
        $tutor_certificate_id = $request->get('tutor_certificate_id');
        $tutor_certificate = TutorCertification::find($tutor_certificate_id);
        return json_encode(['tutor_certificate' => $tutor_certificate]);
    }


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                    Education                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * Add Education
     * */
    public function addEducation($id,Request $request){
        $education = $request->get('education');
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $tutor_profile->education = $education;
        $tutor_profile->update();
        return ['status' => 'success','education' => $tutor_profile->education];
    }

    /*
     * Update Education
     * */
    public function updateEducation($id,Request $request){
        $education = $request->get('education');
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $tutor_profile->education = $education;
        $tutor_profile->update();
        return ['status' => 'success','education' => $tutor_profile->education];
    }


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                 Availability                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * Add Availability
     * */
    public function addAvailabilitySchedule($id,Request $request){
        $data = [];
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $data['tutor_profile_id'] = $tutor_profile->id;

        $start_time_hour = $request->get('start_time_hour');
        $start_time_meridian = $request->get('start_time_meridian');
        $start_time = $start_time_hour . ":00 ". $start_time_meridian;
        $data['start_time'] = Carbon::parse($start_time)->format('H:i:s');

        $end_time_hour = $request->get('end_time_hour');
        $end_time_meridian = $request->get('end_time_meridian');
        $end_time = $end_time_hour . ":00 ". $end_time_meridian;
        $data['end_time'] = Carbon::parse($end_time)->format('H:i:s');

        // not in db model
        $availability_repeat = $request->get('availability_repeat');

        // days
        if($request->has('sun')){
            $sun = $request->get('sun');
            $data['SUN'] = ($sun == 'true') ? 1 : 0;
        }
        if($request->has('mon')){
            $mon = $request->get('mon');
            $data['MON'] = ($mon == 'true') ? 1 : 0;
        }
        if($request->has('tue')){
            $tue = $request->get('tue');
            $data['TUE'] = ($tue == 'true') ? 1 : 0;
        }
        if($request->has('wed')){
            $wed = $request->get('wed');
            $data['WED'] = ($wed == 'true') ? 1 : 0;
        }
        if($request->has('thu')){
            $thu = $request->get('thu');
            $data['THU'] = ($thu == 'true') ? 1 : 0;
        }
        if($request->has('fri')){
            $fri = $request->get('fri');
            $data['FRI'] = ($fri == 'true') ? 1 : 0;
        }
        if($request->has('sat')){
            $sat = $request->get('sat');
            $data['SAT'] = ($sat == 'true') ? 1 : 0;
        }

        // create
        $tutorAvailability = TutorAvailability::create($data);

        return json_encode(['status' => 'success','tutor_availability' => new TutorAvailabilityResources(TutorAvailability::find($tutorAvailability->id))]);
    }

    /*
     * method: delete
    * Remove Tutor Availability
    * */
    public function removeAvailabilitySchedule($id,Request $request){
        $tutor_availability_id = $request->get('tutor_availability_id');
        // delete the tutor availability
        TutorAvailability::find($tutor_availability_id)->delete();

        // data
        $tutor = Tutor::find($id);
        $tutor_profile = $tutor->profile;
        $tutor_availabilities = $tutor_profile->tutor_availabilities;
        return [
            'status' => 'success',
            'msg' => 'success',
            'tutor_availabilities' => $tutor_availabilities
        ];
    }
}
