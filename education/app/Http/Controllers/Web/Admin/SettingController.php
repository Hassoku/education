<?php

namespace App\Http\Controllers\Web\Admin;


use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tutor as TutorResources;
use App\Models\Interest;
use App\Models\Language;
use App\Models\LearningSessions\LearningSession;
use App\Models\SubscriptionPackage;
use App\Models\TutoringStyle;
use App\Models\Users\Students\Student;
use App\Models\Users\Tutors\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        /*
         * Authorized users only
         */
        $this->middleware('auth:admin');
    }


    public function index(Request $request){
        $subscriptionPackagesCollection = SubscriptionPackage::all();
        $languagesCollection = Language::all();
        $tutoringStylesCollection =  TutoringStyle::all();
        $interestsCollection =  Interest::all();

        $currentTabsArray = ['subscription_package', 'language', 'tutoring_style', 'interest', 'account_setting', 'security'];
        if(empty($request->input('tab')) || !in_array($request->input('tab'),$currentTabsArray)){
            $selectedTab = 'subscription_package';
        }else{
            $selectedTab = $request->input('tab');
        }

        return view('admin.settings.settings',[
            'selectedTab' => $selectedTab,
            'subscriptionPackagesCollection' => $subscriptionPackagesCollection,
            'languagesCollection' => $languagesCollection,
            'tutoringStylesCollection' => $tutoringStylesCollection,
            'interestsCollection' => $interestsCollection
        ]);
    }

    /*
     * Add Subscription Package
     * */
    public function addSubscriptionPackage(Request $request){
        $minutes = $request->get('minutes');
        $price = $request->get('price');
        $type = $request->get('type');

        $sub_pkg = SubscriptionPackage::create([
            'minutes' => $minutes,
            'price' => $price,
            'type' => $type, // individual,group
        ]);

        return ['status' => 'success', 'sub_pkg' => $sub_pkg];
    }

    /*
     * Edit Subscription Package
     * */
    public function addSubscriptionPackageEdit($id, Request $request){
        $sub_pkg = SubscriptionPackage::find($id);
        return view('admin.settings.subscriptionPackages.edit',[
            'sub_pkg' => $sub_pkg
        ]);
    }

    /*
     * Update Subscription Package
     * */
    public function addSubscriptionPackageUpdate($id, Request $request){
        $this->validate($request, [
            'minutes' => 'required|numeric',
            'price' => 'required|numeric',
            'type' => 'required',
        ]);

        $minutes = $request->get('minutes');
        $price = $request->get('price');
        $type = $request->get('type');

        $sub_pkg = SubscriptionPackage::find($id);
            $sub_pkg->minutes = $minutes;
            $sub_pkg->price = $price;
            $sub_pkg->type = $type;
         $sub_pkg->save();

         return redirect()->route('admin.settings',['tab' => 'subscription_package']);
    }


    /*
     * Add language
     * */
    public function addLanguage(Request $request){
        $language = $request->get('language');
        $lang = Language::create([
           'language' => $language
        ]);

        return ['status' => 'success', 'language' => $lang];
    }

    /*
     * Delete Language
     * */
    public function deleteLanguage(Request $request){
        $language_id = $request->get('language_id');

    }



    /*
     * Add tutoring Style
     * */
    public function addTutoringStyle(Request $request){
        $tutoring_style = $request->get('tutoring_style');
        $tutoringStyle = TutoringStyle::create([
           'tutoring_style' => $tutoring_style
        ]);

        return ['status' => 'success', 'tutoring_style' => $tutoringStyle];
    }

    /*
     * Edit tutoring Style
     * */
    public function editTutoringStyle(Request $request){
        $tutoring_style_id = $request->get('tutoring_style_id');
        $tutoring_style = $request->get('tutoring_style');
        $tutoringStyle = TutoringStyle::find($tutoring_style_id);
            $tutoringStyle->tutoring_style = $tutoring_style;
        $tutoringStyle->save();

        return ['status' => 'success'];
    }

    /*
     * Add tutoring Style
     * */
    public function addInterest(Request $request){
        $interest = $request->get('interest');
        $intr =Interest::create([
           'interest' => $interest
        ]);

        return ['status' => 'success', 'interest' => $intr];
    }

    /*
     * Edir Interest
     * */
    public function editInterest(Request $request){
        $interest_id = $request->get('interest_id');
        $interest = $request->get('interest');
        $intr =Interest::find($interest_id);
        $intr->interest = $interest;
        $intr->save();

        return ['status' => 'success'];
    }


}