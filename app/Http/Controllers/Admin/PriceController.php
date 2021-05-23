<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Price;

class PriceController extends Controller
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
  public function index(Request $request, Price $price)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Price  $price
   * @param  \Illuminate\Http\Request  $request
   */
  public function show(Request $request, Price $price)
  {
    $params = $request->all();
    
    if (!empty($price->id)) {
      $breadcrumb = array(
        array(
           'name'=>trans('global.All Prices'),
           'link'=>'/prices'
        ),
        array(
           'name'=>trans('global.Price Detail'),
           'link'=>''
        )
      );
      return view('admin.price.detail', [
        'pageInfo'=>
         [
          'siteTitle'        =>'Manage Users',
          'pageHeading'      =>'Manage Users',
          'pageHeadingSlogan'=>'Here the section to manage all registered users'
          ]
          ,
          'data'=>
          [
             'price' => Price::find($price->id),
             'breadcrumb' =>  $breadcrumb,
             'Title' =>  trans('global.Price Detail')
          ]
        ]);
    } else {
      $queryPrice = Price::query();
      $prices = $queryPrice->paginate(20);
    }

    $breadcrumb = array(
      array(
         'name'=>trans('global.All Prices'),
         'link'=>'/prices'
      )
    );

    return view('admin.price.list', [
      'pageInfo'=>
       [
        'siteTitle'        =>'Manage Users',
        'pageHeading'      =>'Manage Users',
        'pageHeadingSlogan'=>'Here the section to manage all registered users'
        ]
        ,
        'data'=>
        [
           'prices'      =>  $prices,
           'breadcrumb' =>  $breadcrumb,
           'Title' =>  trans('global.Price List')
        ]
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   */
  public function create()
  {
    $price='';
    $title=trans('global.Add Price');
    $breadcrumb = array(
        array(
           'name'=>trans('global.All Price'),
           'link'=>'/prices'
        )
      );
    if (!empty($id)) {
      $price = Price::find($id);
      if (!$price) {
        return back();
      } else {
        $breadcrumb[] = array(
           'name'=>trans('global.Edit Price'),
           'link'=>''
        );
        $title=trans('global.Edit Price');
      }
    } else {
      $breadcrumb[] = array(
        'name'=>trans('global.Add Price'),
        'link'=>''
      );
    }
   
    return view('admin.price.add', [
      'pageInfo'=>
      [
        'siteTitle'        =>'Manage Users',
        'pageHeading'      =>'Manage Users',
        'pageHeadingSlogan'=>'Here the section to manage all registered users'
      ],
      'data'=>
      [
           'price'      =>  $price,
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
      if (!Price::create($data)) {
        return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
      }
      Toastr::success(trans('global.A new Price has been created'),'Success');
      return back();
    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Price  $id
   */
  public function update(Request $request, $id=null)
  {

    $data = $request->all();
    $Authuser = $request->user();
    $price = Price::find($id);
    if (!$price) {
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

      if (!$price->update($data)) {
        return redirect()->back()->withInput()->withErrors(trans('messages.error_message'));
      }

      Toastr::success(trans('global.Price has been updated'),'Success');
      return back();
    }
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\City  $city
   * @return \Illuminate\Http\Response
   */
  public function destroy(Price $price)
  {
    $price->delete();
    return response()->success(false, trans('messages.success_message'), Response::HTTP_OK);
  }

}
