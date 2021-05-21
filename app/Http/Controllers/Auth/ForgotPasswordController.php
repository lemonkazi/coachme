<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

     /**
     * Create a new password controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }
    // public function broker()
    // {
    //         return Password::broker();
    //         //     $passwords = config('backpack.base.passwords', config('auth.defaults.passwords'));
    //         //     return Password::broker($passwords);
    // }

    public function showLinkRequestForm()
    {
        $this->data['title'] = trans('backpack::base.reset_password'); // set the page title
        return view('auth.passwords.email', $this->data);
    }



    // public function sendResetLinkEmail(Request $request)
    // {
    //     $this->validateEmail($request);
    //     $data = $request->all();
    //     $user = User::where([
    //                             ['email', $data['email']],
    //                        ])->first();

    //     // We will send the password reset link to this user. Once we have attempted
    //     // to send the link, we will examine the response then see the message we
    //     // need to show to the user. Finally, we'll send out a proper response.

    //     if ($user) {
    //         $response = $this->broker()->sendResetLink(
    //             $request->only('email')
    //         );
    //         return back()->with('status', "If you've provided registered e-mail, you should get recovery e-mail shortly.");
    //     }
    //     else {
    //         return redirect()->back()->withInput()->with('error', trans('global.reset_email_send_fail'));
    //     }
    // }

    
}
