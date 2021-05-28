<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Testimonial;

use App\Exports\CollectionExport;
use Maatwebsite\Excel\Facades\Excel;

class TestimonialController extends Controller
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
  public function index(Request $request, Testimonial $testimonial)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Testimonial  $testimonials
   * @param  \Illuminate\Http\Request  $request
   */
  public function show(Request $request, Testimonial $testimonial)
  {
    $params = $request->all();
    
    if (!empty($testimonial->id)) {
      $breadcrumb = array(
        array(
           'name'=>trans('global.All Testimonials'),
           'link'=>'/testimonials'
        ),
        array(
           'name'=>trans('global.Testimonial Detail'),
           'link'=>''
        )
      );
      return view('admin.testimonial.detail', [
        'pageInfo'=>
         [
          'siteTitle'        =>'Manage Users',
          'pageHeading'      =>'Manage Users',
          'pageHeadingSlogan'=>'Here the section to manage all registered users'
          ]
          ,
          'data'=>
          [
             'testimonial' => Testimonial::find($testimonial->id),
             'breadcrumb' =>  $breadcrumb,
             'Title' =>  trans('global.Testimonial Detail')
          ]
        ]);
    }
    $query = $testimonial->filter($params);

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
           'name'=>trans('global.All Testimonials'),
           'link'=>'/testimonials'
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
      return view('admin.testimonial.list', [
          'pageInfo'=>
           [
            'siteTitle'        =>'Manage Users',
            'pageHeading'      =>'Manage Users',
            'pageHeadingSlogan'=>'Here the section to manage all registered users'
            ]
            ,
            'data'=>
            [
               'testimonials'      =>  $response->appends(request()->except('page')),
               'breadcrumb' =>  $breadcrumb,
               'Title' =>  trans('global.Testimonial List'),
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
    $testimonial='';
    $title='Add Testimonial';
    $breadcrumb = array(
        array(
           'name'=>trans('global.All Testimonial'),
           'link'=>'/testimonials'
        )
      );
    if (!empty($id)) {
      $testimonial = Testimonial::find($id);
      if (!$testimonial) {
        return back();
      } else {
        $breadcrumb[] = array(
           'name'=>trans('global.Edit Testimonial'),
           'link'=>''
        );
        $title=trans('global.Edit Testimonial');
      }
    } else {
      $breadcrumb[] = array(
           'name'=>trans('global.Add Testimonial'),
           'link'=>''
      );
    }
   
    return view('admin.testimonial.add', [
      'pageInfo'=>
      [
        'siteTitle'        =>'Manage Users',
        'pageHeading'      =>'Manage Users',
        'pageHeadingSlogan'=>'Here the section to manage all registered users'
      ],
      'data'=>
      [
           'testimonial'      =>  $testimonial,
           'breadcrumb' =>  $breadcrumb,
           'Title' =>  $title
      ]
    ]);
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
      $testimonial = Testimonial::create($data);  
      if (!$testimonial) {
        return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
      }

      if($request->file('image_path'))
      {
        $image = $request->file('image_path');
        $new_name = $testimonial->id . '_s_' . self::uniqueString() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('testimonial_photo'), $new_name);
        $testimonial->image_path = $new_name;
      }
      if (!$testimonial->save()) {
        
        return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
      }
      Toastr::success(trans('global.A new Testimonial has been created'),'Success');
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
    $testimonial = Testimonial::find($id);
    if (!$testimonial) {
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

      if (!$testimonial->update($data)) {
        return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
      }

      Toastr::success(trans('global.Testimonial has been updated'),'Success');
      return back();
    }
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\City  $city
   * @return \Illuminate\Http\Response
   */
  public function destroy(Testimonial $testimonial)
  {
    $testimonial->delete();
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
