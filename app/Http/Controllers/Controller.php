<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $BASE_URL = '';

    public function __construct()
    {
    	$this->BASE_URL="some value";
    }


    /**
     * Before filter event
     * @param Event $event
     */
    public function beforeFilter(Event $event) {
    	parent::beforeFilter($event);
    	view()->share('BASE_URL', 'HDTuto.com');
    }


    public function getModelName($name)
    {
        $uNmae = ucfirst($name);

        return 'App\\Models\\'.$uNmae;
    }
}
