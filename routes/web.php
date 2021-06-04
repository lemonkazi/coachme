<?php

use Illuminate\Support\Facades\Route;
// landing page
Route::get('/', 'PublicContoller@index');
Route::get('/camp/edit', 'PublicContoller@camp_edit');
Route::get('/program/edit', 'PublicContoller@program_edit');
Route::get('/program/details', 'PublicContoller@program_details');
Route::get('/camp/details', 'PublicContoller@camp_details');
Route::get('/coach/details', 'PublicContoller@coach_details');


Route::get('ajax', function(){ return view('ajax'); });


Route::post('ajax_citylist','AjaxController@citylist');

Route::get('/user/login', 'PublicContoller@login');
//Route::get('login', [Auth\LoginController::class, 'index'])->name('login');
Route::post('/user/login', 'PublicContoller@publiclogin');
Route::post('/user/register', 'PublicContoller@publicRegister');

Auth::routes(['verify' => true]);



/**Forgot Password Routes**/
Route::get('password/request', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'index'])->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLink')->name('password.email');
/**Reset Password Routes**/
//Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
//Route::post('password/reset/{reset_token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'updatePassword'])->name('password.update');


Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');


Route::get('/user/verify/{token}', 'PublicContoller@verifyUser');

Auth::routes();



// auth
Route::group(['middleware' => ['auth']], function () {
	Route::get('camp/update/{camp}', 'PublicContoller@camp_edit');
	Route::post('camp/update/{camp}',['as' =>'camp-update','uses' =>'PublicContoller@camp_edit']);
	Route::get('camp/create', 'PublicContoller@camp_add');
	Route::post('camp/create',['as' =>'camp-create','uses' =>'PublicContoller@camp_add']);
	
	Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout']);
	Route::post('/ajax_delete','AjaxController@delete');
});
Route::middleware(['auth', 'authority:coach_user'])->group(function () {
	Route::get('my-account', 'PublicContoller@coach_edit');
	Route::post('my-account',['as' =>'profile-update','uses' =>'PublicContoller@coach_edit']);
});
Route::middleware(['auth', 'authority:super_admin'])->group(function () {
	Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	
	Route::get('admin/profile', 'Admin\ProfileController@userDetail');
	Route::get('admin/profile-update', 'Admin\ProfileController@profileUpdate');
	Route::post('admin/profile-update', ['as' =>'admin.profile.update','uses' =>'Admin\ProfileController@profileUpdate' ]);
	
	Route::post('admin/profile/update-password', ['as' =>'admin.profile.changepassword','uses' =>'Admin\ProfileController@updatePassword']);
	Route::get('admin/profile/update-password', 'Admin\ProfileController@updatePassword');

	//rinks route
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
	Route::get('users',[App\Http\Controllers\Admin\UserController::class, 'show']);
	Route::get('users/{user}',[App\Http\Controllers\Admin\UserController::class, 'show']);
	
	Route::group(['prefix' =>'user', 'as'=>'user.'], function(){

	    Route::get('add',[App\Http\Controllers\Admin\UserController::class, 'create']);
	    Route::post('store',['as' =>'store','uses' =>'Admin\UserController@store' ]);
	    //Route::post('delete',['as' =>'delete','uses' =>'ManagerController@delete' ]);
	    Route::get('edit/{id}',[App\Http\Controllers\Admin\UserController::class, 'create']);
	    Route::post('update/{id}',['as' =>'update','uses' =>'Admin\UserController@update']);
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
  	//price route
  	Route::get('prices',[App\Http\Controllers\Admin\PriceController::class, 'show']);
	Route::get('prices/{price}',[App\Http\Controllers\Admin\PriceController::class, 'show']);
	
	Route::group(['prefix' =>'price', 'as'=>'price.'], function(){

	    Route::get('add',[App\Http\Controllers\Admin\PriceController::class, 'create']);
	    Route::post('store',['as' =>'store','uses' =>'Admin\PriceController@store' ]);
	    //Route::post('delete',['as' =>'delete','uses' =>'ManagerController@delete' ]);
	    Route::get('edit/{id}',[App\Http\Controllers\Admin\PriceController::class, 'create']);
	    Route::post('update/{id}',['as' =>'update','uses' =>'Admin\PriceController@update']);
  	});


  	//language route
  	Route::get('languages',[App\Http\Controllers\Admin\LanguageController::class, 'show']);
	Route::get('languages/{language}',[App\Http\Controllers\Admin\LanguageController::class, 'show']);
	
	Route::group(['prefix' =>'language', 'as'=>'language.'], function(){

	    Route::get('add',[App\Http\Controllers\Admin\LanguageController::class, 'create']);
	    Route::post('store',['as' =>'store','uses' =>'Admin\LanguageController@store' ]);
	    //Route::post('delete',['as' =>'delete','uses' =>'ManagerController@delete' ]);
	    Route::get('edit/{id}',[App\Http\Controllers\Admin\LanguageController::class, 'create']);
	    Route::post('update/{id}',['as' =>'update','uses' =>'Admin\LanguageController@update']);
  	});


  	//province route
  	Route::get('provinces',[App\Http\Controllers\Admin\ProvinceController::class, 'show']);
	Route::get('provinces/{province}',[App\Http\Controllers\Admin\ProvinceController::class, 'show']);
	
	Route::group(['prefix' =>'province', 'as'=>'province.'], function(){

	    Route::get('add',[App\Http\Controllers\Admin\ProvinceController::class, 'create']);
	    Route::post('store',['as' =>'store','uses' =>'Admin\ProvinceController@store' ]);
	    //Route::post('delete',['as' =>'delete','uses' =>'ManagerController@delete' ]);
	    Route::get('edit/{id}',[App\Http\Controllers\Admin\ProvinceController::class, 'create']);
	    Route::post('update/{id}',['as' =>'update','uses' =>'Admin\ProvinceController@update']);
  	});

  	//location route
  	Route::get('locations',[App\Http\Controllers\Admin\LocationController::class, 'show']);
	Route::get('locations/{location}',[App\Http\Controllers\Admin\LocationController::class, 'show']);
	
	Route::group(['prefix' =>'location', 'as'=>'location.'], function(){

	    Route::get('add',[App\Http\Controllers\Admin\LocationController::class, 'create']);
	    Route::post('store',['as' =>'store','uses' =>'Admin\LocationController@store' ]);
	    //Route::post('delete',['as' =>'delete','uses' =>'ManagerController@delete' ]);
	    Route::get('edit/{id}',[App\Http\Controllers\Admin\LocationController::class, 'create']);
	    Route::post('update/{id}',['as' =>'update','uses' =>'Admin\LocationController@update']);
  	});


  	//testimonial route
  	Route::get('testimonials',[App\Http\Controllers\Admin\TestimonialController::class, 'show']);
	Route::get('testimonials/{testimonial}',[App\Http\Controllers\Admin\TestimonialController::class, 'show']);
	
	Route::group(['prefix' =>'testimonial', 'as'=>'testimonial.'], function(){

	    Route::get('add',[App\Http\Controllers\Admin\TestimonialController::class, 'create']);
	    Route::post('store',['as' =>'store','uses' =>'Admin\TestimonialController@store' ]);
	    //Route::post('delete',['as' =>'delete','uses' =>'ManagerController@delete' ]);
	    Route::get('edit/{id}',[App\Http\Controllers\Admin\TestimonialController::class, 'create']);
	    Route::post('update/{id}',['as' =>'update','uses' =>'Admin\TestimonialController@update']);
  	});
});





