<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Certificate;

class CertificateController extends Controller
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
    public function index(Request $request, Certificate $certificate)
    {
      //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $certificates
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Certificate $certificate)
    {
      $params = $request->all();
      
      if (!empty($certificate->id)) {
        $breadcrumb = array(
          array(
             'name'=>'All Certificates',
             'link'=>'/certificates'
          ),
          array(
             'name'=>'Certificate Detail',
             'link'=>''
          )
        );
        return view('admin.certificate.detail', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'certificate' => Certificate::find($certificate->id),
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Certificate Detail'
            ]
          ]);
      } else {
        $queryCertificate = Certificate::query();
        //$queryUser->where('authority','=','COACH_USER');
        $certificates = $queryCertificate->paginate(20);
      }

      $breadcrumb = array(
          array(
             'name'=>'All Certificates',
             'link'=>'/certificates'
          )
      );

      return view('admin.certificate.list', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'certificates'      =>  $certificates,
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Certificate List'
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
      $certificate='';
      $title='Add Certificate';
      $breadcrumb = array(
          array(
             'name'=>'All Certificate',
             'link'=>'/certificates'
          )
        );
      if (!empty($id)) {
        $certificate = Certificate::find($id);
        if (!$certificate) {
          return back();
        } else {
          $breadcrumb[] = array(
             'name'=>'Edit Certificate',
             'link'=>''
          );
          $title='Edit Certificate';
        }
      } else {
        $breadcrumb[] = array(
             'name'=>'Add Certificate',
             'link'=>''
        );
      }
     
      return view('admin.certificate.add', [
            'pageInfo'=>
            [
              'siteTitle'        =>'Manage Users',
              'pageHeading'      =>'Manage Users',
              'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ],
            'data'=>
            [
                 'certificate'      =>  $certificate,
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
          
          if (!Certificate::create($data)) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }
          Toastr::success('A new Certificate has been created','Success');
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
      $certificate = Certificate::find($id);
      if (!$certificate) {
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

        if (!$certificate->update($data)) {
          return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
        }

        Toastr::success('Certificate has been updated','Success');
        return back();
      }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
      $certificate->delete();
      return response()->success(false, trans('messages.success_message'), Response::HTTP_OK);
    }

}
