<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Authority
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$authorities)
    {
        $user = $request->user();

        if($user->isSuperAdmin()) {
            return $next($request);
        }

        foreach($authorities as $authority) {
            // Check if user has the $authoritie This check will depend on how your authorities are set up
            if($user->hasAuthority($authority)) {
                return $next($request);
            }
        }
        //return response('Unauthorized.', 401);
        return redirect()->route('home');
        //return view('errors.404');
        //return $next($request);
        //return response()->error('Access denied!', 403);
    }
}
