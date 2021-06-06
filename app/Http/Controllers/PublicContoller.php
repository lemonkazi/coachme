<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Testimonial;
use App\Models\UserInfo;
use App\Models\AttachedFile;
use App\Models\Rink;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Language;
use App\Models\Price;
use App\Models\Speciality;
use App\Models\Province;
use App\Models\Location;
use App\Models\CampType;
use App\Models\ProgramType;
use App\Models\Camp;
use App\Models\Program;
use App\Models\Level;
use View;
use Auth;
use Carbon\Carbon;
use App\Mail\VerifyMail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Auth\RegistersUsers;


use App\Providers\RouteServiceProvider;


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
        //$this->middleware(['auth', 'verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
      $testimonials = Testimonial::get()->sortByDesc('id')->take(4);

      $authority = array(
          'COACH_USER' => trans('global.LABEL_COACH_USER'),
          'RINK_USER' => trans('global.LABEL_RINK_USER')
      );
      return view('pages.home')
      ->with(compact('authority','testimonials'));
    }


    public function filter_coach(Request $request){
        $data = $request->all();
        if (isset($data["param"])) {// check is the param is set
          $params['name'] = $param = $data["param"]; // get the value of the param
          
          //$params['name'] = 'a';
          $user = User::first();
          $query = $user->coach_filter($params);
          $response = $query->orderBy('id', 'asc')->get(['name', 'avatar_image_path', 'id']);
          
          foreach ($response as $key=>$item) {
              $plucked[] = array (
                                'id' => $item->id,
                                'name'=> $item->name,
                                'avatar_image_path' => $item->avatar_image_path
                                  );
          }
          //send the response using json format
          echo json_encode($plucked);
        }
    }



    public function camp_add(Request $request){

      $user = $request->user();
      if (!$user) {
        return back(RouteServiceProvider::HOME);
      } else {
        $title=trans('global.Add Camp');
      }
      if ($request->isMethod('post')) {

        $data = $request->all();
        $rules = array(
            'name'   => 'required|string|max:255',
            'email'  => 'required|string|email|max:255'
          );    
        $messages = array(
                    'name.required' => trans('messages.name.required'),
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

          if (isset($data['coaches'])) {
           $data['coaches'] = json_encode(array_unique($data['coaches']));
          }

          
          $data['user_id'] = $user->id;
          $camp = Camp::create($data);
          if (!$camp) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }


          $files = $request->file('schedule_pdf_path');

          if($request->hasFile('schedule_pdf_path'))
          {
            $attached_file =array();
              foreach ($files as $file) {
                $new_name = $camp->id . '_s_' . self::uniqueString() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('files/camp_schedule'), $new_name);
                $attached_file['content_type'] = 'CAMP';
                $attached_file['content_id'] = $camp->id;
                $attached_file['type'] = 'SCHEDULE';
                $attached_file['user_id'] = $user->id;
                $attached_file['name'] = $new_name;
                $attached_file['path'] = 'files/camp_schedule/'.$new_name;
                $attached_file = AttachedFile::create($attached_file);
              }
          }


          $image_files = $request->file('camp_image_path');

          if($request->hasFile('camp_image_path'))
          {
            $attached_files =array();
              foreach ($image_files as $file) {
                $new_name = $camp->id . '_s_' . self::uniqueString() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photo/camp_photo'), $new_name);
                $attached_files['content_type'] = 'CAMP';
                $attached_files['content_id'] = $camp->id;
                $attached_files['type'] = 'PHOTO';
                $attached_files['user_id'] = $user->id;
                $attached_files['name'] = $new_name;
                $attached_files['path'] = 'photo/camp_photo/'.$new_name;
                $attached_file = AttachedFile::create($attached_files);
              }
          }
          //return redirect('/camp')->with('status', $status);
          return redirect()->intended(route('camp-update', ['camp' => $camp->id]));
          print_r($data);
          exit();
        }
        
      }
      $camp ='';
      $city_all = Location::all()->pluck("name", "id")->sortBy("name");
      $camp_type_all = CampType::all()->pluck("name", "id")->sortBy("name");
      $level_all = Level::all()->pluck("name", "id")->sortBy("name");
      
      $date = Carbon::now();
      $formatedDate = $date->format('Y-m-d');
      return view('pages.camp.edit', [
          'data'=>
          [
               'camp'      =>  $camp,
               'user'      =>  $user,
               'Title' =>  $title
          ]
      ])
      ->with(compact('formatedDate','city_all','camp_type_all','level_all'));
    }

    public function camp_edit(Request $request, Camp $camp){
      $user = $request->user();
      if (!$user) {
        return back(RouteServiceProvider::HOME);
      } else {
        $title=trans('global.Update Camp');
      }


      if (!$camp) {
        return back();
      }




      if ($request->isMethod('post')) {

        $data = $request->all();
        $rules = array(
            'name'   => 'required|string|max:255',
            'email'  => 'required|string|email|max:255'
          );    
        $messages = array(
                    'name.required' => trans('messages.name.required'),
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

          if (!empty($data['coaches'])) {
            $data['coaches'] = json_encode(array_unique($data['coaches']));
          }else{
            unset($data['coaches']);
          }

          
          $data['user_id'] = $user->id;

          if (!$camp->update($data)) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }


          $files = $request->file('schedule_pdf_path');

          if($request->hasFile('schedule_pdf_path'))
          {

            AttachedFile::where([
                        ['content_id', $camp->id],
                        ['content_type', 'CAMP'],
                        ['type', 'SCHEDULE'],
                        ['deleted_at', null],
                    ])->delete();

            $attached_file =array();
              foreach ($files as $file) {
                $new_name = $camp->id . '_s_' . self::uniqueString() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('files/camp_schedule'), $new_name);
                $attached_file['content_type'] = 'CAMP';
                $attached_file['content_id'] = $camp->id;
                $attached_file['type'] = 'SCHEDULE';
                $attached_file['user_id'] = $user->id;
                $attached_file['name'] = $new_name;
                $attached_file['path'] = 'files/camp_schedule/'.$new_name;
                $attached_file = AttachedFile::create($attached_file);
              }
          }


          $image_files = $request->file('camp_image_path');

          if($request->hasFile('camp_image_path'))
          {
            AttachedFile::where([
                        ['content_id', $camp->id],
                        ['content_type', 'CAMP'],
                        ['type', 'PHOTO'],
                        ['deleted_at', null],
                    ])->delete();
            $attached_files =array();
              foreach ($image_files as $file) {
                $new_name = $camp->id . '_s_' . self::uniqueString() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photo/camp_photo'), $new_name);
                $attached_files['content_type'] = 'CAMP';
                $attached_files['content_id'] = $camp->id;
                $attached_files['type'] = 'PHOTO';
                $attached_files['user_id'] = $user->id;
                $attached_files['name'] = $new_name;
                $attached_files['path'] = 'photo/camp_photo/'.$new_name;
                $attached_file = AttachedFile::create($attached_files);
              }
          }
          //return redirect('/camp')->with('status', $status);
          return redirect()->intended(route('camp-update', ['camp' => $camp->id]));
          
        }
        
      }


      //$camp ='';
      $city_all = Location::all()->pluck("name", "id")->sortBy("name");
      $camp_type_all = CampType::all()->pluck("name", "id")->sortBy("name");
      $level_all = Level::all()->pluck("name", "id")->sortBy("name");
      
      $date = Carbon::now();
      $formatedDate = $date->format('Y-m-d');
      $coaches =array();
      if(!empty($camp) && !empty($camp->coaches)){
        $coaches_data = json_decode($camp->coaches);
        foreach ($coaches_data as $key=>$coach) {
          $coaches[] = User::find($coach, ['name', 'avatar_image_path', 'id'])->toArray();
        }
      }




       $camp_photo = AttachedFile::where([
                        ['content_id', $camp->id],
                        ['content_type', 'CAMP'],
                        ['type', 'PHOTO'],
                        ['deleted_at', null],
                    ])->get(['name', 'path', 'id'])->toArray();

       $camp_schedule = AttachedFile::where([
                        ['content_id', $camp->id],
                        ['content_type', 'CAMP'],
                        ['type', 'SCHEDULE'],
                        ['deleted_at', null],
                    ])->get(['name', 'path', 'id'])->toArray();

       



      return view('pages.camp.edit', [
          'data'=>
          [
               'camp'      =>  $camp,
               'camp_photo'      =>  $camp_photo,
               'camp_schedule'      =>  $camp_schedule,
               'coaches'   => $coaches,
               'user'      =>  $user,
               'Title' =>  $title
          ]
      ])
      ->with(compact('formatedDate','city_all','camp_type_all','level_all'));
    }


    public function camp_details(Request $request, Camp $camp){
      
      if (!$camp) {
        return back(RouteServiceProvider::HOME);
      } else {
        $title=trans('global.Camp Details');
      }

      $date = Carbon::now();
      $formatedDate = $date->format('Y-m-d');
      $coaches =array();
      if(!empty($camp) && !empty($camp->coaches)){
        $coaches_data = json_decode($camp->coaches);
        foreach ($coaches_data as $key=>$coach) {
          $coaches[] = User::find($coach, ['name', 'avatar_image_path', 'id'])->toArray();
        }
      }




       $camp_photo = AttachedFile::where([
                        ['content_id', $camp->id],
                        ['content_type', 'CAMP'],
                        ['type', 'PHOTO'],
                        ['deleted_at', null],
                    ])->get(['name', 'path', 'id'])->toArray();

       $camp_schedule = AttachedFile::where([
                        ['content_id', $camp->id],
                        ['content_type', 'CAMP'],
                        ['type', 'SCHEDULE'],
                        ['deleted_at', null],
                    ])->get(['name', 'path', 'id'])->toArray();

       
      $start_date = strtotime($camp->start_date);
      $end_date = strtotime($camp->end_date);

      // echo date('m', $unixtime); //month
      // echo date('d', $unixtime); 
      // echo date('y', $unixtime );
      return view('pages.camp.details', [
          'data'=>
          [
               'camp'      =>  $camp,
               'start_date'      =>  $start_date,
               'end_date'      =>  $end_date,
               'camp_photo'      =>  $camp_photo,
               'camp_schedule'      =>  $camp_schedule,
               'coaches'   => $coaches,
               'Title' =>  $title
          ]
      ])
      ->with(compact('formatedDate'));
    }

    public function program_add(Request $request){

      $user = $request->user();
      if (!$user) {
        return back(RouteServiceProvider::HOME);
      } else {
        $title=trans('global.Add Program');
      }


      if ($request->isMethod('post')) {

        $data = $request->all();
        $rules = array(
            'name'   => 'required|string|max:255',
            'email'  => 'required|string|email|max:255'
          );    
        $messages = array(
                    'name.required' => trans('messages.name.required'),
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

          // if (isset($data['coaches'])) {
          //  $data['coaches'] = json_encode(array_unique($data['coaches']));
          // }

          
          $data['user_id'] = $user->id;
          // print_r($data);
          // exit();
          $program = Program::create($data);
          if (!$program) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }


          

          $image_files = $request->file('program_image_path');

          if($request->hasFile('program_image_path'))
          {
            $attached_files =array();
              foreach ($image_files as $file) {
                $new_name = $program->id . '_s_' . self::uniqueString() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photo/program_photo'), $new_name);
                $attached_files['content_type'] = 'PROGRAM';
                $attached_files['content_id'] = $program->id;
                $attached_files['type'] = 'PHOTO';
                $attached_files['user_id'] = $user->id;
                $attached_files['name'] = $new_name;
                $attached_files['path'] = 'photo/program_photo/'.$new_name;
                $attached_file = AttachedFile::create($attached_files);
              }
          }
          //return redirect('/program')->with('status', $status);
          return redirect()->intended(route('program-update', ['program' => $program->id]));
          print_r($data);
          exit();
        }
        
      }

      $program ='';
      $city_all = Location::all()->pluck("name", "id")->sortBy("name");
      $program_type_all = ProgramType::all()->pluck("name", "id")->sortBy("name");
      $level_all = Level::all()->pluck("name", "id")->sortBy("name");
      
      $date = Carbon::now();
      $formatedDate = $date->format('Y-m-d');

      return view('pages.program.edit', [
          'data'=>
          [
               'program'      =>  $program,
               'user'      =>  $user,
               'Title' =>  $title
          ]
      ])
      ->with(compact('formatedDate','city_all','program_type_all','level_all'));

    }

    public function program_edit(Request $request, Program $program){
      
      $user = $request->user();
      if (!$user) {
        return back(RouteServiceProvider::HOME);
      } else {
        $title=trans('global.Update Program');
      }


      if (!$program) {
        return back();
      }




      if ($request->isMethod('post')) {

        $data = $request->all();
        $rules = array(
            'name'   => 'required|string|max:255',
            'email'  => 'required|string|email|max:255'
          );    
        $messages = array(
                    'name.required' => trans('messages.name.required'),
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

         

          
          $data['user_id'] = $user->id;

          if (!$program->update($data)) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }



          $image_files = $request->file('program_image_path');

          if($request->hasFile('program_image_path'))
          {
            AttachedFile::where([
                        ['content_id', $program->id],
                        ['content_type', 'PROGRAM'],
                        ['type', 'PHOTO'],
                        ['deleted_at', null],
                    ])->delete();
            $attached_files =array();
              foreach ($image_files as $file) {
                $new_name = $program->id . '_s_' . self::uniqueString() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photo/program_photo'), $new_name);
                $attached_files['content_type'] = 'PROGRAM';
                $attached_files['content_id'] = $program->id;
                $attached_files['type'] = 'PHOTO';
                $attached_files['user_id'] = $user->id;
                $attached_files['name'] = $new_name;
                $attached_files['path'] = 'photo/program_photo/'.$new_name;
                $attached_file = AttachedFile::create($attached_files);
              }
          }
          //return redirect('/program')->with('status', $status);
          return redirect()->intended(route('program-update', ['program' => $program->id]));
          
        }
        
      }


      //$program ='';
      $city_all = Location::all()->pluck("name", "id")->sortBy("name");
      $program_type_all = CampType::all()->pluck("name", "id")->sortBy("name");
      $level_all = Level::all()->pluck("name", "id")->sortBy("name");
      
      $date = Carbon::now();
      $formatedDate = $date->format('Y-m-d');
      $coaches =array();
      if(!empty($program) && !empty($program->coaches)){
        $coaches_data = json_decode($program->coaches);
        foreach ($coaches_data as $key=>$coach) {
          $coaches[] = User::find($coach, ['name', 'avatar_image_path', 'id'])->toArray();
        }
      }




       $program_photo = AttachedFile::where([
                        ['content_id', $program->id],
                        ['content_type', 'CAMP'],
                        ['type', 'PHOTO'],
                        ['deleted_at', null],
                    ])->get(['name', 'path', 'id'])->toArray();

       $program_schedule = AttachedFile::where([
                        ['content_id', $program->id],
                        ['content_type', 'CAMP'],
                        ['type', 'SCHEDULE'],
                        ['deleted_at', null],
                    ])->get(['name', 'path', 'id'])->toArray();

      

      return view('pages.program.edit', [
          'data'=>
          [
               'program'      =>  $program,
               'program_photo'      =>  $program_photo,
               'program_schedule'      =>  $program_schedule,
               'coaches'   => $coaches,
               'user'      =>  $user,
               'Title' =>  $title
          ]
      ])
      ->with(compact('formatedDate','city_all','program_type_all','level_all'));
    }

    public function program_details(Request $request, Program $program){
      
      if (!$program) {
        return back(RouteServiceProvider::HOME);
      } else {
        $title=trans('global.Program Details');
      }

      $date = Carbon::now();
      $formatedDate = $date->format('Y-m-d');
      




       $program_photo = AttachedFile::where([
                        ['content_id', $program->id],
                        ['content_type', 'PROGRAM'],
                        ['type', 'PHOTO'],
                        ['deleted_at', null],
                    ])->get(['name', 'path', 'id'])->toArray();

       
      $reg_start_date = strtotime($program->reg_start_date);
      $reg_end_date = strtotime($program->reg_end_date);

      // echo date('m', $unixtime); //month
      // echo date('d', $unixtime); 
      // echo date('y', $unixtime );
      return view('pages.program.details', [
          'data'=>
          [
               'program'      =>  $program,
               'reg_start_date'      =>  $reg_start_date,
               'reg_end_date'      =>  $reg_end_date,
               'program_photo'      =>  $program_photo,
               'Title' =>  $title
          ]
      ])
      ->with(compact('formatedDate'));
    }
    public function coach_details(){
      return view('pages.coach.details');
    }
    public function rink_list(){
      return view('pages.rink.list');
    }
    public function program_list(){
      return view('pages.program.list');
    }
    public function coach_edit(Request $request){
      $user = $request->user();
      if (!$user) {
        return back(RouteServiceProvider::HOME);
      } else {
        $title=trans('global.Edit Coach');
      }
      if ($request->isMethod('post')) {

        $data = $request->all();
        //$user = $request->user();
        if (isset($data['is_published']) && $data['is_published'] =='on') {
          $data['is_published'] = 1;
        } else {
          $data['is_published'] = 0;
        }
        //$data['authority'] = User::ACCESS_LEVEL_COACH;



        $rules = array(
                'name'   => 'required|string|max:255',
                'email'  => 'required|string|email|max:255',
                'avatar_image_path' => 'nullable'
              );    
        $messages = array(
                    'name.required' => trans('messages.name.required'),
                    'name.max' => trans('messages.name.max'),
                    'email.required' => trans('messages.email.required'),
                    'email.string' => trans('messages.email.string'),
                    'email.email' => trans('messages.email.email'),
                    'email.max' => trans('messages.email.max')                    
                  );
        $validator = Validator::make( $data, $rules, $messages );

        if ( $validator->fails() ) 
        {
            
          //Toastr::warning('Error occured',$validator->errors()->all()[0]);
          return redirect()->back()->withInput()->withErrors($validator);
        }
        else
        {
          if (isset($data['email'])) {
              $userExists = User::where([
                                          ['id', '<>', $user->id],
                                          ['email', $data['email']]
                                      ])->first();
          }
            
          if ($userExists) {
            return redirect()->back()->withInput()->withErrors(trans('messages.email.already_registered'));
          }
          
          //$eMail = new CoachmeAppsMail();
          //$eMail->resetPasswordMail($data['email'], $oauth_token, $userExists,$os);
            
          $data['is_verified'] = true;
          //$user = User::create($data);
          if (isset($data['rink_id'])) {
            foreach ($data['rink_id'] as $key => $rink_id) {

              $rink = Rink::find($rink_id);

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
            
            
          }

          if (isset($data['speciality_id'])) {
            foreach ($data['speciality_id'] as $key => $speciality_id) {

              $speciality = Speciality::find($speciality_id);

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
            
          }
          if (isset($data['language_id'])) {
            foreach ($data['language_id'] as $key => $language_id) {
            
              $language = Language::find($language_id);

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
          }
          
          $data['token'] = sha1(time());
          
          if($request->file('avatar_image_path'))
          {
            $image = $request->file('avatar_image_path');
            $new_name = $user->id . '_s_' . self::uniqueString() . '.' . $image->getClientOriginalExtension();
            
            $image->move(public_path('photo/user_photo'), $new_name);
            $data['avatar_image_path'] = $new_name;
          }
          if (!$user->update($data)) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }
          

          
          //Toastr::success(trans('global.A new Coach has been created'),'Success');
          //return back();
        }

      }

      $city_all = Location::all()->pluck("name", "id")->sortBy("name");
      $province_all = Province::all()->pluck("name", "id")->sortBy("name");

      $rink_all = Rink::all()->pluck("name", "id")->sortBy("name");
      $experience_all = Experience::all()->pluck("name", "id")->sortBy("name");
      $certificate_all = Certificate::all()->pluck("name", "id")->sortBy("name");
      $language_all = Language::all()->pluck("name", "id")->sortBy("name");
      $price_all = Price::all()->pluck("name", "id")->sortBy("name");
      $speciality_all = Speciality::all()->pluck("name", "id")->sortBy("name");
      
      return view('pages.coach.edit', [
          'data'=>
          [
               'user'      =>  $user,
               'Title' =>  $title
          ]
      ])
      ->with(compact('rink_all','experience_all','speciality_all','language_all','price_all','certificate_all','province_all','city_all'));

    }

    public function verifyUser($token)
    {
      $user = User::where('token', $token)->first();


      if(isset($user) ){
        //$user = $verifyUser->user;
        if(!$user->is_verified || $user->email_verified_at ==null) {
          $user->is_verified = true;
          $user->email_verified_at = now();
          $user->save();
          $status = "Your e-mail is verified. You can now login.";
        } else {
          $status = "Your e-mail is already verified. You can now login.";
        }
      } else {
        return redirect('/')->with('warning', "Sorry your email cannot be identified.");
      }
      return redirect('/')->with('status', $status);
    }

    /**
     * Display login.
     *
     * @return Response
     */
    public function login()
    {
      if (Auth::check()) {
          $user = Auth::user();
          if ($user->isSuperAdmin()) {
              return redirect()->intended(route('home'));
          }
          elseif ($user->isCoachUser()) {
            return redirect(RouteServiceProvider::PROFILE);
          }
          elseif ($user->isRinkUser()) {
            return redirect(RouteServiceProvider::ROOT);
          } 
          else{
            return redirect(RouteServiceProvider::ROOT);
          }
      }
      return View::make('auth.publiclogin', ['title' => 'User Login','pageInfo'=>['siteTitle'=>'COACH ME']]);
    }

    public function publiclogin(Request $request)
    {
      $data = $request->all();
     
      $rules = array(
            'email'  => 'required|string|email|max:255',
            'password' => 'required|min:5'
          );    
      $messages = array(
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
        return response()->json(['errors'=>$validator->errors()->all()]);
      }
      else
      {
        $user = User::where([
                  ['email', $data['email']],
                  ['deleted_at', null],
             ])->first();
        if ($user) {
            $usernotVerified = User::where([
                  ['email', $data['email']],
                  ['email_verified_at', null]
            ])->first();
            if ($usernotVerified) {
              return response()->json(['errors'=>['email not verified please verify']]);
            }
            if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
                
                if ($user->isSuperAdmin()) {
                  return response()->json(['success'=>true,'token'=>csrf_token(),'result'=>trans('messages.success_message'),'url'=> route('home')]);
                  
                } elseif ($user->isCoachUser()) {
                  return response()->json(['success'=>true,'token'=>csrf_token(),'result'=>trans('messages.success_message'),'url'=> RouteServiceProvider::PROFILE]);
                }
                elseif ($user->isRinkUser()) {
                  return response()->json(['success'=>true,'token'=>csrf_token(),'result'=>trans('messages.success_message'),'url'=> RouteServiceProvider::ROOT]);
                } else{
                  return response()->json(['success'=>true,'token'=>csrf_token(),'result'=>trans('messages.success_message'),'url'=> RouteServiceProvider::ROOT]);
                }
                
            }
        }
        return response()->json(['errors'=>['Login failed, please try again!']]);
      }
    }

    private function validator(Request $request)
    {
        $rules = [
            'email'    => 'required|email|min:5|max:191',
            'password' => 'required|string|min:6|max:255'
        ];
        $request->validate($rules);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     */
    public function publicRegister(Request $request)
    {
        $data = $request->all();

        $rules = array(
            'authority' => 'required|in:COACH_USER,RINK_USER',
            'email'  => 'required|string|email|max:255',
            'password' => 'required|min:8'
        );    
        $messages = array(
            'authority.required' => trans('messages.authority.required'),
            'authority.in' => trans('messages.authority.in'),
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
          return response()->json(['errors'=>$validator->errors()->all()]);
        }
        else
        {
          $userExists = User::where([
                                    ['email', $data['email']],
                                    ['deleted_at', null],
                                ])->first();
        
          if ($userExists) {
            return response()->json(['errors'=>[trans('messages.email.already_registered')]]);
            //throw new HttpResponseException(response()->error(trans('messages.email.already_registered'), Response::HTTP_BAD_REQUEST));
          }
          
          $data['is_verified'] = true;
          $data['token'] = sha1(time());
          $user = User::create($data);
          
          if (!$user) {
            return response()->json(['errors'=>['Registration failed, please try again!']]);
          }
          if (config('global.email_send') == 1) {
            \Mail::to($user->email)->send(new VerifyMail($user));
            return response()->json(['success'=>true,'result'=>'We sent you an activation code. Check your email and click on the link to verify.','url'=> RouteServiceProvider::ROOT]);
            
          }
          return response()->json(['success'=>true,'result'=>'Registration successfull','url'=> RouteServiceProvider::ROOT]);
            

              
          
          //Toastr::success(trans('global.A new User has been created'),'Success');
          //return back();
        }
    }

    public function username()
    {
        return 'email';
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