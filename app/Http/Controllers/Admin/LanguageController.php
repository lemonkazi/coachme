<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Language;

class LanguageController extends Controller
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
    public function index(Request $request, Language $language)
    {
      //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $languages
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Language $language)
    {
      $params = $request->all();
      
      if (!empty($language->id)) {
        $breadcrumb = array(
          array(
             'name'=>'All Languages',
             'link'=>'/languages'
          ),
          array(
             'name'=>'Language Detail',
             'link'=>''
          )
        );
        return view('admin.language.detail', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'language' => Language::find($language->id),
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Language Detail'
            ]
          ]);
      } else {
        $queryLanguage = Language::query();
        //$queryUser->where('authority','=','COACH_USER');
        $languages = $queryLanguage->paginate(20);
      }

      $breadcrumb = array(
          array(
             'name'=>'All Languages',
             'link'=>'/languages'
          )
      );

      return view('admin.language.list', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'languages'      =>  $languages,
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Language List'
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
      $language='';
      $title='Add Language';
      $breadcrumb = array(
          array(
             'name'=>'All Language',
             'link'=>'/languages'
          )
        );
      if (!empty($id)) {
        $language = Language::find($id);
        if (!$language) {
          return back();
        } else {
          $breadcrumb[] = array(
             'name'=>'Edit Language',
             'link'=>''
          );
          $title='Edit Language';
        }
      } else {
        $breadcrumb[] = array(
             'name'=>'Add Language',
             'link'=>''
        );
      }
     
      return view('admin.language.add', [
            'pageInfo'=>
            [
              'siteTitle'        =>'Manage Users',
              'pageHeading'      =>'Manage Users',
              'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ],
            'data'=>
            [
                 'language'      =>  $language,
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
          
          if (!Language::create($data)) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }
          Toastr::success('A new Language has been created','Success');
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
      $language = Language::find($id);
      if (!$language) {
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

        if (!$language->update($data)) {
          return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
        }

        Toastr::success('Language has been updated','Success');
        return back();
      }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
      $language->delete();
      return response()->success(false, trans('messages.success_message'), Response::HTTP_OK);
    }

}
