<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rink;

class RinkController extends Controller
{
    

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Rink $rink)
    {
      //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $rinks
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Rink $rink)
    {
      $params = $request->all();
      
      if (!empty($rink->id)) {
        $breadcrumb = array(
          array(
             'name'=>'All Rinks',
             'link'=>'/rinks'
          ),
          array(
             'name'=>'Rink Detail',
             'link'=>''
          )
        );
        return view('admin.rink.detail', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'rink' => Rink::find($rink->id),
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Rink Detail'
            ]
          ]);
      } else {
        $queryRink = Rink::query();
        //$queryUser->where('authority','=','COACH_USER');
        $rinks = $queryRink->paginate(20);
      }

      $breadcrumb = array(
          array(
             'name'=>'All Rinks',
             'link'=>'/rinks'
          )
      );

      return view('admin.rink.list', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'rinks'      =>  $rinks,
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Rink List'
            ]
          ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
      $rink='';
      $title='Add Rink';
      $breadcrumb = array(
          array(
             'name'=>'All Rink',
             'link'=>'/rinks'
          )
        );
      if (!empty($id)) {
        $rink = Rink::find($id);
        if (!$rink) {
          return back();
        } else {
          $breadcrumb[] = array(
             'name'=>'Edit Rink',
             'link'=>''
          );
          $title='Edit Rink';
        }
      } else {
        $breadcrumb[] = array(
             'name'=>'Add Rink',
             'link'=>''
        );
      }
     
      return view('admin.rink.add', [
            'pageInfo'=>
            [
              'siteTitle'        =>'Manage Users',
              'pageHeading'      =>'Manage Users',
              'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ],
            'data'=>
            [
                 'rink'      =>  $rink,
                 'breadcrumb' =>  $breadcrumb,
                 'Title' =>  $title
            ]
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->all();
      $Authuser = $request->user();
      $rules = array(
              'name'   => 'required|string|max:255',
            );    
      $messages = array(
                  'name.required' => trans('messages.name.required'),
                  'name.max' => trans('messages.name.max')
                );
      $validator = Validator::make( $data, $rules, $messages );

      if ( $validator->fails() ) 
      {
            Toastr::warning('Error occured',$validator->errors()->all()[0]);
            return redirect()->back()->withInput()->withErrors($validator);
      }
      else
      {
          
          if (!Rink::create($data)) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }
          Toastr::success('A new Rink has been created','Success');
          return back();
      }


    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=null)
    {

      $data = $request->all();
      $Authuser = $request->user();
      $rink = Rink::find($id);
      if (!$rink) {
        return back();
      }

      $rules = array(
              'name'   => 'filled|string|max:50',
            );    
      $messages = array(
                  'name.filled' => trans('messages.name.required'),
                  'name.max' => trans('messages.name.max'),
                );
      $validator = Validator::make( $data, $rules, $messages );

      if ( $validator->fails() ) 
      {
          
        Toastr::warning('Error occured',$validator->errors()->all()[0]);
        return redirect()->back()->withInput()->withErrors($validator);
      }
      else
      {

        if (!$rink->update($data)) {
          return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
        }

        Toastr::success('Rink has been updated','Success');
        return back();
      }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rink $rink)
    {
      $rink->delete();
      return response()->success(false, trans('messages.success_message'), Response::HTTP_OK);
    }

}