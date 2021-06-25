<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rink;
use App\Models\Speciality;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Price;
use App\Models\Camp;
use App\Models\Language;
use App\Models\Location;
use Illuminate\Http\Response;
use Cookie;

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

   	public function citylist(Request $request){
   		$data = $request->all();

   		$response = '';
   		$response .= '<select name="city_id" id ="city_id" class="form-control" style="width: 100%">';
    	$response .= '<option value="">Select</option>';
    	$city_all = Location::where('province_id',$data['province_id'])->pluck('name','id')->sortBy("name");
    	
      	foreach($city_all as $id => $value) {
        	$response .= '<option value="' . $id  . '">' . $value  . '</option>';
      	}
      	$response .= '</select>';
   		echo $response; exit;
   	}



   	public function set_Cookie(Request $request){
   		$data = $request->all();
   		
   		//cookieWebURL
   		//cookieRink
   		if (isset($_COOKIE[$data['cookieName']])) {
		    unset($_COOKIE[$data['cookieName']]); 
		    $cookieValue = $data['value'];
		    $cookieName = $data['cookieName'];

		    $cookiePath = "/";
			$cookieExpire = time()+(60*60*1);//one day -> seconds*minutes*hours
			setcookie($cookieName,$cookieValue,$cookieExpire,$cookiePath);
		    //echo $_COOKIE['cookieRink'];
		    //print_r($_COOKIE);
		} else {
		    $cookieValue = $data['value'];
		    $cookieName = $data['cookieName'];

		    $cookiePath = "/";
			$cookieExpire = time()+(60*60*1);//one day -> seconds*minutes*hours
			setcookie($cookieName,$cookieValue,$cookieExpire,$cookiePath);
		    //echo $_COOKIE['cookieRink'];
		    //print_r($_COOKIE);
		}
		echo $cookieValue;
		exit();
   	}



   	public function get_camp(Request $request){
   		$camp = new Camp();
   		$data = $request->all();
   		
   		if (!empty($data['params'])) {
   			$params = json_decode($data['params'],true);
   		} else {
   			$params =[];
   		}
   		$params['date'] = $data['date'];

   		$response = '';

   		$query = $camp->filter($params);
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
		$camps_all = $query->get()->toArray();
      	$backgroundColor = array(
	        0=>'#A7DAE9',
	        1=>'#D0E6A5',
	        2=>'#D1B3DD'
      	);
      	$camps=[];
      	foreach ($camps_all as $key => $value) {

        
	        // It returns array of random keys
	        //$key = array_rand( $backgroundColor);
	        $value['start_date'] = strtotime($value['start_date']);
	        $value['start_date'] = date( 'M d', $value['start_date']);

	        $value['end_date'] = strtotime($value['end_date']);
	        $value['end_date'] = date( 'M d', $value['end_date']);

	        if (isset($backgroundColor[$key])) {
	          $backgroundColor[$key] = $backgroundColor[$key];
	        } else {
	          $backgroundColor[$key] = '#A7DAE9';
	        }

	        $response .= '<div class="event" style="background-color:'.$backgroundColor[$key].'">';
     			$response .= '<h4>'.$value['name'].'</h4>';
 				$response .= '<p>'.$value['start_date'].' - '.$value['end_date'].'</p>';
 			$response .= '</div>';
      	}
   		echo $response; exit;
   	}

   
}
