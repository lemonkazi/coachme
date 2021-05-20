<?php

use Illuminate\Support\Facades\Route;
// landing page
Route::get('/', function () {
    return view('welcome');
});

Route::get('ajax', function(){ return view('ajax'); });

Route::post('/ajax_delete','AjaxController@delete');


Auth::routes();

// auth
Route::group(['middleware' => ['auth']], function () {
	Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout']);

});
Route::middleware(['auth', 'authority:super_admin'])->group(function () {
	
	Route::get('coaches',[App\Http\Controllers\Admin\CoachController::class, 'show']);
	Route::get('coaches/{user}',[App\Http\Controllers\Admin\CoachController::class, 'show']);
	
	Route::group(['prefix' =>'coach', 'as'=>'coach.'], function(){

	    Route::get('add',[App\Http\Controllers\Admin\CoachController::class, 'create']);
	    Route::post('store',['as' =>'store','uses' =>'Admin\CoachController@store' ]);
	    //Route::post('delete',['as' =>'delete','uses' =>'ManagerController@delete' ]);
	    Route::get('edit/{id}',[App\Http\Controllers\Admin\CoachController::class, 'create']);
	    Route::post('update/{id}',['as' =>'update','uses' =>'Admin\CoachController@update']);
  	});


	//rinks route
  	Route::get('rinks',[App\Http\Controllers\Admin\RinkController::class, 'show']);
	Route::get('rinks/{rink}',[App\Http\Controllers\Admin\RinkController::class, 'show']);
	
	Route::group(['prefix' =>'rink', 'as'=>'rink.'], function(){

	    Route::get('add',[App\Http\Controllers\Admin\RinkController::class, 'create']);
	    Route::post('store',['as' =>'store','uses' =>'Admin\RinkController@store' ]);
	    //Route::post('delete',['as' =>'delete','uses' =>'ManagerController@delete' ]);
	    Route::get('edit/{id}',[App\Http\Controllers\Admin\RinkController::class, 'create']);
	    Route::post('update/{id}',['as' =>'update','uses' =>'Admin\RinkController@update']);
  	});


	//speciality route
  	Route::get('speciality',[App\Http\Controllers\Admin\SpecialityController::class, 'show']);
	Route::get('speciality/{speciality}',[App\Http\Controllers\Admin\SpecialityController::class, 'show']);
	
  	Route::group(['prefix' =>'special', 'as'=>'special.'], function(){

	    Route::get('add',[App\Http\Controllers\Admin\SpecialityController::class, 'create']);
	    Route::post('store',['as' =>'store','uses' =>'Admin\SpecialityController@store' ]);
	    //Route::post('delete',['as' =>'delete','uses' =>'ManagerController@delete' ]);
	    Route::get('edit/{id}',[App\Http\Controllers\Admin\SpecialityController::class, 'create']);
	    Route::post('update/{id}',['as' =>'update','uses' =>'Admin\SpecialityController@update']);
  	});


  	//experience route
  	Route::get('experiences',[App\Http\Controllers\Admin\ExperienceController::class, 'show']);
	Route::get('experiences/{experience}',[App\Http\Controllers\Admin\ExperienceController::class, 'show']);
	
	Route::group(['prefix' =>'experience', 'as'=>'experience.'], function(){

	    Route::get('add',[App\Http\Controllers\Admin\ExperienceController::class, 'create']);
	    Route::post('store',['as' =>'store','uses' =>'Admin\ExperienceController@store' ]);
	    //Route::post('delete',['as' =>'delete','uses' =>'ManagerController@delete' ]);
	    Route::get('edit/{id}',[App\Http\Controllers\Admin\ExperienceController::class, 'create']);
	    Route::post('update/{id}',['as' =>'update','uses' =>'Admin\ExperienceController@update']);
  	});


  	//certificate route
  	Route::get('certificates',[App\Http\Controllers\Admin\CertificateController::class, 'show']);
	Route::get('certificates/{certificate}',[App\Http\Controllers\Admin\CertificateController::class, 'show']);
	
	Route::group(['prefix' =>'certificate', 'as'=>'certificate.'], function(){

	    Route::get('add',[App\Http\Controllers\Admin\CertificateController::class, 'create']);
	    Route::post('store',['as' =>'store','uses' =>'Admin\CertificateController@store' ]);
	    //Route::post('delete',['as' =>'delete','uses' =>'ManagerController@delete' ]);
	    Route::get('edit/{id}',[App\Http\Controllers\Admin\CertificateController::class, 'create']);
	    Route::post('update/{id}',['as' =>'update','uses' =>'Admin\CertificateController@update']);
  	});
});


Route::get('/create_product', function(){
    return view('admin.create_product');
})->middleware('auth');

Route::get('/product_delete/{id}',[App\Http\Controllers\ProductsController::class, 'destroy'])->middleware('auth');

Route::get('/product_create',[App\Http\Controllers\ProductsController::class, 'create'])->middleware('auth');

Route::post('/product_submit',[App\Http\Controllers\ProductsController::class, 'store'])->middleware('auth');

Route::get('/edit-categories', function(){
    return view('admin.edit-categories');
})->middleware('auth');


//categories

Route::get('/categories',[App\Http\Controllers\CategoryController::class, 'manageCategory'])->middleware('auth');

Route::get('/category_delete/{id}',[App\Http\Controllers\CategoryController::class, 'destroy'])->middleware('auth');

Route::post('/category_submit',[App\Http\Controllers\CategoryController::class, 'store'])->middleware('auth');

Route::get('/add_categories', function(){
    return view('admin.add_categories');
})->middleware('auth');

//sub_catergories

Route::get('/sub_categories',[App\Http\Controllers\SubCategoryController::class, 'allSubCategory'])->middleware('auth');

Route::get('/add_Sub_Categories',[App\Http\Controllers\SubCategoryController::class, 'showCategory'])->middleware('auth');


Route::get('/sub_category_delete/{id}',[App\Http\Controllers\SubCategoryController::class, 'destroy'])->middleware('auth');


Route::post('/subCategory_submit',[App\Http\Controllers\SubCategoryController::class, 'store'])->middleware('auth');
