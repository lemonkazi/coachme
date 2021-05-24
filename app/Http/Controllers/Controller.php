<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use View;
use Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $BASE_URL = '';
    public $CURRENT_URL = '';
    /** @var object $AppUI Session infomation of user logged. */
    public $AppUI = null;
    /** @var object $controller Controller name. */
    public $controller = null;
    public $action = null;

    public function __construct()
    {
        $currentAction = Route::currentRouteAction();
        list($controller, $method) = explode('@', $currentAction);

        $controller = preg_replace('/.*\\\/', '', $controller);

    	$this->controller = strtolower($controller);
        $this->action = strtolower($method);
        $this->CURRENT_URL = url()->full();

        $this->middleware(function ($request, $next) {

            if (Auth::check() && $this->isAuthorized()) {
                $user = Auth::user();

                $this->AppUI = Auth::user();
            }
            $data = array(
                'controller' => $this->controller,
                'action' => $this->action,
                'CURRENT_URL' => $this->CURRENT_URL,
                'AppUI' => $this->AppUI,
            );
            View::share($data);
            return $next($request);
        });

        // print_r(Auth::user());
        // exit();
        // if (Auth::check() && $this->isAuthorized()) {
        //     $user = Auth::user();

        //     $this->AppUI = Auth::user();
        // }
        
    }


    /**
     * Before filter event
     * @param Event $event
     */
    public function beforeFilter(Event $event) {
    	parent::beforeFilter($event);
        
    }


    public function getModelName($name)
    {
        $uNmae = ucfirst($name);

        return 'App\\Models\\'.$uNmae;
    }

    /**
     * Commont function check user is Authorized..
     *
     *
     * @param object $user Session user logged.
     * @return boolean  If true is authorize, and false is unauthorize.
     */
    public function isAuthorized($user = null) {
        if (Auth::check()) {
            if (empty($user)) {
                $user = Auth::user();
            }
            if (!empty($user)) {
                $this->AppUI = $user;
                return true;
            }
            return false;
        } else {
            return false;
        }
        
        
    }
}
