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
		if(Input::has('date1') && Input::has('date2'))
		{
			
		}
		else
		{
			//Normal search
			$departDate = Input::get('dep_date');
			$departTime = Input::get('dep_time');
			$departTime = str_replace(':', '_', $departTime);
			$departCode = Input::get('dep_code');
			$destCode = Input::get('dest_code');
			
			$flights = DB::table('flight_leg')
                     ->select(DB::raw('*'))
                     ->where('departureCode', '=', $departCode)
                     ->where('destinationCode', '=', $destCode)
                     ->where('legDate', '=', $departDate)
                     ->where('departTime', '=', $departTime)->get();
                     
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
		return View::make('flightinfo')->with('id', $id)->with('tripNum', $tripNum);
	}
	
	public function getBookflight($id, $tripNum)
	{
		return View::make('bookflight')->with('id', $id)->with('tripNum', $tripNum);
	}

}