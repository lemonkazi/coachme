<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Testimonial;
use App\Models\UserInfo;
use App\Models\AttachedFile;
use App\Models\Period;
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

use Intervention\Image\ImageManagerStatic as InterventionImageManager;
use Illuminate\Support\Facades\Storage;

use App\Providers\RouteServiceProvider;
use Cookie;

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
      $rink_all = Rink::all()->sortBy("name")->toArray();
      $rinks=[];
      foreach ($rink_all as $key => $value) {
        $rinks[]=array(
          "Id"=> $value['id'],
          "PropertyCode"=> $value['name'],
          "address"=> ( $value['address'] ) ? $value['address'] : '' ,
          "latitude"=> ( $value['latitude'] ) ? $value['latitude'] : '' ,
          "longitude"=> ( $value['longitude'] ) ? $value['longitude'] : '' ,
          "GMapIconImage"=> "/assets/markers/marker.png",
          "type"=> "Hotel",
          "hotelName"=> $value['name']
        );
      }
      //print_r($rinks);
      //$rinks  = json_encode($rinks);
      //exit();
      
      return view('pages.home')
      ->with(compact('authority','testimonials','rinks'));
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

      $rink ='';
      if (isset($_COOKIE['cookieRink'])) {
          $rink = Rink::find($_COOKIE['cookieRink']);
      } 
      if ($user->authority =='RINK_USER') {
        //$data['web_site_url'] = $user->web_site_url;
        $rinks = $user->userinfos['rinks'];
        //$rink = '';
        if (!empty($rinks) ) {
          foreach($rinks as $row){
              $rink =$row->content_id;
              //$rink = Rink::find($rink);
              $rink = Rink::find($row->content_id);
              //$data['rink_id'] = $rink->id;
              //break();
          }
        }
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
            
          //Toastr::warning('Error occured',$validator->errors()->all()[0]);
          return redirect()->back()->withInput()->withErrors($validator);
        }
        else
        {

          if (isset($data['coaches'])) {
           $data['coaches'] = json_encode(array_unique($data['coaches']));
          }

          if (isset($data['camp_type_id'])) {
           $data['camp_type_id'] = json_encode(array_unique($data['camp_type_id']));
          }

          if (isset($_COOKIE['cookieRink'])) {
              $data['rink_id'] = $_COOKIE['cookieRink'];
          }
          if (isset($_COOKIE['cookieWebURL'])) {
              $data['web_site_url'] = $_COOKIE['cookieWebURL'];
          }
          if ($user->authority =='RINK_USER') {
            $data['web_site_url'] = $user->web_site_url;
            $rinks = $user->userinfos['rinks'];
            //$rink = '';
            if (!empty($rinks) ) {
              foreach($rinks as $row){
                  $rink =$row->content_id;
                  //$rink = Rink::find($rink);
                  $rink = Rink::find($row->content_id);
                  $data['rink_id'] = $rink->id;
                  //break();
              }
            }
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

          if ($user->authority=='RINK_USER') {
            $status = "Camp Successfully added.";
            return redirect(route(RouteServiceProvider::RINK_PROFILE))->with('status', $status);
          
          } else {
            return redirect()->intended(route('camp-update', ['camp' => $camp->id]));
          
          }
          //return redirect('/camp')->with('status', $status);
          // print_r($data);
          // exit();
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
               'Title' =>  $title,
               'rink' =>$rink
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

      $rink ='';
      if (isset($_COOKIE['cookieRink'])) {
          $rink = Rink::find($_COOKIE['cookieRink']);
      } 
      if ($user->authority =='RINK_USER') {
        //$data['web_site_url'] = $user->web_site_url;
        $rinks = $user->userinfos['rinks'];
        //$rink = '';
        if (!empty($rinks) ) {
          foreach($rinks as $row){
              $rink =$row->content_id;
              //$rink = Rink::find($rink);
              $rink = Rink::find($row->content_id);
              //$data['rink_id'] = $rink->id;
              //break();
          }
        }
      }
      if (!empty($camp->rink_id)) {
        $rink = Rink::find($camp->rink_id);
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
            
          //Toastr::warning('Error occured',$validator->errors()->all()[0]);
          return redirect()->back()->withInput()->withErrors($validator);
        }
        else
        {

          if (!empty($data['coaches'])) {
            $data['coaches'] = json_encode(array_unique($data['coaches']));
          }else{
            unset($data['coaches']);
          }
          if (!empty($data['camp_type_id'])) {
            $data['camp_type_id'] = json_encode(array_unique($data['camp_type_id']));
          }else{
            unset($data['camp_type_id']);
          }
          if (isset($_COOKIE['cookieRink'])) {
              $data['rink_id'] = $_COOKIE['cookieRink'];
          }
          if (isset($_COOKIE['cookieWebURL'])) {
              $data['web_site_url'] = $_COOKIE['cookieWebURL'];
          }
          if ($user->authority =='RINK_USER') {
            $data['web_site_url'] = $user->web_site_url;
            $rinks = $user->userinfos['rinks'];
            //$rink = '';
            if (!empty($rinks) ) {
              foreach($rinks as $row){
                  $rink =$row->content_id;
                  //$rink = Rink::find($rink);
                  $rink = Rink::find($row->content_id);
                  $data['rink_id'] = $rink->id;
                  //break();
              }
            }
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

      $camp_type_id =array();
      if(!empty($camp) && !empty($camp->camp_type_id)){
        $camp_type_id_data = json_decode($camp->camp_type_id);
        foreach ($camp_type_id_data as $key=>$camp_type) {
          $camp_type_id[] = CampType::find($camp_type, ['name', 'id'])->toArray();
        }
      }

      // print_r($camp_type_id);
      // exit();




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
               'camp_type_id'   => $camp_type_id,
               'user'      =>  $user,
               'Title' =>  $title,
               'rink' => $rink
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
          $coache = User::select('name', 'avatar_image_path', 'id')->where('id', '=', $coach)->where('deleted_at', '=', null)->get()->toArray();
          if (!empty($coache)) {
            $coaches[] =$coache[0];
          }
        }
      }

      $camp_type_id =array();
      if(!empty($camp) && !empty($camp->camp_type_id)){
        $camp_type_id_data = json_decode($camp->camp_type_id);
        foreach ($camp_type_id_data as $key=>$coach) {
          $camp_type_id[] = CampType::find($coach, ['name', 'id'])->toArray();
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
               'camp_type_id'   => $camp_type_id,
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

      $rink ='';
      if (isset($_COOKIE['cookieRink'])) {
          $rink = Rink::find($_COOKIE['cookieRink']);
      }

      if ($user->authority =='RINK_USER') {
        
        $rinks = $user->userinfos['rinks'];
        //$rink = '';
        if (!empty($rinks) ) {
          foreach($rinks as $row){
              $rink =$row->content_id;
              //$rink = Rink::find($rink);
              $rink = Rink::find($row->content_id);
              //break();
          }
        }
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
            
          //Toastr::warning('Error occured',$validator->errors()->all()[0]);
          return redirect()->back()->withInput()->withErrors($validator);
        }
        else
        {

          // if (isset($data['coaches'])) {
          //  $data['coaches'] = json_encode(array_unique($data['coaches']));
          // }

          if (isset($data['program_type_id'])) {
           $data['program_type_id'] = json_encode(array_unique($data['program_type_id']));
          }

          if (isset($_COOKIE['cookieRink'])) {
              $data['rink_id'] = $_COOKIE['cookieRink'];
          }
          if (isset($_COOKIE['cookieWebURL'])) {
              $data['web_site_url'] = $_COOKIE['cookieWebURL'];
          }

          if ($user->authority =='RINK_USER') {
            $data['web_site_url'] = $user->web_site_url;
            $rinks = $user->userinfos['rinks'];
            //$rink = '';
            if (!empty($rinks) ) {
              foreach($rinks as $row){
                  $rink =$row->content_id;
                  //$rink = Rink::find($rink);
                  $rink = Rink::find($row->content_id);
                  $data['rink_id'] = $rink->id;
                  //break();
              }
            }
          }

          
          $data['user_id'] = $user->id;

          
          
          $program = Program::create($data);
          if (!$program) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }
          $periods =array();
          foreach ($data['schedule_start_date'] as $key => $value) {
            $periods['content_type'] = 'PROGRAM';
            $periods['content_id'] = $program->id;
            $periods['type'] = $this->season(array($value, $data['schedule_end_date'][$key]));
            $periods['user_id'] = $user->id;
            $periods['start_date'] = $value;
            $periods['end_date'] = $data['schedule_end_date'][$key];


            $attached_file = Period::create($periods);
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
          if ($user->authority=='RINK_USER') {
            $status = "Program Successfully added.";
            return redirect(route(RouteServiceProvider::RINK_PROFILE))->with('status', $status);
          
          } else {
            return redirect()->intended(route('program-update', ['program' => $program->id]));
          
          }
          
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
               'Title' =>  $title,
               'rink' => $rink
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
      $rink ='';
      if (isset($_COOKIE['cookieRink'])) {
          $rink = Rink::find($_COOKIE['cookieRink']);
      }
      if ($user->authority =='RINK_USER') {
        
        $rinks = $user->userinfos['rinks'];
        //$rink = '';
        if (!empty($rinks) ) {
          foreach($rinks as $row){
              $rink =$row->content_id;
              //$rink = Rink::find($rink);
              $rink = Rink::find($row->content_id);
              //break();
          }
        }
      }
      if (!empty($program->rink_id)) {
        $rink = Rink::find($program->rink_id);
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
            
          //Toastr::warning('Error occured',$validator->errors()->all()[0]);
          return redirect()->back()->withInput()->withErrors($validator);
        }
        else
        {

          if (!empty($data['program_type_id'])) {
            $data['program_type_id'] = json_encode(array_unique($data['program_type_id']));
          }else{
            unset($data['program_type_id']);
          }
          if (isset($_COOKIE['cookieRink'])) {
              $data['rink_id'] = $_COOKIE['cookieRink'];
          }
          if (isset($_COOKIE['cookieWebURL'])) {
              $data['web_site_url'] = $_COOKIE['cookieWebURL'];
          }

          if ($user->authority =='RINK_USER') {
            $data['web_site_url'] = $user->web_site_url;
            $rinks = $user->userinfos['rinks'];
            //$rink = '';
            if (!empty($rinks) ) {
              foreach($rinks as $row){
                  $rink =$row->content_id;
                  //$rink = Rink::find($rink);
                  $rink = Rink::find($row->content_id);
                  $data['rink_id'] = $rink->id;
                  //break();
              }
            }
          }
          
          $data['user_id'] = $user->id;

          if (!$program->update($data)) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          }



          Period::where([
                        ['content_id', $program->id],
                        ['content_type', 'PROGRAM'],
                        ['deleted_at', null],
                    ])->delete();
          $periods =array();
          foreach ($data['schedule_start_date'] as $key => $value) {
            $periods['content_type'] = 'PROGRAM';
            $periods['content_id'] = $program->id;
            //$periods['type'] = 'FALL';
            $periods['user_id'] = $user->id;
            $periods['start_date'] = $value;
            $periods['end_date'] = $data['schedule_end_date'][$key];

            $periods['type'] = $this->season(array($value, $data['schedule_end_date'][$key]));
            $attached_file = Period::create($periods);
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

          if ($user->authority=='RINK_USER') {
            $status = "Program Successfully Updated.";
            return redirect(route(RouteServiceProvider::RINK_PROFILE))->with('status', $status);
          } else {
            return redirect()->intended(route('program-update', ['program' => $program->id]));
          
          }
          //return redirect('/program')->with('status', $status);
         
        }
        
      }


      //$program ='';
      $city_all = Location::all()->pluck("name", "id")->sortBy("name");
      $program_type_all = ProgramType::all()->pluck("name", "id")->sortBy("name");
      $level_all = Level::all()->pluck("name", "id")->sortBy("name");
      
      $date = Carbon::now();
      $formatedDate = $date->format('Y-m-d');
      
      $program_type_id =array();
      if(!empty($program) && !empty($program->program_type_id)){
        $program_type_id_data = json_decode($program->program_type_id);
        foreach ($program_type_id_data as $key=>$program_type) {
          $program_type_id[] = ProgramType::find($program_type, ['name', 'id'])->toArray();
        }
      }


       $program_photo = AttachedFile::where([
                        ['content_id', $program->id],
                        ['content_type', 'PROGRAM'],
                        ['type', 'PHOTO'],
                        ['deleted_at', null],
                    ])->get(['name', 'path', 'id'])->toArray();

       $program_periods = Period::where([
                        ['content_id', $program->id],
                        ['content_type', 'PROGRAM'],
                        //['type', 'PHOTO'],
                        ['deleted_at', null],
                    ])->get(['start_date', 'end_date', 'id'])->toArray();

      // $periods = array();
      // foreach ($program_periods as $key => $period) {
      //   $periods[] = array (
      //     'start_date' => date('Y-m-d', strtotime($period['start_date'])),
      //     'end_date' => date('Y-m-d', strtotime($period['end_date']))
      //   );
                        
      // }
      // print_r($program_type_all);
      // exit();
                        

      return view('pages.program.edit', [
          'data'=>
          [
               'program'      =>  $program,
               'program_photo'      =>  $program_photo,
               'program_periods'      =>  $program_periods,
               'program_type_id'   => $program_type_id,
               'program_type_all' => $program_type_all,
               'user'      =>  $user,
               'Title' =>  $title,
               'rink' => $rink
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

      $program_type_id =array();
      if(!empty($program) && !empty($program->program_type_id)){
        $program_type_id_data = json_decode($program->program_type_id);
        foreach ($program_type_id_data as $key=>$program_type) {
          $program_type_id[] = ProgramType::find($program_type, ['name', 'id'])->toArray();
        }
      }


      $reg_start_date = strtotime($program->reg_start_date);
      $reg_end_date = strtotime($program->reg_end_date);
      $schedule_start_date = strtotime($program->schedule_start_date);
      $schedule_end_date = strtotime($program->schedule_end_date);

      // echo date('m', $unixtime); //month
      // echo date('d', $unixtime); 
      // echo date('y', $unixtime );
      return view('pages.program.details', [
          'data'=>
          [
               'program'      =>  $program,
               'reg_start_date'      =>  $reg_start_date,
               'reg_end_date'      =>  $reg_end_date,
               'schedule_start_date'      =>  $schedule_start_date,
               'schedule_end_date'      =>  $schedule_end_date,
               'program_photo'      =>  $program_photo,
               'Title' =>  $title,
               'program_type_id'   => $program_type_id
          ]
      ])
      ->with(compact('formatedDate'));
    }
    public function coach_details(Request $request, User $user){
      if (!$user) {
         return redirect(RouteServiceProvider::ROOT);
      } else {
        $title=trans('global.Program Details');
      }

      if ($user->is_published !=1) {
         return redirect(RouteServiceProvider::ROOT);
      } 
      $ooo = $user->userinfos['speciality'];
      $specialityaa = '';
      foreach($ooo as $row){
          $specialityaa .=$row->content_name.',';
      }
      $speciality = trim($specialityaa,',');


      $rink = $user->userinfos['rinks'];
      $specialityaa = '';
      foreach($rink as $row){
          $specialityaa .=$row->content_name.',';
      }
      $rink = trim($specialityaa,',');

      $language = $user->userinfos['languages'];
      $specialityaa = '';
      foreach($language as $row){
          $specialityaa .=$row->content_name.',';
      }
      $language = trim($specialityaa,',');

      return view('pages.coach.details', [
          'data'=>
          [
               'user'      =>  $user,
               'Title' =>  $title,
               'speciality' => $speciality,
               'rink' => $rink,
               'language' => $language
          ]
      ]);
      //->with(compact('formatedDate'));
      //return view('pages.coach.details');
    }

    public function camp_list(Request $request, Camp $camp){

      $params = $request->all();
      //$params['period'] = 'spring';
      $query = $camp->filter($params);

     
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
      //$programs = $query->paginate($limit);
      $camps = $query->get()->toArray();

      $title=trans('global.Camp List');

      $province_all = Province::all()->pluck("name", "id")->sortBy("name");
      $city_all =array();
      if (isset($params['province_id']) && !empty($params['province_id'])) {
        $city_all = Location::all()->where('province_id',$params['province_id'])->pluck('name','id')->sortBy("name");
      }
      $camp_type_all = CampType::all()->pluck("name", "id")->sortBy("name");
      $level_all = Level::all()->pluck("name", "id")->sortBy("name");
      $rink_all = Rink::all()->pluck("name", "id")->sortBy("name");
      
      
      $date = Carbon::now();
      $formatedDate = $date->format('Y-m-d');

      $filtered_coach = array();
      if (isset($_GET['coach_id'])) {
        $filtered_coach = explode(',', $_GET['coach_id']);
      }

      $filtered_month = array();
      if (isset($_GET['month'])) {
        $filtered_month = explode(',', $_GET['month']);
      }

      $coaches = User::all()->where('authority','COACH_USER')->pluck('name','id')->sortBy("name");

      // $camp_type_id =array();
      // if(!empty($camp) && !empty($camp->camp_type_id)){
      //   $camp_type_id_data = json_decode($camp->camp_type_id);
      //   foreach ($camp_type_id_data as $key=>$camp_type) {
      //     $camp_type_id[] = CampType::find($camp_type, ['name', 'id'])->toArray();
      //   }
      // }


      return view('pages.camp.list', [
          'data'=>
          [
               'camps'      =>  $camps,
               'Title' =>  $title,
               'coaches' => $coaches
          ]
      ])
      ->with(compact('filtered_month','filtered_coach','rink_all','province_all','formatedDate','city_all','camp_type_all','level_all'));

    }
    public function coach_list(Request $request, User $user){

      $params = $request->all();
      $params['authority'] = 'COACH_USER';
      $params['is_published'] = 1;
      $query = $user->filter_coach($params);

     
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
      //$programs = $query->paginate($limit);
      $coaches = $query->get()->toArray();

      $title=trans('global.Coach List');

      $province_all = Province::all()->pluck("name", "id")->sortBy("name");
      $city_all =array();
      if (isset($params['province_id']) && !empty($params['province_id'])) {
        $city_all = Location::all()->where('province_id',$params['province_id'])->pluck('name','id')->sortBy("name");
      }
      $speciality_all = Speciality::all()->pluck("name", "id")->sortBy("name");
      $certificate_all = Certificate::all()->pluck("name", "id")->sortBy("name");
      
      $level_all = Level::all()->pluck("name", "id")->sortBy("name");
      $rink_all = Rink::all()->pluck("name", "id")->sortBy("name");
      $language_all = Language::all()->pluck("name", "id")->sortBy("name");
      $price_all = Price::all()->pluck("name", "id")->sortBy("name");
      
      
      $date = Carbon::now();
      $formatedDate = $date->format('Y-m-d');

      $filtered_rink = array();
      if (isset($_GET['rink'])) {
        $filtered_rink = explode(',', $_GET['rink']);
      }

      $filtered_language = array();
      if (isset($_GET['language'])) {
        $filtered_language = explode(',', $_GET['language']);
      }

      //$coaches = User::all()->where('authority','COACH_USER')->pluck('name','id')->sortBy("name");


      return view('pages.coach.list', [
          'data'=>
          [
               'coaches'      =>  $coaches,
               'Title' =>  $title
          ]
      ])
      ->with(compact('filtered_language','filtered_rink','rink_all','province_all','formatedDate','city_all','speciality_all','level_all','certificate_all','language_all','price_all'));

    }
    public function camp_filter(Request $request, Camp $camp){
      $params = $request->all();
      
      $current_camps = [];
      if (!isset($params['date']) || empty($params['date'])) {
          $params['current_date'] = 1;
          $dt =  now();
          $dt      = strtotime($dt);
          $dt = date('Y-m-d H:i:s', $dt);
          $sss = $camp->filter($params);
          // $sss= $camp->where('start_date', '<=', $dt)
          //               ->where('end_date', '>=', $dt);
          $current_camps = $sss->get()->toArray();
      }

      $query = $camp->filter($params);
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
      $camps_all = $query->get()->toArray();

      $backgroundColor = array(
        0=>'#A7DAE9',
        1=>'#D0E6A5',
        2=>'#D1B3DD'
      );
      $camps=[];
      foreach ($camps_all as $key => $value) {

        
        // It returns array of random keys
        //$key = array_rand( $backgroundColor);
        $value['start_date'] = strtotime($value['start_date']);
        $value['start_date'] = date( 'Y-m-d', $value['start_date']);

        $value['end_date'] = strtotime($value['end_date']);
        $value['end_date'] = date( 'Y-m-d', $value['end_date']);
        if (isset($backgroundColor[$key])) {
          $backgroundColor[$key] = $backgroundColor[$key];
        } else {
          $backgroundColor[$key] = '#A7DAE9';
        }
        $camps[]=array(
          "id"=> $value['id'],
          "title"=> $value['name'],
          "start"=> $value['start_date'],
          "end"=> $value['end_date'],
          "backgroundColor"=> $backgroundColor[$key],
          "borderColor"=> $backgroundColor[$key],
          "textColor"=> "#233C50"
        );
      }
      // echo json_encode($camps);
      // exit();


      $title=trans('global.Camp List');

      $province_all = Province::all()->pluck("name", "id")->sortBy("name");
      $city_all =array();
      if (isset($params['province_id']) && !empty($params['province_id'])) {
        $city_all = Location::all()->where('province_id',$params['province_id'])->pluck('name','id')->sortBy("name");
      }
      $camp_type_all = CampType::all()->pluck("name", "id")->sortBy("name");
      $level_all = Level::all()->pluck("name", "id")->sortBy("name");
      $rink_all = Rink::all()->pluck("name", "id")->sortBy("name");
      
      
      $date = Carbon::now();
      $formatedDate = $date->format('Y-m-d');

      $filtered_coach = array();
      if (isset($_GET['coach_id'])) {
        $filtered_coach = explode(',', $_GET['coach_id']);
      }

      $filtered_month = array();
      if (isset($_GET['month'])) {
        $filtered_month = explode(',', $_GET['month']);
      }

      $coaches = User::all()->where('authority','COACH_USER')->pluck('name','id')->sortBy("name");

      return view('pages.camp.filter', [
          'data'=>
          [
               'Title' =>  $title,
               'coaches' => $coaches
          ]
      ])
      ->with(compact('current_camps','params','camps','filtered_month','filtered_coach','rink_all','province_all','formatedDate','city_all','camp_type_all','level_all'));
    }
    public function coach_edit(Request $request){
      $user = $request->user();
      if (!$user) {
         return redirect(RouteServiceProvider::ROOT);
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
        if (isset($data['location_id']) && !empty($data['location_id'])) {
          $data['city_id'] = $data['location_id'];
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








            $shouldCrop = $request->boolean('crop', true);
            $width = $request->input('width', 150);
            $height = $request->input('height', 150);
            $new_name = $user->id . '_s_' . self::uniqueString() . '.' . $image->getClientOriginalExtension();
            //$name = time() . '_' . str_replace(' ', '-', $this->removeBs($file->getClientOriginalName()));
            $filePath = '/user_photo/' . $new_name;
            $fileContent = null;

            // echo public_path('photo');
            // exit();

            if ($shouldCrop) {
                $interventionImage = InterventionImageManager::make($image);
                //$img = Image::make('foo.jpg')->resize(300, 200);
                if (!$width && !$height) {
                    $height = $interventionImage->height();
                    $width = $interventionImage->width();
                    
                    if ($height <= $width) {
                        $width = $height;
                    } else {
                        $height = $width;
                    }
                } else {
                    if (!$width) {
                        $width = $interventionImage->width();
                    }

                    if (!$height) {
                        $height = $interventionImage->height();
                    }
                }

                $croppedImage = $interventionImage->fit($width, $height);
                
                // $store  = Storage::putFile('public/image', $croppedImage);

                // $url    = Storage::url($store);

                $croppedImageStream = $croppedImage->stream();
                
                $fileContent = $croppedImageStream->__toString();
                
            } else {
                $fileContent = file_get_contents($image);
            }
            $result = Storage::disk('public')->put($filePath, $fileContent);
            
            if (!$result) {
              return redirect()->back()->withInput()->withErrors('Image could not be uploaded');
                //throw new HttpResponseException(response()->error('Image could not be uploaded', Response::HTTP_BAD_REQUEST));
            }
            $data['avatar_image_path'] = $new_name;














            //$new_name = $user->id . '_s_' . self::uniqueString() . '.' . $image->getClientOriginalExtension();
            
            //$image->move(public_path('photo/user_photo'), $new_name);
            //$data['avatar_image_path'] = $new_name;
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

    public function rink_edit(Request $request){
      $user = $request->user();
      if (!$user) {
         return redirect(RouteServiceProvider::ROOT);
      } else {
        $title=trans('global.Edit Rink User');
      }
      if ($request->isMethod('post')) {

        $data = $request->all();
        //$user = $request->user();
        if (isset($data['is_published']) && $data['is_published'] =='on') {
          $data['is_published'] = 1;
        } else {
          $data['is_published'] = 0;
        }
        if (isset($data['location_id']) && !empty($data['location_id'])) {
          $data['city_id'] = $data['location_id'];
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
                               ->where('deleted_at',null)
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








            $shouldCrop = $request->boolean('crop', true);
            $width = $request->input('width', 150);
            $height = $request->input('height', 150);
            $new_name = $user->id . '_s_' . self::uniqueString() . '.' . $image->getClientOriginalExtension();
            //$name = time() . '_' . str_replace(' ', '-', $this->removeBs($file->getClientOriginalName()));
            $filePath = '/user_photo/' . $new_name;
            $fileContent = null;

            // echo public_path('photo');
            // exit();

            if ($shouldCrop) {
                $interventionImage = InterventionImageManager::make($image);
                //$img = Image::make('foo.jpg')->resize(300, 200);
                if (!$width && !$height) {
                    $height = $interventionImage->height();
                    $width = $interventionImage->width();
                    
                    if ($height <= $width) {
                        $width = $height;
                    } else {
                        $height = $width;
                    }
                } else {
                    if (!$width) {
                        $width = $interventionImage->width();
                    }

                    if (!$height) {
                        $height = $interventionImage->height();
                    }
                }

                $croppedImage = $interventionImage->fit($width, $height);
                
                // $store  = Storage::putFile('public/image', $croppedImage);

                // $url    = Storage::url($store);

                $croppedImageStream = $croppedImage->stream();
                
                $fileContent = $croppedImageStream->__toString();
                
            } else {
                $fileContent = file_get_contents($image);
            }
            $result = Storage::disk('public')->put($filePath, $fileContent);
            
            if (!$result) {
              return redirect()->back()->withInput()->withErrors('Image could not be uploaded');
                //throw new HttpResponseException(response()->error('Image could not be uploaded', Response::HTTP_BAD_REQUEST));
            }
            $data['avatar_image_path'] = $new_name;














            //$new_name = $user->id . '_s_' . self::uniqueString() . '.' . $image->getClientOriginalExtension();
            
            //$image->move(public_path('photo/user_photo'), $new_name);
            //$data['avatar_image_path'] = $new_name;
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
      
      return view('pages.rink.edit', [
          'data'=>
          [
               'user'      =>  $user,
               'Title' =>  $title
          ]
      ])
      ->with(compact('rink_all','experience_all','speciality_all','language_all','price_all','certificate_all','province_all','city_all'));

    }
    public function rink_list(Request $request){
      $user = $request->user();
      if (!$user) {
        return back(RouteServiceProvider::HOME);
      } else {
        $title=trans('global.Rink List');
      }
      if ($request->isMethod('post')) {
        $data = $request->all();
        if (isset($data['cookieRink'])) {
            $data['rink_id'][] = $data['cookieRink'];
        }
        if (isset($data['cookieWebURL'])) {
            $data['web_site_url'] = $data['cookieWebURL'];
        }



        $rules = array( 
            'rink_id'   => 'required',
            'web_site_url'  => 'required'
          );    
        $messages = array(
                    'rink_id.required' => trans('messages.rink_id.required'),
                    'web_site_url.required' => trans('messages.web_site_url.required')
                  );
        $validator = Validator::make( $data, $rules, $messages );

        if ( $validator->fails() ) 
        {
            
          //Toastr::warning('Error occured',$validator->errors()->all()[0]);
          return redirect()->back()->withInput()->withErrors($validator);
        }
        else
        {


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
                               ->where('deleted_at',null)
                               ->where('content_type','RINK')
                               ->first();
              if (!$userInfo) {
                $userInfo = UserInfo::firstOrCreate($insert_arr);
              } else {
                $userInfo->update($insert_arr);  
              }
            }
             
          }


          

          
          
          //$data['user_id'] = $user->id;
          
          if (!$user->update($data)) {
            return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
          } else {
            $status = "User Updated.";
            return redirect(route(RouteServiceProvider::RINKLIST))->with('status', $status);
          
          }
        }
      }


      


      $rinks = $user->userinfos['rinks'];
      $rink = '';
      foreach($rinks as $row){
          $rink =$row->content_id;
          //$rink = Rink::find($rink);
          $rink = Rink::find($row->content_id);
          //break();
      }


      if (isset($_COOKIE['cookieRink']) && !empty($rink)) {
        unset($_COOKIE['cookieRink']); 
        $cookieValue = $rink->id;
        $cookieName = 'cookieRink';

        $cookiePath = "/";
        $cookieExpire = time()+(60*60*1);//one day -> seconds*minutes*hours
        setcookie($cookieName,$cookieValue,$cookieExpire,$cookiePath);
        //echo $_COOKIE['cookieRink'];
        //print_r($_COOKIE);
      } else if (isset($_COOKIE['cookieWebURL']) && !empty($user->web_site_url)) {
        unset($_COOKIE['cookieWebURL']); 
        $cookieValue = $user->web_site_url;
        $cookieName = 'cookieWebURL';

        $cookiePath = "/";
        $cookieExpire = time()+(60*60*1);//one day -> seconds*minutes*hours
        setcookie($cookieName,$cookieValue,$cookieExpire,$cookiePath);
        //echo $_COOKIE['cookieRink'];
        //print_r($_COOKIE);
      }
      else {
        $cookieValue = '';

        $cookieName = 'cookieWebURL';
        $cookiePath = "/";
        $cookieExpire = time()+(60*60*1);//one day -> seconds*minutes*hours
        setcookie($cookieName,$cookieValue,$cookieExpire,$cookiePath);

        $cookieName = 'cookieRink';
        $cookieValue = '';
        $cookiePath = "/";
        $cookieExpire = time()+(60*60*1);//one day -> seconds*minutes*hours
        setcookie($cookieName,$cookieValue,$cookieExpire,$cookiePath);

        
        //echo $_COOKIE['cookieRink'];
        //print_r($_COOKIE);
      }



      $programs = Program::where([
                        ['user_id', $user->id],
                        ['deleted_at', null],
                    ])->get()->toArray();
      $rink_all = Rink::all()->pluck("name", "id")->sortBy("name");
      return view('pages.rink.list', [
          'data'=>
          [   
              'rink' => $rink,
              'user' =>  $user,
              'Title' =>  $title,
              'programs' => $programs
          ]
      ])
      ->with(compact('rink_all'));

    }
    public function program_list(Request $request, Program $program){

      $params = $request->all();
      //$params['period'] = 'spring';
      $query = $program->filter($params);

     
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
      //$programs = $query->paginate($limit);
      $programs = $query->get()->toArray();
      //print_r($programs);exit();

      //echo $query->toSql();exit();

      $title=trans('global.Add Program');
      
      // $programs = Program::where([
      //                   ['deleted_at', null],
      //               ])->get()->toArray();
      $province_all = Province::all()->pluck("name", "id")->sortBy("name");
      $city_all =array();
      if (isset($params['province_id']) && !empty($params['province_id'])) {
        $city_all = Location::all()->where('province_id',$params['province_id'])->pluck('name','id')->sortBy("name");
      }
      $program_type_all = ProgramType::all()->pluck("name", "id")->sortBy("name");
      $level_all = Level::all()->pluck("name", "id")->sortBy("name");
      $rink_all = Rink::all()->pluck("name", "id")->sortBy("name");
      


      $filtered_rink = array();
      if (isset($_GET['rink_id'])) {
        $filtered_rink = explode(',', $_GET['rink_id']);
      }


      $date = Carbon::now();
      $formatedDate = $date->format('Y-m-d');

      return view('pages.program.list', [
          'data'=>
          [
               'programs'      =>  $programs,
               'Title' =>  $title
          ]
      ])
      ->with(compact('filtered_rink','rink_all','province_all','formatedDate','city_all','program_type_all','level_all'));

      //return view('pages.program.list');
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
            return redirect(RouteServiceProvider::COACH_PROFILE);
          }
          elseif ($user->isRinkUser()) {
            return redirect(RouteServiceProvider::RINKLIST);
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
                  return response()->json(['success'=>true,'token'=>csrf_token(),'result'=>trans('messages.success_message'),'url'=> RouteServiceProvider::COACH_PROFILE]);
                }
                elseif ($user->isRinkUser()) {
                  return response()->json(['success'=>true,'token'=>csrf_token(),'result'=>trans('messages.success_message'),'url'=> route(RouteServiceProvider::RINKLIST)]);
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
            try {
               \Mail::to($user->email)->send(new VerifyMail($user));
               return response()->json(['success'=>true,'result'=>'We sent you an activation code. Check your email and click on the link to verify.','url'=> RouteServiceProvider::ROOT]);
            
            } catch (\Exception $e) {
              $user->email_verified_at = now();
              $user->save();
              return response()->json(['success'=>true,'result'=>'Registration successfull','url'=> RouteServiceProvider::ROOT]);
           
            }

            
            
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


    public function season($period) 
    {
        $seasons    = array(
            'SPRING'    => array('March 1'     , 'May 31'),
            'SUMMER'    => array('June 1'      , 'August 31'),
            'FALL'      => array('September 1' , 'November 30'),
            'WINTER'    => array('December 1'  , 'February 28')
        );

        $seasonsYear = array();

        $start      = strtotime($period[0]);
        $end        = strtotime($period[1]);

        $seasonsYear[date('Y', $start)] = array();

        if (key(current($seasonsYear)) != date('Y', $end))
            $seasonsYear[date('Y', $end)] = array();

        foreach ($seasonsYear as $year => &$seasonYear)
            foreach ($seasons as $season => $period)
                $seasonYear[$season] = array(strtotime($period[0].' '.$year), strtotime($period[1].' '.($season != 'winter' ? $year : ($year+1))));

        foreach ($seasonsYear as $year => &$seasons) {
            foreach ($seasons as $season => &$period) {
                if ($start >= $period[0] && $end <= $period[1])
                    return ucFirst($season);

                if ($start >= $period[0] && $start <= $period[1]) {
                    if (date('Y', $end) != $year) 
                        $seasons = $seasonsYear[date('Y', $end)];   
                        $year = date('Y', $end);

                    $nextSeason = key($seasons);
                    $nextPeriod = current($seasons);                
                    do {                    
                        $findNext   = ($end >= $nextPeriod[0] && $end <= $nextPeriod[1]);

                        $nextSeason = key($seasons);
                        $nextPeriod = current($seasons);
                    } while ($findNext = False);

                    $diffCurr   = $period[1]-$start;
                    $diffNext   = $end-$nextPeriod[0];

                    if ($diffCurr > $diffNext)
                        return ucFirst($season);
                    else {
                        return ucFirst($nextSeason);
                    }
                }
            }
        }
    }

}