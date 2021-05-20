<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Speciality;

class SpecialityController extends Controller
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
    public function index(Request $request, Speciality $speciality)
    {
      //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $speciality
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Speciality $speciality)
    {
      $params = $request->all();
      
      if (!empty($speciality->id)) {
        $breadcrumb = array(
          array(
             'name'=>'All Speciality',
             'link'=>'/speciality'
          ),
          array(
             'name'=>'Speciality Detail',
             'link'=>''
          )
        );
        return view('admin.speciality.detail', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'speciality' => Speciality::find($speciality->id),
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Speciality Detail'
            ]
          ]);
      } else {
        $querySpeciality = Speciality::query();
        //$queryUser->where('authority','=','COACH_USER');
        $speciality = $querySpeciality->paginate(20);
      }

      $breadcrumb = array(
          array(
             'name'=>'All Speciality',
             'link'=>'/speciality'
          )
      );

      return view('admin.speciality.list', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'speciality'      =>  $speciality,
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Speciality List'
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
      $speciality='';
      $title='Add Speciality';
      $breadcrumb = array(
          array(
             'name'=>'All Speciality',
             'link'=>'/speciality'
          )
        );
      if (!empty($id)) {
        $speciality = Speciality::find($id);
        if (!$speciality) {
          return back();
        } else {
          $breadcrumb[] = array(
             'name'=>'Edit Speciality',
             'link'=>''
          );
          $title='Edit Speciality';
        }
      } else {
        $breadcrumb[] = array(
             'name'=>'Add Speciality',
             'link'=>''
        );
      }
     
      return view('admin.speciality.add', [
            'pageInfo'=>
            [
              'siteTitle'        =>'Manage Users',
              'pageHeading'      =>'Manage Users',
              'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ],
            'data'=>
            [
                 'speciality'      =>  $speciality,
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
          
          if (!Speciality::create($data)) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }
          Toastr::success('A new Speciality has been created','Success');
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
      $speciality = Speciality::find($id);
      if (!$speciality) {
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

        if (!$speciality->update($data)) {
          return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
        }

        Toastr::success('Speciality has been updated','Success');
        return back();
      }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speciality $speciality)
    {
      $speciality->delete();
      return response()->success(false, trans('messages.success_message'), Response::HTTP_OK);
    }

}
