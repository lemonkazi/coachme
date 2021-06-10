<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Province;
use App\Models\City;

use App\Exports\CollectionExport;
use Maatwebsite\Excel\Facades\Excel;

class CityController extends Controller
{
    

  public function __construct()
  {
      parent::__construct();
  }
  
  /**
   * Display a listing of the resource.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function index(Request $request, City $city)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\City  $citys
   * @param  \Illuminate\Http\Request  $request
   */
  public function show(Request $request, City $city)
  {
    $params = $request->all();
    
    if (!empty($city->id)) {
      $breadcrumb = array(
        array(
           'name'=>trans('global.All Citys'),
           'link'=>'/city'
        ),
        array(
           'name'=>trans('global.City Detail'),
           'link'=>''
        )
      );
      return view('admin.city.detail', [
        'pageInfo'=>
         [
          'siteTitle'        =>'Manage Users',
          'pageHeading'      =>'Manage Users',
          'pageHeadingSlogan'=>'Here the section to manage all registered users'
          ]
          ,
          'data'=>
          [
             'city' => City::find($city->id),
             'breadcrumb' =>  $breadcrumb,
             'Title' =>  trans('global.City Detail')
          ]
        ]);
    }
    $query = $city->filter($params);

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
           'name'=>trans('global.All Citys'),
           'link'=>'/city'
        )
    );
    // If export parameter true, it will return csv file
    if ($export) { 
      // It maps model property (key) to column header (value)
      $headPropertyMapper = [
          'id' => 'ID', 
          'name' => 'Name',
          'created_at' => 'Created At',
          'updated_at' => 'Updated At',
      ];

      $data = $user->dataProcessor($headPropertyMapper, $response);
      $headings = array_values($headPropertyMapper);
      
      // Create CollectionExport instance by passing file headers and data
      $collectionExportInstance = new CollectionExport($headings, $data);
      $fileName = date('Ymd_His').'_certificates.csv';

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
      return view('admin.city.list', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'city'      =>  $response->appends(request()->except('page')),
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  trans('global.City List'),
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
   * @return \Illuminate\Http\Response
   */
  public function create($id=null)
  {
    $city='';
    $title='Add City';
    $breadcrumb = array(
        array(
           'name'=>trans('global.All City'),
           'link'=>'/city'
        )
      );
    if (!empty($id)) {
      $city = City::find($id);
      if (!$city) {
        return back();
      } else {
        $breadcrumb[] = array(
           'name'=>trans('global.Edit City'),
           'link'=>''
        );
        $title=trans('global.Edit City');
      }
    } else {
      $breadcrumb[] = array(
           'name'=>trans('global.Add City'),
           'link'=>''
      );
    }
    $province_all = Province::all()->pluck("name", "id")->sortBy("name");
   
    return view('admin.city.add', [
      'pageInfo'=>
      [
        'siteTitle'        =>'Manage Users',
        'pageHeading'      =>'Manage Users',
        'pageHeadingSlogan'=>'Here the section to manage all registered users'
      ],
      'data'=>
      [
           'city'      =>  $city,
           'breadcrumb' =>  $breadcrumb,
           'Title' =>  $title
      ]
    ])
    ->with(compact('province_all'));

  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
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
        
      if (!City::create($data)) {
        return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
      }
      Toastr::success(trans('global.A new City has been created'),'Success');
      return back();
    }


  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function update(Request $request, $id=null)
  {

    $data = $request->all();
    $Authuser = $request->user();
    $city = City::find($id);
    if (!$city) {
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

      if (!$city->update($data)) {
        return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
      }

      Toastr::success(trans('global.City has been updated'),'Success');
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

}
