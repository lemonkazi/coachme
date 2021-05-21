<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
}