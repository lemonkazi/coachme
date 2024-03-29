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


class ProfileController extends Controller
{
  use RegistersUsers;

  public function __construct()
  {
      parent::__construct();
  }

 

  
  private function uniqueString()
  {
      $m = explode(' ', microtime());
      list($totalSeconds, $extraMilliseconds) = array($m[1], (int)round($m[0] * 1000, 3));
      $txID = date('YmdHis', $totalSeconds) . sprintf('%03d', $extraMilliseconds);
      $txID = substr($txID, 2, 15);
      return $txID;
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
  public function profileUpdate(Request $request)
  {
      $data = $request->all();
      $authUser = $request->user();
      if (!$authUser) {
        return back();
      }
      if ($request->isMethod('post')) {

        $rules = array(
          'name'   => 'filled|string|max:50',
          'avatar_image_path' => 'nullable',
        );    
        $messages = array(
          'name.filled' => trans('messages.name.required'),
          'name.max' => trans('messages.name.max')
          
        );
        if (array_key_exists('authority', $data)) {
            unset($data['authority']);
        }
        
        if (array_key_exists('email', $data)) {
            unset($data['email']);
        }

          
        if (array_key_exists('current_password', $data)) {
            if(!Hash::check($data['current_password'], $authUser->password)){
                throw new HttpResponseException(response()->error(trans('messages.password.current'), Response::HTTP_BAD_REQUEST));
            }            
        }
        $validator = Validator::make( $data, $rules, $messages );

        if ( $validator->fails() ) 
        {
            
          Toastr::warning('Error occured',$validator->errors()->all()[0]);
          return redirect()->back()->withInput()->withErrors($validator);
        }
        else
        {

          if (!$authUser->update($data)) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }

          Toastr::success(trans('oauth.success_message'),'Success');
          return back();
        }
      }
      $rink_all = Rink::all()->pluck("name", "id")->sortBy("name");
      $experience_all = Experience::all()->pluck("name", "id")->sortBy("name");
      $certificate_all = Certificate::all()->pluck("name", "id")->sortBy("name");
      $language_all = Language::all()->pluck("name", "id")->sortBy("name");
      $price_all = Price::all()->pluck("name", "id")->sortBy("name");
      $speciality_all = Speciality::all()->pluck("name", "id")->sortBy("name");
      
    

      $response = [];

      
      if (!$authUser->isSuperAdmin()) { 
          $filterParams = [];
      }

      $breadcrumb = array(
        array(
           'name'=>trans('global.Profile'),
           'link'=>''
        )
      );

      return view('admin.profile.update', [
        'pageInfo'=>
         [
          'siteTitle'        =>'Manage Users',
          'pageHeading'      =>'Manage Users',
          'pageHeadingSlogan'=>'Here the section to manage all registered users'
          ]
          ,
          'data'=>
          [
             'user'      =>  $authUser,
             'breadcrumb' =>  $breadcrumb,
             'Title' =>  trans('global.Profile')
          ]
        ])->with(compact('rink_all','experience_all','speciality_all','language_all','price_all','certificate_all'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function updatePassword(Request $request)
  {
      $data = $request->all();
      $authUser = $request->user();

      $checkUser = User::where([
                      ['id', $authUser->id],
                      ['deleted_at', null],
                  ])->first();

      if ($request->isMethod('post')) {
        $rules = array(
            'current_password' => 'filled',
            'new_password' => 'filled|same:confirm_new_password',
            'confirm_new_password' => 'filled',
          );
        $messages = array(
          'current_password.filled' => trans('messages.current_password.required'),
            //'current_password.min' => trans('messages.current_password.min'),
            'new_password.filled' => trans('messages.new_password.required'),
            'new_password.min' => trans('messages.new_password.min'),
            'new_password.same' => trans('messages.new_password.same')
        );
        $validator = Validator::make( $data, $rules, $messages );

        if ( $validator->fails() ) 
        {
            
          Toastr::warning('Error occured',$validator->errors()->all()[0]);
          return redirect()->back()->withInput()->withErrors($validator);
        }
        else
        {

          $is_current_password_match = 0;
          if (isset($data['current_password']) && Hash::check($data['current_password'], $checkUser->password)) {
              $is_current_password_match = 1;
          } else {
            Toastr::warning('Error occured',trans('messages.current_password.current'));
            return redirect()->back()->withInput()->withErrors(trans('messages.current_password.current'));
          }

          if (isset($data['new_password']) && $is_current_password_match == 1) {
              $updateData['id'] = $authUser->id;
              $updateData['password'] = $data['new_password'];
              if (!$authUser->update($updateData)) {
                Toastr::warning('Error occured',trans('messages.error_message'));
                return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
              }
              Toastr::success(trans('oauth.update_password_successfully'),'Success');
              return back();
          }
        }
      }

      $breadcrumb = array(
        array(
           'name'=>trans('global.LABEL_CHANGE_PASSWORD'),
           'link'=>''
        )
      );

      return view('admin.profile.changepassword', [
        'pageInfo'=>
         [
          'siteTitle'        =>'Manage Users',
          'pageHeading'      =>'Manage Users',
          'pageHeadingSlogan'=>'Here the section to manage all registered users'
          ]
          ,
          'data'=>
          [
             'user'      =>  $authUser,
             'breadcrumb' =>  $breadcrumb,
             'Title' =>  trans('global.LABEL_CHANGE_PASSWORD')
          ]
        ]);
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

    
    if (!$user->isSuperAdmin()) { 
        $filterParams = [];
    }
    $response['data'] = $user;

    $breadcrumb = array(
      array(
         'name'=>trans('global.Profile'),
         'link'=>''
      )
    );

    return view('admin.profile.profile', [
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
