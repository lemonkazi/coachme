<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use View;
use Auth;
use Illuminate\Support\Collection;


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
        return View::make('welcome', ['pageInfo'=>['siteTitle'=>'COACH ME']]);
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
}