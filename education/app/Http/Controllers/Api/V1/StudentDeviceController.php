<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Users\Students\StudentDevice;
use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentDeviceController extends BaseController
{
    /*
     * Store the Student Device
     * */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required|string',
            'platform' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $student_device = new StudentDevice();
        $student_device->fcm_token = $request->get("fcm_token");
        $student_device->platform = $request->get("platform");
        $student_device->save();

        return Response::makeFromJson(
            JsonResponse::create(['success' => 'token success fully stored']))->statusCode(200);
    }

    /*
     * Assign the device to current authenticated user
     * */
    public function assignToMe(Request $request){
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $student_device = new StudentDevice();
        $student_device->fcm_token = $request->get("fcm_token");
        $student_device->student_id = $this->user()->id;
        $student_device->save();

        return $this->response->noContent();
    }
}