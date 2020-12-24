<?php

namespace App\Http\Controllers\Web\Admin\Auth;


use App\Http\Controllers\Controller;
use App\Models\Users\Admin\Admin;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    // after registrations
    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        if (Auth::check()) {
            // if admin is logged in
            return redirect()->route('admin.dashboard');
        }
        $this->middleware('guest:admin');
    }

    public function showRegistrationForm()
    {
        return view('admin.auth.registration');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:admins',
            'password' => 'required|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    protected function guard()
    {
        return Auth::guard('admin');
    }



}
