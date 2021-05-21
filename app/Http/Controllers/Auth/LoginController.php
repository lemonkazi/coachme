<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login', ['title' => 'Login']);
    }

    public function login(Request $request)
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
    }

    private function validator(Request $request)
    {
        $rules = [
            'email'    => 'required|email|min:5|max:191',
            'password' => 'required|string|min:4|max:255'
        ];
        $request->validate($rules);
    }

}
