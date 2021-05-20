<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Experience;

class ExperienceController extends Controller
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
    public function index(Request $request, Experience $experience)
    {
      //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $experiences
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Experience $experience)
    {
      $params = $request->all();
      
      if (!empty($experience->id)) {
        $breadcrumb = array(
          array(
             'name'=>'All Experiences',
             'link'=>'/experiences'
          ),
          array(
             'name'=>'Experience Detail',
             'link'=>''
          )
        );
        return view('admin.experience.detail', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'experience' => Experience::find($experience->id),
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Experience Detail'
            ]
          ]);
      } else {
        $queryExperience = Experience::query();
        //$queryUser->where('authority','=','COACH_USER');
        $experiences = $queryExperience->paginate(20);
      }

      $breadcrumb = array(
          array(
             'name'=>'All Experiences',
             'link'=>'/experiences'
          )
      );

      return view('admin.experience.list', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'experiences'      =>  $experiences,
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Experience List'
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
      $experience='';
      $title='Add Experience';
      $breadcrumb = array(
          array(
             'name'=>'All Experience',
             'link'=>'/experiences'
          )
        );
      if (!empty($id)) {
        $experience = Experience::find($id);
        if (!$experience) {
          return back();
        } else {
          $breadcrumb[] = array(
             'name'=>'Edit Experience',
             'link'=>''
          );
          $title='Edit Experience';
        }
      } else {
        $breadcrumb[] = array(
             'name'=>'Add Experience',
             'link'=>''
        );
      }
     
      return view('admin.experience.add', [
            'pageInfo'=>
            [
              'siteTitle'        =>'Manage Users',
              'pageHeading'      =>'Manage Users',
              'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ],
            'data'=>
            [
                 'experience'      =>  $experience,
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
          
          if (!Experience::create($data)) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }
          Toastr::success('A new Experience has been created','Success');
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
      $experience = Experience::find($id);
      if (!$experience) {
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

        if (!$experience->update($data)) {
          return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
        }

        Toastr::success('Experience has been updated','Success');
        return back();
      }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
      $experience->delete();
      return response()->success(false, trans('messages.success_message'), Response::HTTP_OK);
    }

}
