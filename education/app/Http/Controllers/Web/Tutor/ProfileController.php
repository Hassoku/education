<?php

namespace App\Http\Controllers\Web\Tutor;


use App\Helpers\CommonHelper;
use App\Helpers\TutorCommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tutor as TutorResources;
use App\Models\Interest;
use App\Models\Language;
use App\Models\Specialization;
use App\Models\Topic;
use App\Models\TutoringStyle;
use App\Models\Users\Tutors\Tutor;
use App\Models\Users\Tutors\TutorAvailability;
use App\Http\Resources\TutorAvailability as TutorAvailabilityResources;
use App\Models\Users\Tutors\TutorCertification;
use App\Models\Users\Tutors\TutorInterest;
use App\Models\Users\Tutors\TutorLanguage;
use App\Models\Users\Tutors\TutorSpecialization;
use App\Models\Users\Tutors\TutorTutoringStyle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
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
        $this->middleware('auth:tutor');
    }

    /*
     * method: get
     * return : tutor.profile view
     * */
    public function index(){
        $tutor = Auth::user();
        $tutor_profile = $tutor->profile;
        $tutor_rating = $tutor_profile->rating();

        $tutor_first_name = $tutor->name; // first name
        $tutor_middle_name = $tutor->middle_name; // middle name
        $tutor_last_name = $tutor->last_name; // last name
        $tutor_name  = $tutor_first_name . ' ';
        $tutor_name .= (($tutor_middle_name != null) ? $tutor_middle_name : '') . ' ';
        $tutor_name .= $tutor_last_name;

        $tutor_profile_pic = $tutor_profile->picture;
        $tutor_profile_video = $tutor_profile->video;
        $tutor_specializations = $tutor_profile->tutor_specializations;
        $tutor_languages = $tutor_profile->tutor_languages;
        $tutor_tutoring_styles = $tutor_profile->tutor_tutoring_styles;
        $tutor_interests = $tutor_profile->tutor_interests;
        $tutor_certifications = $tutor_profile->tutor_certifications;
        $tutor_education = $tutor_profile->education;
        $tutor_availabilities = $tutor_profile->tutor_availabilities;



        return view('tutor.profile',[
            'tutor_profile_pic'=> $tutor_profile_pic,
            'tutor_profile_video' => $tutor_profile_video,
            'tutor_rating' => $tutor_rating,
            'tutor_name' => $tutor_name,
            'tutor_specializations' => $tutor_specializations,
            'tutor_languages' => $tutor_languages,
            'tutor_tutoring_styles' => $tutor_tutoring_styles,
            'tutor_interests' => $tutor_interests,
            'tutor_certifications' => $tutor_certifications,
            'tutor_education' => $tutor_education,
            'tutor_availabilities' => $tutor_availabilities,

            'payments' => TutorCommonHelper::tutor_payments_calculation($tutor),
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                   Profile                                             //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * method: get
     * return: tutor.add-profile
     * */
    public function addProfile(){
        $tutor = Auth::user();
        $tutor_profile = $tutor->profile;

        $tutor_first_name = $tutor->name; // first name
        $tutor_middle_name = $tutor->middle_name; // middle name
        $tutor_last_name = $tutor->last_name; // last name
        $tutor_name  = $tutor_first_name . ' ';
        $tutor_name .= (($tutor_middle_name != null) ? $tutor_middle_name : '') . ' ';
        $tutor_name .= $tutor_last_name;

        $tutor_profile_pic = $tutor_profile->picture;
        $tutor_profile_video = $tutor_profile->video;
        $tutor_specializations = $tutor_profile->tutor_specializations;
        $tutor_languages = $tutor_profile->tutor_languages;
        $tutor_tutoring_styles = $tutor_profile->tutor_tutoring_styles;
        $tutor_interests = $tutor_profile->tutor_interests;
        $tutor_certifications = $tutor_profile->tutor_certifications;
        $tutor_education = $tutor_profile->education;
        $tutor_availabilities = $tutor_profile->tutor_availabilities;

        return view('tutor.add-profile',[
            'tutor_profile_pic'=> $tutor_profile_pic,
            'tutor_name' => $tutor_name,
            'tutor_specializations' => $tutor_specializations,
            'tutor_profile_video' => $tutor_profile_video,
            'tutor_languages' => $tutor_languages,
            'tutor_tutoring_styles' => $tutor_tutoring_styles,
            'tutor_interests' => $tutor_interests,
            'tutor_certifications' => $tutor_certifications,
            'tutor_education' => $tutor_education,
            'tutor_availabilities' => $tutor_availabilities
        ]);
    }

    /*
     * change profile picture
     * */
    public function changeProfilePicture(Request $request){
        if($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');
            $fileExtension = $file->getClientOriginalExtension();
            $file_name = TutorCommonHelper::profile_pic_name().'.'.$fileExtension;

            // deleting the current user profile image from uploaded media
            // if old profile pic is != to default profile picture
            $tutor_profile = Auth::user()->profile;
            if($tutor_profile->picture != 'assets/tutor/images/users/default_tutor_image.jpg'){
                // delete old image from file system
                Storage::Delete('public/'.$tutor_profile->picture);
            }
            $file = file_get_contents($file);
            file_put_contents("assets/tutor/uploaded-media/profile-pics/".$file_name, $file);
            $tutor_profile->picture = "assets/tutor/uploaded-media/profile-pics/".$file_name;
            $tutor_profile->update();
            return ['pic_path' => asset($tutor_profile->picture)]; // return the full public path of picture
        }else{
            return ['msg' => 'not set'];
        }
    }

    /*
     * change profile video
     * */
    public function changeProfileVideo(Request $request){
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
            $tutor_profile = Auth::user()->profile;
            if($tutor_profile->video){
                // delete old video from file system
                Storage::Delete('public/'.$tutor_profile->video);
            }
            $file = file_get_contents($file);
            file_put_contents("assets/tutor/uploaded-media/profile-vids/".$file_name, $file);
            $tutor_profile->video = "assets/tutor/uploaded-media/profile-vids/".$file_name;
            $tutor_profile->update();
            return ['video_path' => asset($tutor_profile->video)]; // return the full public path of video
        }else{
            return ['msg' => 'not set'];
        }
    }

    /*
     * Remove profile video
     * */
    public function removeProfileVideo(){
        // deleting the current user profile video from uploaded media
        // if old profile video is set
        $tutor_profile = Auth::user()->profile;
        if($tutor_profile->video){
            // delete old image from file system
            Storage::Delete('public/'.$tutor_profile->video);
            $tutor_profile->video = null;
            $tutor_profile->update();
            return ['msg' => 'success'];
        }else{
            return ['msg' => 'not set'];
        }
    }


    ///////////////////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                               Specialization                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * add tutor specialization
     * */
    public function addSpecialization(Request $request){
        $topic_id = $request->get('topic_id');
        $tutor_profile = Auth::user()->profile;
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
            'msg' => 'success',
            'tutor_specializations' => $tutor_specializations,
            'topics' => $topics
        ];
    }

    /*
     * method: delete
     * Remove Tutor Specialization id
     * */
    public function removeSpecialization(Request $request){
        $tutor_specialization_id = $request->get('tutor_specialization_id');
        // delete the tutor specialization
        TutorSpecialization::find($tutor_specialization_id)->delete();

        // data
        $tutor = Auth::user();
        $tutor_profile = $tutor->profile;
        $tutor_specializations = $tutor_profile->tutor_specializations;
        $topics = [];
        foreach ($tutor_specializations as $tutor_specialization){
            $topics[] = Topic::find($tutor_specialization->topic_id);
        }
        return ['msg' => 'success',
            'tutor_specializations' => $tutor_specializations,
            'topics' => $topics,
            'getTopics' => $this->getTopics()
        ];
    }

    /*
     * method get
     * get specialization
     * */
    public function getTopics(){
        $tutor = Auth::user();
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


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                     Language                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * Add tutor language
     * */
    public function addLanguage(Request $request){
        $language_id = $request->get('language_id');
        $tutor_profile = Auth::user()->profile;
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
            'msg' => 'success',
            'tutor_languages' => $tutor_languages,
            'languages' => $languages
        ];
    }

    /*
     * method: delete
     * Remove Tutor Language id
     * */
    public function removeLanguage(Request $request){
        $tutor_language_id = $request->get('tutor_language_id');
        // delete the tutor language
        Tutorlanguage::find($tutor_language_id)->delete();

        // data
        $tutor = Auth::user();
        $tutor_profile = $tutor->profile;
        $tutor_languages = $tutor_profile->tutor_languages;
        $languages = [];
        foreach ($tutor_languages as $tutor_language){
            $languages[] = Language::find($tutor_language->language_id);
        }
        return ['msg' => 'success',
            'tutor_languages' => $tutor_languages,
            'languages' => $languages,
            'getLanguages' => $this->getLanguages()
        ];
    }

    /*
     * method get
     * get language
     * */
    public function getLanguages(){
        $tutor = Auth::user();
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



///////////////////////////////////////////////////////////////////////////////////////////
    //                                    State and Country                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * Add State and Country
     * */
    public function addStateCountry(Request $request){
        $state = $request->get('state');
        $country = $request->get('country');
        
        $tutor_profile = Auth::user()->profile;
        $tutor_profile->state = $state;
        $tutor_profile->country = $country;
        $tutor_profile->update();
        return ['state' => $tutor_profile->state, 'country'=>$tutor_profile->country];
    }

    /*
     * Update State and Country
     * */
    public function updateStateCountry(Request $request){
        $state = $request->get('state');
        $country = $request->get('country');
        $tutor_profile = Auth::user()->profile;
        $tutor_profile->state = $state;
        $tutor_profile->country = $country;
        $tutor_profile->update();
        return ['state' => $tutor_profile->state, 'country'=>$tutor_profile->country];
    }

    ///////////////////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                               Tutoring Style                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////

    /*
     * Add Tutoring Style
     * */
    public function addTutoringStyle(Request $request){
        $tutoring_style_id = $request->get('tutoring_style_id');
        $tutor_profile = Auth::user()->profile;
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
            'msg' => 'success',
            'tutor_tutoring_styles' => $tutor_tutoring_styles,
            'tutoring_styles' => $tutoring_styles
        ];
    }

    /*
     * method: delete
     * Remove Tutor Tutoring Style id
     * */
    public function removeTutoringStyle(Request $request){
        $tutor_tutoring_style_id = $request->get('tutor_tutoring_style_id');
        // delete the tutor tutoring style
        TutorTutoringStyle::find($tutor_tutoring_style_id)->delete();

        // data
        $tutor = Auth::user();
        $tutor_profile = $tutor->profile;
        $tutor_tutoring_styles = $tutor_profile->tutor_tutoring_styles;
        $tutoring_styles = [];
        foreach ($tutor_tutoring_styles as $tutor_tutoring_style){
            $tutoring_styles[] = TutoringStyle::find($tutor_tutoring_style->tutoring_style_id);
        }
        return ['msg' => 'success',
            'tutor_tutoring_styles' => $tutor_tutoring_styles,
            'tutoring_styles' => $tutoring_styles,
            'getTutoringStyles' => $this->getTutoringStyles()
        ];
    }

    /*
     * method get
     * get tutoring style
     * */
    public function getTutoringStyles(){
        $tutor = Auth::user();
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


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                     Interest                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * Add tutor interests
     * */
    public function addInterests(Request $request){
        $interest_id = $request->get('interest_id');
        $tutor_profile = Auth::user()->profile;
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
            'msg' => 'success',
            'tutor_interests' => $tutor_interests,
            'interests' => $interests
        ];
    }

    /*
     * method: delete
     * Remove Tutor Interest
     * */
    public function removeInterest(Request $request){
        $tutor_interest_id = $request->get('tutor_interest_id');
        // delete the tutor tutoring style
        TutorInterest::find($tutor_interest_id)->delete();

        // data
        $tutor = Auth::user();
        $tutor_profile = $tutor->profile;
        $tutor_interests = $tutor_profile->tutor_interests;
        $interests = [];
        foreach ($tutor_interests as $tutor_interest){
            $interests[] = Interest::find($tutor_interest->interest_id);
        }
        return ['msg' => 'success',
            'tutor_interests' => $tutor_interests,
            'interests' => $interests,
            'getInterests' => $this->getInterests()
        ];
    }

    /*
     * method get
     * get interest
     * */
    public function getInterests(){
        $tutor = Auth::user();
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


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                 Certificates                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * Add Certificates
     * */
    public function addCertificate(Request $request){
        $title = $request->get('title');
        $description = $request->get('description');
        $issuing_authority = $request->get('issuing_authority');
        $start_date = Carbon::now();  //$request->get('start_date');
        $end_date = Carbon::now(); //$request->get('end_date');
        $tutor_profile = Auth::user()->profile;
        TutorCertification::create([
            'tutor_profile_id' => $tutor_profile->id,
            'title' => $title,
            'description' => $description,
            'issuing_authority' => $issuing_authority,
            'start_time' => $start_date,
            'end_time' => $end_date
        ]);

        $tutor_certifications = $tutor_profile->tutor_certifications;

        return ['tutor_certifications' => $tutor_certifications];
    }

    /*
     * Update Certification
     * */
    public function updateCertificate(Request $request){
        $tutor_certificate_id = $request->get('tutor_certificate_id');
        $title = $request->get('title');
        $description = $request->get('description');
        $issuing_authority = $request->get('issuing_authority');
        $start_date = Carbon::now();  //$request->get('start_date');
        $end_date = Carbon::now(); //$request->get('end_date');
        $tutor_profile = Auth::user()->profile;
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

        return ['tutor_certifications' => $tutor_certifications, "title" => $title];
    }

    /*
     * Delete Certificate
     * */
    public function removeCertification(Request $request){
        $tutor_certificate_id = $request->get('tutor_certificate_id');
        // delete the tutor certification
        TutorCertification::find($tutor_certificate_id)->delete();

        // data
        $tutor = Auth::user();
        $tutor_profile = $tutor->profile;
        $tutor_certifications = $tutor_profile->tutor_certifications;
        return[
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


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                    Education                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * Add Education
     * */
    public function addEducation(Request $request){
        $education = $request->get('education');
        $tutor_profile = Auth::user()->profile;
        $tutor_profile->education = $education;
        $tutor_profile->update();
        return ['education' => $tutor_profile->education];
    }

    /*
     * Update Education
     * */
    public function updateEducation(Request $request){
        $education = $request->get('education');
        $tutor_profile = Auth::user()->profile;
        $tutor_profile->education = $education;
        $tutor_profile->update();
        return ['education' => $tutor_profile->education];
    }

    ///////////////////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                 Availability                                          //
    ///////////////////////////////////////////////////////////////////////////////////////////
    /*
     * Add Availability
     * */
    public function addAvailabilitySchedule(Request $request){
        $data = [];
        $tutor_profile = Auth::user()->profile;
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

        return json_encode(['tutor_availability' => new TutorAvailabilityResources(TutorAvailability::find($tutorAvailability->id))]);
    }

    /*
     * method: delete
    * Remove Tutor Availability
    * */
    public function removeAvailabilitySchedule(Request $request){
        $tutor_availability_id = $request->get('tutor_availability_id');
        // delete the tutor availability
        TutorAvailability::find($tutor_availability_id)->delete();

        // data
        $tutor = Auth::user();
        $tutor_profile = $tutor->profile;
        $tutor_availabilities = $tutor_profile->tutor_availabilities;
        return [
            'msg' => 'success',
            'tutor_availabilities' => $tutor_availabilities
        ];
    }
}