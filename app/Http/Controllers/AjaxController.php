<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

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

		if ($param['controller'] =='coachcontroller') {
			$user = User::find($param['id']);
		}

		if ($user->delete()) {
			$result['message'] = trans('messages.success_message');
		} else {
			$result['status'] = 0;
		}
		return response()->json($result);
   }
}
