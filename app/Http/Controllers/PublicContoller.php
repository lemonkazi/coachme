<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use View;
use Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;


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
     
     $rules = array(
            'email'  => 'required|string|email|max:255',
            'password' => 'required|min:5'
          );    
      $messages = array(
                'email.required' => trans('messages.email.required'),
                'email.string' => trans('messages.email.string'),
                'email.email' => trans('messages.email.email'),
                'email.max' => trans('messages.email.max'),
                'password.required' => trans('messages.password.required'),
                'password.min' => trans('messages.password.min')
              );
    $validator = Validator::make( $data, $rules, $messages );

    if ( $validator->fails() ) 
    {
      return response()->json(['errors'=>$validator->errors()->all()]);
    }
    else
    {
      $user = User::where([
                ['email', $data['email']],
           ])->first();
      if ($user) {
          if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
              //return redirect(route('home'));
              if ($user->isSuperAdmin()) {
                return response()->json(['success'=>true,'result'=>trans('messages.success_message'),'url'=> route('home')]);
                 // return redirect()->intended(route('home'));
              } elseif (!$user->isSuperAdmin()) {
                return response()->json(['success'=>true,'result'=>trans('messages.success_message'),'url'=> RouteServiceProvider::ROOT]);
                  //return redirect(RouteServiceProvider::ROOT);
              }
              
          }
      }
      return response()->json(['errors'=>['Login failed, please try again!']]);
    }


      
    }

    private function validator(Request $request)
    {
        $rules = [
            'email'    => 'required|email|min:5|max:191',
            'password' => 'required|string|min:6|max:255'
        ];
        $request->validate($rules);
    }

    public function username()
    {
        return 'email';
    }
}