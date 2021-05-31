<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\UserInfo;
use App\Models\User;
use App\Models\Rink;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Language;
use App\Models\Price;
use App\Models\Speciality;
use App\Models\Province;
use App\Models\Location;

use App\Mail\CoachmeAppsMail;
use App\Mail\VerifyMail;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Exports\CollectionExport;
use Maatwebsite\Excel\Facades\Excel;

class CoachController extends Controller
{
    
  use RegistersUsers;


  public function __construct()
  {
      parent::__construct();
  }

  /**
   * Display a listing of the resource and the specified resource.
   *
   * @param \Illuminate\Http\Request $request
   * @param  \App\Models\User  $user
   */
  public function show(Request $request, User $user)
  {
    $params = $request->all();
    
    
    if (!empty($user->id)) {
      $breadcrumb = array(
        array(
           'name'=>trans('global.All Coach'),
           'link'=>'/coaches'
        ),
        array(
           'name'=>trans('global.Coach Detail'),
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
             'Title' =>  trans('global.Coach Detail')
          ]
        ]);
    } 
    $params['authority'] = User::ACCESS_LEVEL_COACH;
    $query = $user->filter($params);
    $export = filter_var($request->input('export', false), FILTER_VALIDATE_BOOLEAN);
    
    try {
        $limit = (int) $request->input('limit', 20);
    } catch (\Exception $e) {
        $limit = 20;
    }

    if (!is_int($limit) || $limit <= 0) {
        $limit = 20;
    }
    if (isset($params['with'])) { 
        $with = explode(',', $params['with']);

        $query->with($with);
    }
    if (isset($params['sort']) && !empty($params['sort'])) {
      $sort = $params['sort'];
      $sortExplode = explode('-', $params['sort']);
      $query->orderBy($sortExplode[0],$sortExplode[1]);
    } else { 
      $sort = 'id-desc';
      $query->orderBy('id', 'desc');
    }
    $response = $query->paginate($limit);


    $breadcrumb = array(
        array(
           'name'=>trans('global.All Coach'),
           'link'=>'/coaches'
        )
    );

    // If export parameter true, it will return csv file
    if ($export) { 
      // It maps model property (key) to column header (value)
      $headPropertyMapper = [
          'id' => 'ID', 
          'family_name' => 'Family Name',
          'email' => 'Email',
          'rink_name' => 'Rink',
          'authority' => 'Authority',
          'created_at' => 'Created At',
          'updated_at' => 'Updated At',
      ];

      $data = $user->dataProcessor($headPropertyMapper, $response);
      $headings = array_values($headPropertyMapper);
      
      // Create CollectionExport instance by passing file headers and data
      $collectionExportInstance = new CollectionExport($headings, $data);
      $fileName = date('Ymd_His').'_users.csv';

      return Excel::download($collectionExportInstance, $fileName);
    } else {
        if (isset($params['page'])) {
          $page = !empty($params['page']) ? $params['page'] : 1;
        } else {
          $page = 1;
        }
        $total = $response->total();
        $sumary = '';
        if ($total>$limit) {
          $content = ($page - 1) * $limit + 1;
          $sumary = "Total ".$total." Displaying ".$content."～".min($page * $limit, $total);
        }

                
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
               'users'      =>  $response->appends(request()->except('page')),
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  trans('global.Coach List'),
               'sumary' => $sumary,
               'request' => $params,
               'sort' => $sort,
               'limit' => $limit
            ]
        ]);
    }

    
  }

  /**
   * Show the form for creating a new resource.
   *
   * 
   */
  public function create($id=null)
  {
    $user='';
    $title=trans('global.Add Coach');
    $breadcrumb = array(
        array(
           'name'=>trans('global.All Coach'),
           'link'=>'/coaches'
        )
      );
    if (!empty($id)) {
      $user = User::find($id);
      if (!$user) {
        return back();
      } else {
        $breadcrumb[] = array(
           'name'=>trans('global.Edit Coach'),
           'link'=>''
        );
        $title=trans('global.Edit Coach');
      }
    } else {
      $breadcrumb[] = array(
           'name'=>trans('global.Add Coach'),
           'link'=>''
      );
    }
    $city_all = Location::all()->pluck("name", "id")->sortBy("name");
    $province_all = Province::all()->pluck("name", "id")->sortBy("name");

    $rink_all = Rink::all()->pluck("name", "id")->sortBy("name");
    $experience_all = Experience::all()->pluck("name", "id")->sortBy("name");
    $certificate_all = Certificate::all()->pluck("name", "id")->sortBy("name");
    $language_all = Language::all()->pluck("name", "id")->sortBy("name");
    $price_all = Price::all()->pluck("name", "id")->sortBy("name");
    $speciality_all = Speciality::all()->pluck("name", "id")->sortBy("name");
    
    return view('admin.coach.add', [
          'pageInfo'=>
          [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
          ],
          'data'=>
          [
               'user'      =>  $user,
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  $title
          ]
      ])
      ->with(compact('rink_all','experience_all','speciality_all','language_all','price_all','certificate_all','province_all','city_all'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * 
   */
  public function store(Request $request)
  {
    $data = $request->all();
    $user = $request->user();

    $data['authority'] = User::ACCESS_LEVEL_COACH;

    $userExists = User::where([
                                  ['email', $data['email']],
                                  ['deleted_at', null],
                              ])->first();
      
    if ($userExists) {
      return redirect()->back()->withInput()->withErrors(trans('messages.email.already_registered'));
    }

    $rules = array(
            'name'   => 'required|string|max:255',
            'email'  => 'required|string|email|max:255',
            'password' => 'required|min:8',
            'password'  => 'required|min:8',
            'avatar_image_path' => 'nullable'
          );    
    $messages = array(
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
        
      Toastr::warning('Error occured',$validator->errors()->all()[0]);
      return redirect()->back()->withInput()->withErrors($validator);
    }
    else
    {
      //$eMail = new CoachmeAppsMail();
      //$eMail->resetPasswordMail($data['email'], $oauth_token, $userExists,$os);
        
      $data['is_verified'] = true;
      $user = User::create($data);
      if (isset($data['rink_id'])) {
        $rink = Rink::find($data['rink_id']);

        if (!$rink) {
           return redirect()->back()->withInput()->withErrors('rink not exist');
        }            
        $insert_arr = array();
        $insert_arr['user_id'] = $user->id;
        $insert_arr['content_id'] = $rink->id;
        $insert_arr['content_type'] = 'RINK';
        $insert_arr['content_name'] = $rink->name;

        $userInfo = UserInfo::where('user_id',$user->id)
                         ->where('content_id',$rink->id)
                         ->where('content_type','RINK')
                         ->first();
        if (!$userInfo) {
          $userInfo = UserInfo::firstOrCreate($insert_arr);
        } else {
          $userInfo->update($insert_arr);  
        }
        
        
      }

      if (isset($data['speciality_id'])) {
        $speciality = Speciality::find($data['speciality_id']);

        if (!$speciality) {
           return redirect()->back()->withInput()->withErrors('rink not exist');
        }            
        $insert_arr = array();
        $insert_arr['user_id'] = $user->id;
        $insert_arr['content_id'] = $speciality->id;
        $insert_arr['content_type'] = 'SPECIALITY';
        $insert_arr['content_name'] = $speciality->name;
        $userInfo = UserInfo::where('user_id',$user->id)
                         ->where('content_id',$speciality->id)
                         ->where('content_type','SPECIALITY')
                         ->first();
        if (!$userInfo) {
          $userInfo = UserInfo::firstOrCreate($insert_arr);
        } else {
          $userInfo->update($insert_arr);  
        }
      }
      if (isset($data['language_id'])) {
        $language = Language::find($data['speciality_id']);

        if (!$language) {
           return redirect()->back()->withInput()->withErrors('rink not exist');
        }            
        $insert_arr = array();
        $insert_arr['user_id'] = $user->id;
        $insert_arr['content_id'] = $language->id;
        $insert_arr['content_type'] = 'LANGUAGE';
        $insert_arr['content_name'] = $language->name;
        $userInfo = UserInfo::where('user_id',$user->id)
                         ->where('content_id',$language->id)
                         ->where('content_type','LANGUAGE')
                         ->first();
        if (!$userInfo) {
          $userInfo = UserInfo::firstOrCreate($insert_arr);
        } else {
          $userInfo->update($insert_arr);  
        }
      }
      
      $user->authority = User::ACCESS_LEVEL_COACH;
      $user->token = sha1(time());
      
      if($request->file('avatar_image_path'))
      {
        $image = $request->file('avatar_image_path');
        $new_name = $user->id . '_s_' . self::uniqueString() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('user_photo'), $new_name);
         $user->avatar_image_path = $new_name;
      }
      if (!$user->save()) {
        
        return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
      }
      if (config('global.email_send') == 1) {
        \Mail::to($user->email)->send(new VerifyMail($user));
      }

      
      Toastr::success(trans('global.A new Coach has been created'),'Success');
      return back();
    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $id
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
            'avatar_image_path' => 'nullable',
          );    
    $messages = array(
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

      Toastr::success(trans('global.Coach has been updated'),'Success');
      return back();
    }
    
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
