<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rink;
use App\Models\Province;
use App\Models\Location;
use App\Exports\CollectionExport;
use Maatwebsite\Excel\Facades\Excel;

class RinkController extends Controller
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
  public function index(Request $request, Rink $rink)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Rink  $rink
   */
  public function show(Request $request, Rink $rink)
  {
    $params = $request->all();
    
    if (!empty($rink->id)) {
      $breadcrumb = array(
        array(
           'name'=>trans('global.All Rinks'),
           'link'=>'/rinks'
        ),
        array(
           'name'=>trans('global.Rink Detail'),
           'link'=>''
        )
      );
      return view('admin.rink.detail', [
        'pageInfo'=>
         [
          'siteTitle'        =>'Manage Users',
          'pageHeading'      =>'Manage Users',
          'pageHeadingSlogan'=>'Here the section to manage all registered users'
          ]
          ,
          'data'=>
          [
             'rink' => Rink::find($rink->id),
             'breadcrumb' =>  $breadcrumb,
             'Title' =>  trans('global.Rink Detail')
          ]
        ]);
    } 
    $query = $rink->filter($params);

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
           'name'=>trans('global.All Rinks'),
           'link'=>'/rinks'
        )
    );

    // If export parameter true, it will return csv file
    if ($export) { 
      // It maps model property (key) to column header (value)
      $headPropertyMapper = [
          'id' => 'ID', 
          'name' => 'Name',
          'address' => 'Address',
          'created_at' => 'Created At',
          'updated_at' => 'Updated At',
      ];

      $data = $rink->dataProcessor($headPropertyMapper, $response);
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

      return view('admin.rink.list', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
              'rinks'      =>  $response->appends(request()->except('page')),
              'breadcrumb' =>  $breadcrumb,
              'Title' =>  trans('global.Rink List'),
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
   */
  public function create($id=null)
  {
    $rink='';
    $title=trans('global.Add Rink');
    $breadcrumb = array(
        array(
           'name'=>trans('global.All Rink'),
           'link'=>'/rinks'
        )
      );
    if (!empty($id)) {
      $rink = Rink::find($id);
      if (!$rink) {
        return back();
      } else {
        $breadcrumb[] = array(
           'name'=>trans('global.Edit Rink'),
           'link'=>''
        );
        $title=trans('global.Edit Rink');
      }
    } else {
      $breadcrumb[] = array(
           'name'=>trans('global.Add Rink'),
           'link'=>''
      );
    }

    $city_all = Location::all()->pluck("name", "id")->sortBy("name");
    $province_all = Province::all()->pluck("name", "id")->sortBy("name");

   
   return view('admin.rink.add', [
          'pageInfo'=>
          [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
          ],
          'data'=>
          [
               'rink'      =>  $rink,
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  $title
          ]
      ])
      ->with(compact('province_all','city_all'));

  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(Request $request)
  {
    $data = $request->all();
    if (isset($data['city_id']) && !empty($data['city_id'])) {
      $data['location_id'] = $data['city_id'];
    }
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
        
      if (!Rink::create($data)) {
        return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
      }
      Toastr::success(trans('global.A new Rink has been created'),'Success');
      return back();
    }


  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Rink  $id
   */
  public function update(Request $request, $id=null)
  {

    $data = $request->all();
    if (isset($data['city_id']) && !empty($data['city_id'])) {
      $data['location_id'] = $data['city_id'];
    }
    $Authuser = $request->user();
    $rink = Rink::find($id);
    if (!$rink) {
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

      if (!$rink->update($data)) {
        return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
      }

      Toastr::success(trans('global.Rink has been updated'),'Success');
      return back();
    }
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\City  $city
   * @return \Illuminate\Http\Response
   */
  public function destroy(Rink $rink)
  {
    $rink->delete();
    return response()->success(false, trans('messages.success_message'), Response::HTTP_OK);
  }

}
