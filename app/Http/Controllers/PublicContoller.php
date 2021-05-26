<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use View;
use Auth;
use Illuminate\Support\Collection;


use App\Providers\RouteServiceProvider;


class PublicContoller extends Controller
{
    
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        //$this->middleware('auth');
        //$this->middleware(['auth', 'verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make('pages.home');
    }


    public function verifyUser($token)
    {
        $user = User::where('token', $token)->first();


      if(isset($user) ){
        //$user = $verifyUser->user;
        if(!$user->is_verified || $user->email_verified_at ==null) {
          $user->is_verified = true;
          $user->email_verified_at = now();
          $user->save();
          $status = "Your e-mail is verified. You can now login.";
        } else {
          $status = "Your e-mail is already verified. You can now login.";
        }
      } else {
        return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
      }
      return redirect('/login')->with('status', $status);
    }

    /**
     * Display login.
     *
     * @return Response
     */
    public function login()
    {
      if (Auth::check()) {
          $user = Auth::user();
          if ($user->isSuperAdmin()) {
              return redirect()->intended(route('home'));
          } elseif (!$user->isSuperAdmin()) {
              return redirect(RouteServiceProvider::ROOT);
          }
      }
      return View::make('auth.publiclogin', ['title' => 'User Login','pageInfo'=>['siteTitle'=>'COACH ME']]);
    }

    public function publiclogin(Request $request)
    {
      $data = $request->all();
        
        $this->validator($request);

        $user = User::where([
                                ['email', $data['email']],
                           ])->first();
        if ($user) {
            
            //Auth::logout();
            if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
                if ($user->isSuperAdmin()) {
                    return redirect()->intended(route('home'));
                } elseif (!$user->isSuperAdmin()) {
                    return redirect(RouteServiceProvider::ROOT);
                }
                
            }
        }
        
        return redirect()->back()->withInput()->with('error', 'Login failed, please try again!');
        // if (Auth::guard()->attempt($request->only('email', 'password'), $request->filled('remember'))) {
        //     return redirect()->intended(route('admin.home'));
        // }
        // return redirect()->back()->withInput()->with('error', 'Login failed, please try again!');
    }

    private function validator(Request $request)
    {
        $rules = [
            'email'    => 'required|email|min:5|max:191',
            'password' => 'required|string|min:4|max:255'
        ];
        $request->validate($rules);
    }

    public function username()
    {
        return 'email';
    }
}