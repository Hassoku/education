<?php

namespace App\Http\Controllers\Api\V1;


use App\Helpers\StudentCommonHelper;
use App\Http\Resources\Student as StudentResource;
use App\Models\Users\Students\Student;
use Dingo\Api\Http\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentController extends BaseController
{
    public function index(){

    }

    /*
     * Get student
     * */
    public function show($id){
        $student = Student::findOrFail($id);
        return new StudentResource($student);
    }

    /*
     * Get the authenticated Student
     * */
    public function me(){
        $student = Auth::user();
        return new StudentResource($student);
    }

    /*
     * Update Me
     * Method: POST
     * */
    public function updateMe(Request $request){

        $student = Auth::user();

        // first name
        if($request->has('first_name')){
            $student->name = $request->get('first_name');
            $student->update();
        }
        
        try{
            // email
            if($request->has('email')){
                $student->email = $request->get('email');
                $student->update();
            }
        }catch (Exception $exception){
            return response()->json(["Error" => "This Email Already In Use!"], 500);
        }
        // middle name
        if($request->has('middle_name')){
            $student->middle_name = $request->get('middle_name');
            $student->update();
        }
        // last name
        if($request->has('last_name')){
            $student->last_name = $request->get('last_name');
            $student->update();
        }
        // mobile
        if($request->has('mobile')){
            $student->mobile = $request->get('mobile');
            $student->update();
        }

        // update profile picture
        if($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');
            $fileExtension = $file->getClientOriginalExtension();
            $file_name = StudentCommonHelper::profile_pic_name().'.'.$fileExtension;

            // deleting the current user profile image from uploaded media
            // if old profile pic is != to default profile picture
            $student_profile = $student->profile;
            if($student_profile->picture != 'assets/student/images/users/default_student_image.jpg'){
                // delete old image from file system
                Storage::Delete('public/'.$student_profile->picture);
            }
            $file = file_get_contents($file);
            file_put_contents("assets/student/uploaded-media/profile-pics/".$file_name, $file);
            $student_profile->picture = "assets/student/uploaded-media/profile-pics/".$file_name;
            $student_profile->update();
//            return ['status' => 'success','pic_path' => asset($student_profile->picture)]; // return the full public path of picture
        }else{
//            return ['status' => 'error','msg' => 'picture not updated'];
        }

        // return the student.
        $student = Auth::user();
        return new StudentResource($student);
    }


    /*
     * update password
     * */
    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $student = Auth::user();
        $auth = Auth::once([
            'email' => $student->email,
            'password' => $request->get('old_password')
        ]);
        // if old_password wrong
        if (!$auth) {
            return Response::makeFromJson(
                JsonResponse::create(['error-msg' => "invalid password"]))->statusCode(401);
        }
        $student->password = Hash::make(($request->get('password')));
        $student->update();
        return $this->response->noContent();
    }

}
