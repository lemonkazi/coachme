<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = User::where([
                                ['email', $request['email']],
                           ])->first();
                if ($user) {
                    
                    //Auth::logout();
                        if ($user->isSuperAdmin()) {
                            return redirect(RouteServiceProvider::HOME);
                        } 
                        elseif ($user->isCoachUser()) {
                            return redirect(RouteServiceProvider::COACH_PROFILE);
                        }
                        elseif ($user->isRinkUser()) {
                            return redirect(RouteServiceProvider::RINKLIST);
                        } 
                        else{
                            return redirect(RouteServiceProvider::ROOT);
                        }
                }

                
            }
        }

        return $next($request);
    }
}
