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
		$password = DB::statement($query);
		
		if($password == Input::get('password'))
		{
			return Redirect::to('homepage');
		}
	}
	
	public function postRegister()
	{
		$user = new User();
		$user->username = Input::get('username');
		$user->password = Input::get('password');
		$user->email = Input::get('email');
		$user->isAdmin = (Input::get('isAdmin')) ? 1 : 0;
		
		$user->save();
		
		return Redirect::to('/');
	}
	
	public function getHomepage()
	{
		return View::make('homepage');
	}

}