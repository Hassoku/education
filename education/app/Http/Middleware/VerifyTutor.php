<?php
namespace App\Http\Middleware;

use Closure;

class VerifyTutor
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
        //Get the sub-domain
        $domainPieces = explode('.', $request->getHost());
        $domainSlug = $domainPieces[0];
        //print_r($domainPieces);
        //print 'In School Domain:'.$domainSlug;
        //exit;

        // if($domainSlug == 'tutor'){
            return $next($request);
        // }else {
        //     /*
        //      * No found, send 404
        //      */
        //     abort(404);
        //  }
    }
}