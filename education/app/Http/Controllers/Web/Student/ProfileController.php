<?php

namespace App\Http\Controllers\Web\Student;


use App\Helpers\StudentCommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        /*
         * Authorized users only
         */
        $this->middleware('auth:student');
    }

    public function index(){
        $student = Auth::user();
        $student_profile = $student->profile;

        $student_profile_pic = $student_profile->picture;

        $student_first_name = $student->name; // first name
        $student_middle_name = $student->middle_name; // middle name
        $student_last_name = $student->last_name; // last name
        $student_name  = $student_first_name . ' ';
        $student_name .= (($student_middle_name != null) ? $student_middle_name : '') . ' ';
        $student_name .= $student_last_name;
        

       
        return view('student.profile',[
            'student_profile_pic' => $student_profile_pic,
            'student_name' => $student_name
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////////////////////////////////////
    //                                   Profile                                             //
    ///////////////////////////////////////////////////////////////////////////////////////////

    /*
     * change profile picture
     * */
    public function changeProfilePicture(Request $request){
        if($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');
            $fileExtension = $file->getClientOriginalExtension();
            $file_name = StudentCommonHelper::profile_pic_name().'.'.$fileExtension;

            // deleting the current user profile image from uploaded media
            // if old profile pic is != to default profile picture
            $student_profile = Auth::user()->profile;
            if($student_profile->picture != 'assets/student/images/users/default_student_image.jpg'){
                // delete old image from file system
                Storage::Delete('public/'.$student_profile->picture);
            }
            $file = file_get_contents($file);
            file_put_contents("assets/student/uploaded-media/profile-pics/".$file_name, $file);
            $student_profile->picture = "assets/student/uploaded-media/profile-pics/".$file_name;
            $student_profile->update();
            return ['pic_path' => asset($student_profile->picture)]; // return the full public path of picture
        }else{
            return ['msg' => 'not set'];
        }
    }
}