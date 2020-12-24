<?php

namespace App\Http\Controllers;


use App\Models\Notification;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        //Get the sub-domain
        $domainPieces = explode('.', $request->getHost());
        $domainSlug = $domainPieces[0];

        switch ($domainSlug){
            case "tutor" : {return redirect()->route('tutor.home');} break;
            case "student" : {return redirect()->route('student.home');} break;
            case "portal" : {return redirect()->route('admin.home');} break;
            default:{
                // No found, send 404
                abort(404);
            }
        }
    }

    public function removeNotification(Request $request){
        $id = $request->get('id');
        Notification::where('id', $id)->update(['status' => 1]);
        return $this->respond(['data' => [], 'errors' => [], 'status' => 'success', 'status_code' => 200]);
    }
}
