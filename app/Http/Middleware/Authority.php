<?php

namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
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
        // if ($user->isSuperAdmin()) {
        //     return redirect()->route('home');
        // } elseif (!$user->isSuperAdmin()) {
            return response()->view('errors.404');
        //}
        //return response('Unauthorized.', 401);
        
        //return response()->error('Access denied!', 403);
    }
}
