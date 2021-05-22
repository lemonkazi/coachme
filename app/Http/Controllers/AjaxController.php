<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rink;
use App\Models\Speciality;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Price;
use App\Models\Language;

class AjaxController extends Controller {

   	public function post(Request $request){
      	$response = array(
          	'status' => 'success',
          	'msg' => $request->message,
      	);
      	return response()->json($response); 
   	}

   	public function delete(Request $request){
   		$param = $request;
	   	$result = array(
		    'status' => 1,
		    'message' => 'failed to delete data',
		);

		if ($param['controller'] =='coachcontroller' || $param['controller'] =='usercontroller') {
			$user = User::find($param['id']);
			if ($user->delete()) {
				$result['message'] = trans('messages.success_message');
			} else {
				$result['status'] = 0;
			}
		}

		if ($param['controller'] =='rinkcontroller') {
			$rink = Rink::find($param['id']);
			if ($rink->delete()) {
				$result['message'] = trans('messages.success_message');
			} else {
				$result['status'] = 0;
			}
		}
		if ($param['controller'] =='specialitycontroller') {
			$speciality = Speciality::find($param['id']);
			if ($speciality->delete()) {
				$result['message'] = trans('messages.success_message');
			} else {
				$result['status'] = 0;
			}
		}

		if ($param['controller'] =='experiencecontroller') {
			$experience = Experience::find($param['id']);
			if ($experience->delete()) {
				$result['message'] = trans('messages.success_message');
			} else {
				$result['status'] = 0;
			}
		}

		if ($param['controller'] =='certificatecontroller') {
			$certificate = Certificate::find($param['id']);
			if ($certificate->delete()) {
				$result['message'] = trans('messages.success_message');
			} else {
				$result['status'] = 0;
			}
		}
		if ($param['controller'] =='pricecontroller') {
			$price = Price::find($param['id']);
			if ($price->delete()) {
				$result['message'] = trans('messages.success_message');
			} else {
				$result['status'] = 0;
			}
		}

		if ($param['controller'] =='languagecontroller') {
			$language = Language::find($param['id']);
			if ($language->delete()) {
				$result['message'] = trans('messages.success_message');
			} else {
				$result['status'] = 0;
			}
		}

		
		return response()->json($result);
   }
}
