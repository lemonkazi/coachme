<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\CoachCreateRequest;
use App\Models\User;

//use App\Models\products;
use App\Exports\CollectionExport;
use Maatwebsite\Excel\Facades\Excel;

class CoachController extends Controller
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
    public function index(Request $request, Coach $coach)
    {
      //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $users
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
      $params = $request->all();
      
      if (!empty($user->id)) {
        $breadcrumb = array(
          array(
             'name'=>'All Coach',
             'link'=>'/coaches'
          ),
          array(
             'name'=>'Coach Detail',
             'link'=>''
          )
        );
        return view('admin.coach.detail', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'user' => User::find($user->id),
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Coach Detail'
            ]
          ]);
        // return view('admin.coach.detail',[
        //   'user' => User::find($user->id),
        // ]);
      } else {
        $queryUser = User::query();
        $queryUser->where('authority','=','COACH_USER');
        $users = $queryUser->paginate(20);
      }

      $breadcrumb = array(
          array(
             'name'=>'All Coach',
             'link'=>'/coaches'
          )
      );

      return view('admin.coach.list', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'users'      =>  $users,
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Coach List'
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
      $user='';
      $title='Add Coach';
      $breadcrumb = array(
          array(
             'name'=>'All Coach',
             'link'=>'/coaches'
          )
        );
      if (!empty($id)) {
        $user = User::find($id);
        if (!$user) {
          return back();
        } else {
          $breadcrumb[] = array(
             'name'=>'Edit Coach',
             'link'=>''
          );
          $title='Edit Coach';
        }
      } else {
        $breadcrumb[] = array(
             'name'=>'Add Coach',
             'link'=>''
        );
      }
        
        return view('admin.coach.add', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'user'      =>  $user,
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
      $user = $request->user();

      $data['authority'] = 'COACH_USER';

      $userExists = User::where([
                                    ['email', $data['email']],
                                    ['deleted_at', null],
                                ])->first();
        
        if ($userExists) {
          return redirect()->back()->withInput()->withErrors(trans('messages.email.already_registered'));
        }

        if (isset($data['rink'])) {
            $rink = Rink::find($data['rink']);

            if (!$rink) {
               return redirect()->back()->withInput()->withErrors('rink not exist');
            }         
        }


      $rules = array(
              'name'   => 'required|string|max:255',
              //'family_name'   => 'required|string|min:10',
              'email'  => 'required|string|email|max:255',
              'password' => 'required|min:8',
              //'type_staff'=> 'required',
              'password'  => 'required|min:8',
              'avatar_image_path' => 'nullable',
              //'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            );    
      $messages = array(
                  //'family_name.min' => trans('messages.name.max'),
                  'name.required' => trans('messages.name.required'),
                  'name.max' => trans('messages.name.max'),
                  'email.required' => trans('messages.email.required'),
                  'email.string' => trans('messages.email.string'),
                  'email.email' => trans('messages.email.email'),
                  'email.max' => trans('messages.email.max'),
                  'password.required' => trans('messages.password.required'),
                  'password.min' => trans('messages.password.min')
                  
                );
      $validator = Validator::make( $data, $rules, $messages );

      if ( $validator->fails() ) 
      {
          // return [
          //     'success' => 0, 
          //     'message' => $validator->errors()->first()
          // ];
            //Toastr::warning('Error occured',$validator->errors()->all()[0]);
            return redirect()->back()->withInput()->withErrors($validator);
      }
      else
      {
          
          $data['is_verified'] = true;
          $user = User::create($data);
          $user->rink_id = !empty($rink) ? $rink->id : null;
          $user->authority = User::ACCESS_LEVEL_COACH;
          
          if($request->file('avatar_image_path'))
          {
            $image = $request->file('avatar_image_path');
            $new_name = $user->id . '_s_' . self::uniqueString() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('coach_photo'), $new_name);
             $user->avatar_image_path = $new_name;
          }
          if (!$user->save()) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }

          // print_r($data);
          // exit();
          // $user = new User;
          // $user->name = $request->name;
          // $user->email = $request->email;
          // $user->access_level = User::ACCESS_LEVEL_STAFF;
          // $user->password = bcrypt($request->password);

          // $user->save();
          // $staff = new Staff;
          // $staff->user_id = $user->id;
          // $staff->phone = $request->phone;
          // $staff->address = $request->address;
          // if($request->post('type_staff') == 0)
          // {
          //    $staff->access_level = Staff::ACCESS_LEVEL_MARKET;
          // }
          // elseif($request->post('type_staff') == 1)
          // {
          //    $staff->access_level = Staff::ACCESS_LEVEL_ACCOUNT;
          // }
          // $staff->created_by = Auth::user()->id;
          
          Toastr::success('A new Coach has been created','Success');
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
      $user = User::find($id);
      if (!$user) {
        return back();
      }

      $userExists = null;

      if (isset($data['email'])) {
          $userExists = User::where([
                                      ['id', '<>', $user->id],
                                      ['email', $data['email']],
                                      ['deleted_at', null],
                                  ])->first();
      }
      
      if ($userExists) {
        return redirect()->back()->withInput()->withErrors(trans('messages.email.already_registered'));
      }

      if (!empty($data['password'])) {
          $data['password'] = $data['password'];
      }else{
          unset($data['password']);
      }
      $rules = array(
              'name'   => 'filled|string|max:50',
              //'family_name'   => 'required|string|min:10',
              //'email'  => 'filled|string|email|max:255',
              
              //'type_staff'=> 'required',
              'avatar_image_path' => 'nullable',
              //'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            );    
      $messages = array(
                  //'family_name.min' => trans('messages.name.max'),
                  'name.filled' => trans('messages.name.required'),
                  'name.max' => trans('messages.name.max'),
                  'email.required' => trans('messages.email.required'),
                  'email.string' => trans('messages.email.string'),
                  'email.email' => trans('messages.email.email'),
                  'email.max' => trans('messages.email.max'),
                  'password.required' => trans('messages.password.required'),
                  'password.min' => trans('messages.password.min')
                  
                );
      $validator = Validator::make( $data, $rules, $messages );

      if ( $validator->fails() ) 
      {
          
        Toastr::warning('Error occured',$validator->errors()->all()[0]);
        return redirect()->back()->withInput()->withErrors($validator);
      }
      else
      {

        if (!$user->update($data)) {
          return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
        }

        Toastr::success('Coach has been updated','Success');
        return back();
      }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
      $city->delete();
      return response()->success(false, trans('messages.success_message'), Response::HTTP_OK);
    }



    private function uniqueString()
    {
        $m = explode(' ', microtime());
        list($totalSeconds, $extraMilliseconds) = array($m[1], (int)round($m[0] * 1000, 3));
        $txID = date('YmdHis', $totalSeconds) . sprintf('%03d', $extraMilliseconds);
        $txID = substr($txID, 2, 15);
        return $txID;
    }
}
