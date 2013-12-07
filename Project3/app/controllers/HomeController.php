<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}
	
	public function getLogin()
	{
		return View::make('login');
		
	}
	
	public function getRegister()
	{
		return View::make('register');
	}
	
	public function postLogin()
	{
		$query = "select password from users where username = " . "'" . Input::get('username') . "'";
		$password =  DB::table('users')->where('password', Input::get('password'))->pluck('password');
		
		//Keep as a reference to what the actual SQL query is
		//$query = "select id from users where username = " . "'" . Input::get('username') . "'";
		
		$id= DB::table('users')->where('username', Input::get('username'))->pluck('id');
		
		//Set auth field to true so we know user is authenticated
		DB::table('users')->where('id', $id)->update(array('auth' => 1));
		
		$input = Input::all();
		$rules = array('username' => 'required', 'password' => 'required');
		$validator = Validator::make($input, $rules);

		if($validator->fails())
		{
			return Redirect::to('/')->withErrors($validator);
		}
		
		if($password == Input::get('password'))
		{
			$url = 'homepage/' . $id;
			return Redirect::to($url);
		}
		else
		{
			return Redirect::to('/');
		}
	}
	
	public function postRegister()
	{
		//Gather post data
		$input = Input::all();

		//Tells laravel the rules for validating this data
		$rules = array('username' => 'required|unique:users', 'password' => 'required', 'email' => 'required');

		$validator = Validator::make($input, $rules);

		if($validator->fails())
		{
			return Redirect::to('register')->withErrors($validator);
		}
		
		$user = new User();
		$user->username = Input::get('username');
		$user->password = Input::get('password');
		$user->email = Input::get('email');
		$user->isAdmin = (Input::get('isAdmin')) ? 1 : 0;
		
		
		$user->save();
		
		return Redirect::to('/');
	}
	
	public function getHomepage($id)
	{
		return View::make('homepage')->with('id', $id);
	}
	
	public function getLogout($id)
	{
		//Set auth field to true so we know user is DE-authenticated
		DB::table('users')->where('id', $id)->update(array('auth' => 0));
		return Redirect::to('/');
	}
	
	public function getSearchflights($id)
	{
		return View::make('searchflights')->with('id', $id);
	}
	
	
	public function postSearchflights($id)
	{
		//Check to see if searched by date range
		if(Input::has('date1'))
		{
			$departCode = Input::get('dep_code2');
			$destCode = Input::get('dest_code2');
			//Parse day field
			$day = substr(Input::get('date1'), 3, 2);
			$month = substr(Input::get('date1'), 0, 2);
			$year = substr(Input::get('date1'), 6, 4);
			
			$day2m = $day - 2;
			$day2p = $day + 2;
			$day1m = $day - 1;
			$day1p = $day + 1;		
			
			//Create new dates within + and - 2 days of the original
			$date2m = $month . '/' . $day2m . '/' . $year;
			$date2p = $month . '/' . $day2p . '/' . $year;
			$date1m = $month . '/' . $day1m . '/' . $year;
			$date1p = $month . '/' . $day1p . '/' . $year;
			$date = $month . '/' . $day . '/' . $year;
			$dateAr = array($date2m, $date2p, $date1m, $date1p,$date);
			
			$flights = DB::table('trip')
                     ->select(DB::raw('*'))
                     ->where('depCode', '=', $departCode)
                     ->where('destCode', '=', $destCode)
                     ->whereIn('departDate',$dateAr)->get();
			return View::make('searchresults')->with('id', $id)->with('flights', $flights);
		}
		else
		{
			//Normal search
			$departDate = Input::get('dep_date');
			$departTime = Input::get('dep_time');
			$departTime = str_replace(':', '_', $departTime);
			$departCode = Input::get('dep_code');
			$destCode = Input::get('dest_code');
			
			$flights = DB::table('trip')
                     ->select(DB::raw('*'))
                     ->where('depCode', '=', $departCode)
                     ->where('destCode', '=', $destCode)
                     ->where('departDate', '=', $departDate)
                     ->where('departTime', '=', $departTime)->get();
                     
            //$tripNumber = DB::table('flight_leg')->where('depCode', '=', $departCode)->where('destCode', '=', $destCode)->where('departTime', '=', $departTime)->pluck('tripNum');
                     
            //$flight_leg = DB::table('flight_leg')->select('legDate')->where('departureCode', '=', $departCode)->where('tripNum', '=', $tripNumber)->pluck();
                     
            return View::make('searchresults')->with('id', $id)->with('flights', $flights);
		}
	}
	
	public function getSearchresults($id)
	{
		return View::make('searchresults')->with('id', $id);
	}
	
	public function getMyflights($id)
	{
		return View::make('myflights')->with('id', $id);
	}
	
	public function getFlightinfo($id, $tripNum)
	{
		return View::make('flightinfo')->with('id', $id)->with('tripNum', $tripNum);
	}
	
	public function postFlightinfo($id, $tripNum)
	{
		if(Input::has('bookflight'))
		{
			return Redirect::to('../../../bookflight/' . $id . '/' . $tripNum);
		}
		elseif(Input::has('delete'))
		{
			if(count(DB::table('payment')->select(DB::raw('*'))->where('tripNum', '=', $tripNum)->get()) == 0)
			{
				DB::table('flight_leg')
						 ->where('tripNum', '=', $tripNum)
						 ->delete();
				DB::table('trip')
						 ->where('tripNum', '=', $tripNum)
						 ->delete();
				return Redirect::to('../../../confirmdel/' . $id);
			}
			return Redirect::to('../../../declinedel/' . $id);
		}
		elseif(Input::has('edit'))
		{
			$legs = DB::table('flight_leg')
                     ->select(DB::raw('*'))
                     ->where('tripNum','=',$tripNum)->get();
			return View::make('edittrips')->with('id', $id)->with('legs', $legs);
		}
		return View::make('flightinfo')->with('id', $id)->with('tripNum', $tripNum);
	}
	
	public function getEditTrips($id)
	{
		return View::make('edittrips')->with('id', $id);
	}
	public function getEditPlane($id, $tripNum, $legNum)
	{
		return View::make('editplane')->with('id', $id)->with('tripNum', $tripNum)->with('legNum', $legNum);
	}
	
	public function getBookflight($id, $tripNum)
	{
		return View::make('bookflight')->with('id', $id)->with('tripNum', $tripNum);
	}
	
	public function postBookflight($id, $tripNum)
	{
		$money = intval(Input::get('money'));
		$tripPrice = intval(DB::table('trip')->where('tripNum', '=', $tripNum)->pluck('price'));
		if($money == $tripPrice)
		{
			$currentDate = date('m-d-Y');
		
			DB::table('reservation')->insert(
    		array('reserveDate' => $currentDate, 'accountNum' => $id));
    		
			DB::table('payment')->insert(
    		array('tripNum' => $tripNum, 'transactionNum' => $tripNum, 'accountNum' => $id));
    		
    		
    		$prevSeats = DB::table('flight_leg')
                     ->where('tripNum','=',$tripNum)->pluck('seatsAvailable');
            DB::table('flight_leg')
                     ->where('tripNum','=',$tripNum)
                     ->update(array('seatsAvailable' => $prevSeats-1));
            
    		return Redirect::to('../../../confirmres/' . $id);
		}
		else
		{
			return Redirect::to('../../../bookflight/' . $id . '/' . $tripNum);
		}
		
	}
	public function getConfirmedit($id,$tripNum,$legNum,$planeID)
	{
		$leg = DB::table('Flight_leg')->where('legNum','=',$legNum)->where('tripNum','=',$tripNum)->get();
		$prevSeats = DB::table('Airplane')->where('ID','=',$leg[0]->airplaneID)->pluck('numSeats');
		$newSeats = DB::table('Airplane')->where('ID','=',$planeID)->pluck('numSeats');
		
		DB::table('flight_leg')
			 ->where('tripNum', '=', $tripNum)
			 ->where('legNum', '=', $legNum)
			 ->update(array('seatsAvailable' => $newSeats-$prevSeats+$leg[0]->seatsAvailable,'airplaneID' => $planeID));
		return View::make('confirmedit')->with('id', $id)->with('tripNum', $tripNum)->with('legNum', $legNum)->with('planeID', $planeID);
	}
	public function getConfirmadd($id)
	{
		return View::make('confirmadd')->with('id', $id);
	}
	public function getConfirmres($id)
	{
		return View::make('confirmres')->with('id', $id);
	}
	public function getConfirmdel($id)
	{
		return View::make('confirmdel')->with('id', $id);
	}
	public function getDeclinedel($id)
	{
		return View::make('declinedel')->with('id', $id);
	}
	public function getNewtrip($id)
	{
		return View::make('newtrip')->with('id', $id);
	}
	public function postNewtrip($id)
	{
		//Gather post data
		$highestTripNum = DB::table('trip')
                     ->max('tripNum');
                     
		$input = Input::all();
		
		$trip = new Trip();
		$trip->departDate = Input::get('dep_date');
		$trip->departTime = Input::get('dep_time');
		$trip->depCode = Input::get('dep_code');
		$trip->destCode = Input::get('dest_code');
		$trip->numLegs = Input::get('numlegs');
		$trip->airline = Input::get('airline');
		$trip->price = Input::get('price');
		$trip->tripNum = $highestTripNum+1;
		$trip->save();
		
		$leg = new FlightLeg();
		$leg->legNum = 1;
		$leg->departTime = Input::get('dep_time');
		$leg->departureCode = Input::get('dep_code');
		$leg->destinationCode = Input::get('dest_code');
		$leg->tripNum = $trip->tripNum;
		$leg->arriveTime = Input::get('arriveTime');
		$leg->airplaneID = Input::get('airplane');
		$leg->seatsAvailable = Input::get('seats');
		
		$leg->save();
		if(Input::get('numlegs') == 1)
			return View::make('confirmadd')->with('id', $id);
		return Redirect::to('/nextleg/'. $id)->with('id', $id)->with('tripNum', $trip->tripNum)->with('prevLeg', $leg)->with('legs', $trip->numLegs);
	}
	public function getNextleg($id,$tripNum,$prevLeg,$numLegs)
	{
		return View::make('nextleg')->with('id', $id);
	}
	public function postNextleg($id,$tripNum,$prevLeg,$numLegs)
	{
		$leg = new FlightLeg();
		$leg->legNum = $prevLeg->legNum+1;
		$leg->departTime = $prevLeg->arriveTime;
		$leg->departureCode = $prevLeg->destinationCode;
		$leg->destinationCode = Input::get('dest_code');
		$leg->tripNum = $tripNum;
		$leg->arriveTime = Input::get('arriveTime');
		$leg->airplaneID = Input::get('airplane');
		$leg->seatsAvailable = Input::get('seats');
		
		$leg->save();
		if($leg->legNum == $numLegs)
			return View::make('confirmadd')->with('id', $id);
		return Redirect::to('/nextleg/'. $id)->with('id', $id)->with('tripNum', $tripNum)->with('prevLeg', $leg)->with('legs', $trip->numLegs);

	}
}