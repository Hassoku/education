<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyStudentIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->status == 'active'){
            return $next($request);
        }else {
            if (Auth::guard('student')->check()) {
                return redirect()->route('student.profile.show');
            }
            if (Auth::guard('api')->check()) {
                return json_encode([
                    'status' => 'error',
                    'student' => Auth::user(),
                    'msg' => 'Your account ('.Auth::user()->email.') is '.Auth::user()->status.'. Please contact with duroos support for further details']);
            }
         }
    }
}