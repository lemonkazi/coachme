<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumb = array(
          array(
             'name'=>'All Coach',
             'link'=>'/coaches'
          ),
          array(
             'name'=>'Add Coach',
             'link'=>''
          )
        );
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
               //'users'      =>  $users,
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  'Add Coach'
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
      print_r($data);
      exit();

      // $validator = Validator::make($request->all(), [
      //         'name'   => 'required|min:3',
      //         'email'  => 'required|email',
      //         'phone' => 'required|min:11|max:13',
      //         'type_staff'=> 'required',
      //         'password'  => 'required|min:8',
      //         'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      //      ]);

      //   if ($validator->fails())
      //   {
      //       Toastr::warning('Error occured',$validator->errors()->all()[0]);
      //       return redirect()->back()->withInput()->withErrors($validator);
      //   }
      //   else
      //   {
      //     $user = new User;
      //     $user->name = $request->name;
      //     $user->email = $request->email;
      //     $user->access_level = User::ACCESS_LEVEL_STAFF;
      //     $user->password = bcrypt($request->password);

      //     $user->save();
      //     $staff = new Staff;
      //     $staff->user_id = $user->id;
      //     $staff->phone = $request->phone;
      //     $staff->address = $request->address;
      //     if($request->post('type_staff') == 0)
      //     {
      //        $staff->access_level = Staff::ACCESS_LEVEL_MARKET;
      //     }
      //     elseif($request->post('type_staff') == 1)
      //     {
      //        $staff->access_level = Staff::ACCESS_LEVEL_ACCOUNT;
      //     }
      //     $staff->created_by = Auth::user()->id;
      //     if($request->file('photo'))
      //     {
      //       $image = $request->file('photo');
      //       $new_name = Auth::user()->id . '_s_' . self::uniqueString() . '.' . $image->getClientOriginalExtension();
      //       $image->move(public_path('staff_photo'), $new_name);
      //        $staff->image = $new_name;
      //     }
      //      $staff->save();
      //     Toastr::success('A new Staff has been created','Success');
      //     return back();
      //  }


      $data = $request->all();
      $user = $request->user();

      if ($user->isSuperAdmin()) {
        $cityId = isset($data['city_id']) ? $data['city_id'] : null;
      } elseif ($user->isCoachUser()) {
        $cityId = $user->city_id;
      }
      if (!empty($cityId)) {
        $city = City::find($cityId);
        if (!$city) {
          throw new HttpResponseException(response()->error(trans('messages.city_id.invalid'), Response::HTTP_BAD_REQUEST));
        }
      }
      
      $city = City::create($data);
      
      // Start -----> Prakash 26-06-2020
      $insert_id = $city->id;
      $pointBase_thread_data = [
        'city_id' => $insert_id,
        'content_type' => 'THREAD',
        'point' => config('global.default_thread_point'),
        'start_date' => date('Y/m/d H:i'),
        'is_enable_multiple_time_read' => 1
      ];
      $thread_insert = PointBase::create($pointBase_thread_data);
      $pointBase_comment_data = [
        'city_id' => $insert_id,
        'content_type' => 'COMMENT',
        'point' => config('global.default_comment_point'),
        'start_date' => date('Y/m/d H:i'),
        'is_enable_multiple_time_read' => 1
      ];
      $comment_insert = PointBase::create($pointBase_comment_data);
      // End -------> Prakash 26-06-2020
      $data =array();
      $data['id'] = $city->id;
      $data['point_bases_id_for_thread'] = $thread_insert->id;
      $data['point_bases_id_for_comment'] = $comment_insert->id;
      $city->update($data);
      if (!$city) {
        throw new HttpResponseException(response()->error(trans('messages.error_message'), Response::HTTP_BAD_REQUEST));
      }
      return redirect ('coach/add');
      //return response()->success($city, trans('messages.success_message'), Response::HTTP_CREATED);      
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(CoachUpdateRequest $request, $id)
    {
      $data = $request->all();
      $user = $request->user();

      if ($user->isServiceAdmin() && isset($data['city_id'])) {
        $building = City::find($data['city_id']);
        if (!$building) {
          throw new HttpResponseException(response()->error(trans('messages.city_id.invalid'), Response::HTTP_BAD_REQUEST));
        }
      } elseif ($user->isCityAdmin()) {
        if ((isset($data['city_id'])) && ($user->city_id !== $data['city_id'])) {
          throw new HttpResponseException(response()->error(trans('messages.city_id.invalid'), Response::HTTP_BAD_REQUEST));
        }
      }
      
      $city->update($request->all());
       
     
      return response()->success($city, trans('messages.success_message'), Response::HTTP_OK);
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
}
