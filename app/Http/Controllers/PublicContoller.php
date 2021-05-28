<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use View;
use Auth;
use App\Mail\VerifyMail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Auth\RegistersUsers;


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
        $authority = array(
            'COACH_USER' => trans('global.LABEL_COACH_USER'),
            'RINK_USER' => trans('global.LABEL_RINK_USER')
        );
        return view('pages.home')
        ->with(compact('authority'));

        //return View::make('pages.home');
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
        return redirect('/')->with('warning', "Sorry your email cannot be identified.");
      }
      return redirect('/')->with('status', $status);
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
                  ['deleted_at', null],
             ])->first();
        if ($user) {
            $usernotVerified = User::where([
                  ['email', $data['email']],
                  ['email_verified_at', null]
            ])->first();
            if ($usernotVerified) {
              return response()->json(['errors'=>['email not verified please verify']]);
            }
            if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
                
                if ($user->isSuperAdmin()) {
                  return response()->json(['success'=>true,'token'=>csrf_token(),'result'=>trans('messages.success_message'),'url'=> route('home')]);
                  
                } elseif (!$user->isSuperAdmin()) {
                  return response()->json(['success'=>true,'token'=>csrf_token(),'result'=>trans('messages.success_message'),'url'=> RouteServiceProvider::ROOT]);
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     */
    public function publicRegister(Request $request)
    {
        $data = $request->all();

        $rules = array(
            'authority' => 'required|in:COACH_USER,RINK_USER',
            'email'  => 'required|string|email|max:255',
            'password' => 'required|min:8'
        );    
        $messages = array(
            'authority.required' => trans('messages.authority.required'),
            'authority.in' => trans('messages.authority.in'),
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
          $userExists = User::where([
                                    ['email', $data['email']],
                                    ['deleted_at', null],
                                ])->first();
        
          if ($userExists) {
            return response()->json(['errors'=>[trans('messages.email.already_registered')]]);
            //throw new HttpResponseException(response()->error(trans('messages.email.already_registered'), Response::HTTP_BAD_REQUEST));
          }
          
          $data['is_verified'] = true;
          $data['token'] = sha1(time());
          $user = User::create($data);
          
          if (!$user) {
            return response()->json(['errors'=>['Registration failed, please try again!']]);
          }
          
          \Mail::to($user->email)->send(new VerifyMail($user));

          return response()->json(['success'=>true,'result'=>'We sent you an activation code. Check your email and click on the link to verify.','url'=> RouteServiceProvider::ROOT]);
                
          
          //Toastr::success(trans('global.A new User has been created'),'Success');
          //return back();
        }
    }

    public function username()
    {
        return 'email';
    }
}