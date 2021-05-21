<?php

use Illuminate\Support\Facades\Route;
// landing page
// Route::get('/', function () {
//     return view('welcome');
// });
//Route::get('/', 'PublicContoller@index');
Route::get('ajax', function(){ return view('ajax'); });

Route::post('/ajax_delete','AjaxController@delete');

Route::get('/', 'PublicContoller@index');


/**Forgot Password Routes**/
Route::get('password/request', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'index'])->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLink')->name('password.email');
/**Reset Password Routes**/
//Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
//Route::post('password/reset/{reset_token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'updatePassword'])->name('password.update');


Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
Auth::routes();



// auth
Route::group(['middleware' => ['auth']], function () {
	//
	
	Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout']);

});
Route::middleware(['auth', 'authority:super_admin'])->group(function () {
	Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
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
});



