<?php

namespace App\Http\Controllers\Web\Tutor;


use App\Helpers\TutorCommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Users\Tutors\TutorCardDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
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

    public function index(Request $request){

        $tutor = Auth::user();
        $name = ['first_name' => $tutor->name, 'middle_name' => $tutor->middle_name, 'last_name' => $tutor->last_name];
        $mobile = $tutor->mobile;
        $email = $tutor->email;
        return  view('tutor.settings-account', [
            'name' => $name,
            'mobile' => $mobile,
            'email' => $email,
            'payments' => TutorCommonHelper::tutor_payments_calculation($tutor)
        ]);
    }

    public function tab($tab, Request $request){
        switch ($tab){
            case "pref":{
                return (String) view('tutor.preferences');
            }break;
            case "act-dtls":{
                $tutor = Auth::user();
                $name = ['first_name' => $tutor->name, 'middle_name' => $tutor->middle_name, 'last_name' => $tutor->last_name];
                $mobile = $tutor->mobile;
                $email = $tutor->email;
                return (String) view('tutor.account-details',['name' => $name, 'mobile' => $mobile, 'email' => $email]);
            }break;
            case "card-dtls" : {
                $tutor = Auth::user();
                $cardDetails = $tutor->card_details;
                if($cardDetails){
                    $isCardSet = true;
                    $number = $cardDetails->number;
                    $expiryDate = date('m/y', strtotime($cardDetails->expiryDate));
                    $holder = $cardDetails->holder;
                    $cvv = $cardDetails->cvv;
                }else{
                    $isCardSet = false;
                    $number = '';
                    $expiryDate = '';
                    $holder = '';
                    $cvv = '';
                }
                return (String) view('tutor.card-details',[
                    'isCardSet' => $isCardSet,
                    'number' => $number,
                    'expiryDate' => $expiryDate,
                    'holder' => $holder,
                    'cvv' => $cvv
                ]);
            } break;
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                 Account Settings                                      //
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function updateAccountDetails(Request $request){
        $name = $request->get('first_name');
        $middle_name = $request->get('middle_name');
        $last_name = $request->get('last_name');
        $mobile = $request->get('mobile');
        //$email = $request->get('email');
        //$password = $request->get('password');

        $tutor = Auth::user();
            $tutor->name = $name;
            $tutor->middle_name = $middle_name;
            $tutor->last_name = $last_name;
            $tutor->mobile = $mobile;
        $tutor->update();

       return redirect(route('tutor.account.settings'));
    }


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                          Credit/Debit card Settings                                   //
    ///////////////////////////////////////////////////////////////////////////////////////////

    // add a new card
    public function addCardDetails(Request $request){
        $number = $request->get('number');
        $expiryDate = $request->get('expiry_date');
        $holder = $request->get('holder');
        $cvv = $request->get('cvv');

        // creating new card
        TutorCardDetails::create([
            'tutor_id' => Auth::id(),
            'number' => $number,
            'expiryDate' => $expiryDate,
            'holder' => $holder,
            'cvv' => $cvv,
        ]);

        return redirect(route('tutor.account.settings',['tab' => 'cardDetails']));
    }

    // update
    public function updateCardDetails(Request $request){
        $number = $request->get('number');
        $expiryDate = $request->get('expiry_date');
        $holder = $request->get('holder');
        $cvv = $request->get('cvv');

        $cardDetails = TutorCardDetails::where(['tutor_id' => Auth::id()])->first();
        $cardDetails->number = $number;
        $cardDetails->expiryDate = $expiryDate;
        $cardDetails->holder = $holder;
        $cardDetails->cvv = $cvv;
        $cardDetails->update();

        return redirect(route('tutor.account.settings',['tab' => 'cardDetails']));
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                 Preferences                                           //
    ///////////////////////////////////////////////////////////////////////////////////////////
    // update preferences
    public function updatePreferences(Request $request){

        $language =  $request->get("language");
        $timezone =  $request->get("timezone");
        $emailNotification = $request->get("emailNotification");
        $desktopNotification =  $request->get("desktopNotification");

        $tutor = Auth::user();
        $tutorPreferences =  $tutor->preferences;
        $tutorPreferences->language = $language;
        $tutorPreferences->timezone = $timezone;
        $tutorPreferences->emailNotification = ($emailNotification == null) ? 0 : 1;
        $tutorPreferences->desktopNotification = ($desktopNotification == null) ? 0 : 1;
        $tutorPreferences->update();

        return redirect()->route('tutor.account.settings',['tab'=>'preferences']);
    }
}