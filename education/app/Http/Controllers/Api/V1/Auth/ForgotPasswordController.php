<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\BaseController;
use App\Models\Users\Authorization;
use App\Models\Users\Student;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\Authorization as AuthorizationResource;

class ForgotPasswordController extends BaseController
{
    // return the password reset link
    public function restPassword(){
        return redirect()->route('student.password.request');
    }
}
