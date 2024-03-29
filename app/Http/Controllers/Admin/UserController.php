<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ProfilePasswordUpdateRequest;
use App\Http\Requests\RegistrationRequest;

use Illuminate\Foundation\Auth\RegistersUsers;

use App\Models\User;
use App\Models\Rink;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Language;
use App\Models\Price;
use App\Models\Speciality;

use App\Mail\CoachmeAppsMail;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Exports\CollectionExport;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
    use RegistersUsers;
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource and the specified resource.
     *
     * @param  \App\Models\User  $user
     */
    public function show(Request $request, User $user)
    {
      $params = $request->all();
      
      if (!empty($user->id)) {
        $breadcrumb = array(
          array(
             'name'=>trans('global.All User'),
             'link'=>'/users'
          ),
          array(
             'name'=>trans('global.User Detail'),
             'link'=>''
          )
        );
        return view('admin.user.detail', [
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
               'Title' =>  trans('global.User Detail')
            ]
          ]);
      } 
      $params['authority'] = User::ACCESS_LEVEL_RINK;
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
             'name'=>trans('global.All User'),
             'link'=>'/users'
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
      } 
      else {
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

        return view('admin.user.list', [
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
                'Title' =>  trans('global.User List'),
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
        $title='Add User';
        $breadcrumb = array(
            array(
                'name'=>trans('global.All User'),
                'link'=>'/users'
            )
        );
        if (!empty($id)) {
            $user = User::find($id);
            if (!$user) {
                return back();
            } else {
                $breadcrumb[] = array(
                    'name'=>trans('global.Edit User'),
                    'link'=>''
                );
                $title=trans('global.Edit User');
            }
        } else {
            $breadcrumb[] = array(
                'name'=>trans('global.Add User'),
                'link'=>''
            );
        }
        $rink_all = Rink::all()->pluck("name", "id")->sortBy("name");
        $experience_all = Experience::all()->pluck("name", "id")->sortBy("name");
        $certificate_all = Certificate::all()->pluck("name", "id")->sortBy("name");
        $language_all = Language::all()->pluck("name", "id")->sortBy("name");
        $price_all = Price::all()->pluck("name", "id")->sortBy("name");
        $speciality_all = Speciality::all()->pluck("name", "id")->sortBy("name");
        $authority = array(
            'SUPER_ADMIN' => __('LABEL_SUPER_ADMIN'),
            'RINK_USER' => __('RINK_USER')
        );
        return view('admin.user.add', [
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
        ->with(compact('rink_all','experience_all','speciality_all','language_all','price_all','certificate_all','authority'));
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


        $userExists = User::where([
                                    ['email', $data['email']],
                                    ['deleted_at', null],
                                ])->first();
        
        if ($userExists) {
          return redirect()->back()->withInput()->withErrors(trans('messages.email.already_registered'));
        }

        if (isset($data['rink_id'])) {
            $rink = Rink::find($data['rink_id']);

            if (!$rink) {
               return redirect()->back()->withInput()->withErrors('rink not exist');
            }         
        }


        $rules = array(
            'name'   => 'required|string|max:255',
            'authority' => 'required|in:SUPER_ADMIN,RINK_USER',
            'rink_id' => 'required_if:authority,RINK_USER|numeric',
            'email'  => 'required|string|email|max:255',
            'password' => 'required|min:8',
            'avatar_image_path' => 'nullable'
        );    
        $messages = array(
            'authority.required' => trans('messages.authority.required'),
            'authority.in' => trans('messages.authority.in'),
            'rink_id.required_if' => trans('messages.rink_id.required'),
            'rink_id.numeric' => trans('messages.rink_id.numeric'),
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
          
          $data['is_verified'] = true;
          $user = User::create($data);
          $user->rink_id = !empty($rink) ? $rink->id : null;
          //$user->authority = User::ACCESS_LEVEL_COACH;
        
          if($request->file('avatar_image_path'))
          {
              $image = $request->file('avatar_image_path');
              $new_name = $user->id . '_s_' . self::uniqueString() . '.' . $image->getClientOriginalExtension();
              $image->move(public_path('photo/user_photo'), $new_name);
              $user->avatar_image_path = $new_name;
          }
          $user->token = sha1(time());
          if (!$user->save()) {
              return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }
          if ($user->authority==User::ACCESS_LEVEL_RINK) {
            if (config('global.email_send') == 1) {
              \Mail::to($user->email)->send(new VerifyMail($user));
            }
          }
          Toastr::success(trans('global.A new User has been created'),'Success');
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
          'authority' => 'required|in:SUPER_ADMIN,RINK_USER',
          'rink_id' => 'required_if:authority,RINK_USER|numeric',
          'name'   => 'filled|string|max:50',
          'email' => 'filled|string|email|max:255',
          'avatar_image_path' => 'nullable',
      );    
      $messages = array(
          'authority.required' => trans('messages.authority.required'),
          'authority.in' => trans('messages.authority.in'),
          'rink_id.required_if' => trans('messages.rink_id.required'),
          'rink_id.numeric' => trans('messages.rink_id.numeric'),
      
          'name.filled' => trans('messages.name.required'),
          'name.max' => trans('messages.name.max'),
          'email.required' => trans('messages.email.required'),
          'email.string' => trans('messages.email.string'),
          'email.email' => trans('messages.email.email'),
          'email.max' => trans('messages.email.max')
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

          Toastr::success(trans('global.User has been updated'),'Success');
          return back();
      }
      
    }

   



    private function uniqueString()
    {
        $m = explode(' ', microtime());
        list($totalSeconds, $extraMilliseconds) = array($m[1], (int)round($m[0] * 1000, 3));
        $txID = date('YmdHis', $totalSeconds) . sprintf('%03d', $extraMilliseconds);
        $txID = substr($txID, 2, 15);
    }

    


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateuser(UserUpdateRequest $request, User $user)
    {
        $data = $request->all();
        $authUser = $request->user();

        $userExists = null;

        if (isset($data['email'])) {
            $userExists = User::where([
                                        ['id', '<>', $user->id],
                                        ['email', $data['email']],
                                        ['deleted_at', null],
                                    ])->first();
        }
        
        if ($userExists) {
            throw new HttpResponseException(response()->error(trans('messages.email.already_registered'), Response::HTTP_BAD_REQUEST));
        }


        if (isset($data['city_id'])) {
            $city = City::find($data['city_id']);

            if (!$city) {
                throw new HttpResponseException(response()->error(trans('messages.city_id.invalid'), Response::HTTP_BAD_REQUEST));
            }

            if (empty($data['avatar_image_path']) && $data['authority'] === 'CITY_ADMIN') {
                $data['avatar_image_path'] = '';
            }

        }
        
        if ($authUser->isCityAdmin()) {
            
            if ($authUser->city_id !== $data['city_id']) {
                throw new HttpResponseException(response()->error(trans('messages.unauthorized_to_other_city_admin'), Response::HTTP_BAD_REQUEST));
            }
        }

        if ($data['authority'] === 'SERVICE_ADMIN') {
            $user->city_id = null;
        } else if ($data['authority'] === 'CITY_ADMIN') { 
            if (!empty($city)) {
                $user->city_id = $city->id;
            }
        } 

        if (isset($data['city_block_id']) && empty($data['city_block_id'])) {
            $data['city_block_id'] = null;
        }

        if (!$user->update($data)) {
            throw new HttpResponseException(response()->error(trans('messages.error_message'), Response::HTTP_BAD_REQUEST));
        }

        return response()->success($user, trans('messages.success_message'), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(ProfileUpdateRequest $request)
    {
        $data = $request->all();
        $authUser = $request->user();

        if (array_key_exists('authority', $data)) {
            unset($data['authority']);
        }
        
        if (array_key_exists('email', $data)) {
            unset($data['email']);
        }

        if (array_key_exists('phone_number', $data)) {
            unset($data['phone_number']);
        }
        if (array_key_exists('current_password', $data)) {
            if(!Hash::check($data['current_password'], $authUser->password)){
                throw new HttpResponseException(response()->error(trans('messages.password.current'), Response::HTTP_BAD_REQUEST));
            }            
        }
        if (isset($data['city_block_id']) && empty($data['city_block_id'])) {
            $data['city_block_id'] = null;
        }

        if (!$authUser->update($data)) {
            throw new HttpResponseException(response()->error(trans('messages.error_message'), Response::HTTP_BAD_REQUEST));
        }

        return response()->success($authUser, trans('messages.user_success_message'), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProfilePasswordUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(ProfilePasswordUpdateRequest $request)
    {
        $data = $request->all();
        $authUser = $request->user();

        $checkUser = User::where([
                        ['id', $authUser->id],
                        ['deleted_at', null],
                    ])->first();

        $is_current_password_match = 0;
        if (isset($data['current_password']) && Hash::check($data['current_password'], $checkUser->password)) {
            $is_current_password_match = 1;
        } else {
            throw new HttpResponseException(response()->error(trans('messages.current_password.current'), Response::HTTP_BAD_REQUEST));
        }

        if (isset($data['new_password']) && $is_current_password_match == 1) {
            $updateData['id'] = $authUser->id;
            $updateData['password'] = $data['new_password'];
            if (!$authUser->update($updateData)) {
                throw new HttpResponseException(response()->error(trans('messages.error_message'), Response::HTTP_BAD_REQUEST));
            }
            return response()->success(false, trans('oauth.update_password_successfully'), Response::HTTP_OK); 
        }
    }

    protected function resetPassword(ProfileUpdateRequest $request, User $user)
    {
        $data = $request->all();
        
        if (!isset($data['email']) || empty($data['email'])) {
           throw new HttpResponseException(response()->error('メールが必要です', Response::HTTP_BAD_REQUEST));
        }

        $userExists = User::where([
                                ['email', $data['email']],
                                ['is_verified', true],
                            ])->first();

        if (!$userExists) {
            throw new HttpResponseException(response()->error(trans('oauth.user_not_found'), Response::HTTP_BAD_REQUEST));
        }

        $oauth_token = $data['email'].time().$_SERVER["REMOTE_ADDR"];
        $oauth_token = md5($oauth_token);
        $data['token'] = $oauth_token;
        if (isset($data['client_type']) && !empty($data['client_type'])) {
            if ($data['client_type'] == 'Android') {
                $os = 'android';
            } else {
                $os = $this->os($request->header('User-Agent'));
            }
        }else {
            $os = $this->os($request->header('User-Agent'));
        }
        $passwordReset = PasswordReset::create($data);
        
        $eMail = new CoachmeAppsMail();
        $eMail->resetPasswordMail($data['email'], $oauth_token, $userExists,$os);
        return response()->success(false, trans('oauth.email_send_reset_password'), Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function userDetail(Request $request)
    {
      $user = $request->user();
      if (!$user) {
        return back();
      }

      $response = [];
      $params = $request->all();

      if (!$user) {
          throw new HttpResponseException(response()->error(trans('oauth.not_found'), Response::HTTP_NOT_FOUND));
      }
      if (!$user->isSuperAdmin()) { 
          $filterParams = [];

          $data->unread_news = (new News())->filter($filterParams)->whereDoesntHave('newsReads')->get()
                  ->map(function($item, $key) use ($user) {
                      return [
                          'news_id' => $item->id
                      ];
                  })
                  ->all();
                  ;
      }
      $response['data'] = $user;

      $breadcrumb = array(
        array(
           'name'=>trans('All User'),
           'link'=>'/users'
        ),
        array(
           'name'=>trans('global.Profile'),
           'link'=>''
        )
      );

      return view('admin.user.profile', [
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
             'Title' =>  trans('global.Profile')
          ]
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function userUpdate(ProfileUpdateRequest $request)
    {
        $data = $request->all();
        $user = $request->user();
        
        $userExists = null;

        if (isset($data['email'])) {
            $userExists = User::where([
                                        ['id', '<>', $user->id],
                                        ['email', $data['email']]
                                    ])->first();
        }
        
        if ($userExists) {
            throw new HttpResponseException(response()->error(trans('messages.email.already_registered'), Response::HTTP_BAD_REQUEST));
        }

        if (isset($data['city_id'])) {
            $city = City::find($data['city_id']);

            if (!$city) {
                throw new HttpResponseException(response()->error(trans('messages.city_id.invalid'), Response::HTTP_BAD_REQUEST));
            }

        }

        if (!empty($city)) {
            $user->city_id = $city->id;
            $data['city_id'] = $city->id;
        }
        if (isset($data['city_block_id']) && empty($data['city_block_id'])) {
            $data['city_block_id'] = null;
        }

        if (!$user->update($data)) {
            throw new HttpResponseException(response()->error(trans('messages.error_message'), Response::HTTP_BAD_REQUEST));
        }

        return response()->success($user, trans('messages.user_success_message'), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $authUser = request()->user();

        if (!$user) {
            throw new HttpResponseException(response()->error(trans('oauth.not_found'), Response::HTTP_NOT_FOUND));
        }

        if ($authUser->isCityAdmin()) {
            if ($user->authority !== 'CITY_ADMIN') {
                throw new HttpResponseException(response()->error(trans('messages.could_not_be_deleted'), Response::HTTP_BAD_REQUEST));
            } elseif ($user->authority === 'CITY_ADMIN' && $authUser->city_id !== $user->city_id) {
                throw new HttpResponseException(response()->error(trans('messages.could_not_be_deleted'), Response::HTTP_BAD_REQUEST));
            }
        }

        if (!$user->delete()) {
            throw new HttpResponseException(response()->error(trans('messages.users.could_not_be_deleted'), Response::HTTP_BAD_REQUEST));
        }

        return response()->success(false, trans('messages.users.deleted_successfully'), Response::HTTP_OK);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroyuser(User $user)
    {
        $authUser = request()->user();
        if (!$user) {
            throw new HttpResponseException(response()->error(trans('oauth.not_found'), Response::HTTP_NOT_FOUND));
        }

        if ($authUser->isCityAdmin()) {
            if ($authUser->city_id !== $user->city_id) {
                throw new HttpResponseException(response()->error(trans('messages.could_not_be_deleted'), Response::HTTP_BAD_REQUEST));
            }
        }

        if (!$user->delete()) {
            throw new HttpResponseException(response()->error(trans('messages.users.could_not_be_deleted'), Response::HTTP_BAD_REQUEST));
        }

        return response()->success(false, trans('messages.users.deleted_successfully'), Response::HTTP_OK);
    }

    /**
     * Remove user information from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function userWithdraw(User $user)
    {
        $authUser = request()->user();
        if (!$user) {
            throw new HttpResponseException(response()->error(trans('oauth.not_found'), Response::HTTP_NOT_FOUND));
        }

        $update_arr = array();
        $update_arr['nickname'] = '';
        $update_arr['name'] = '';
        $update_arr['birthday'] = '';
        $update_arr['gender'] = null;

        $update_arr['email'] = "removed_user_id_". $authUser->id . '@machidori.com';
        $update_arr['updated_at'] = date("Y-m-d");
        $authUser->update($update_arr);
        $authUser->delete();

        return response()->success($authUser, trans('messages.users.deleted_successfully'), Response::HTTP_OK);
    }
}
