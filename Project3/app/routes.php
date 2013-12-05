<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@getLogin');
Route::post('/', 'HomeController@postLogin');

Route::get('register', 'HomeController@getRegister');
Route::post('register', 'HomeController@postRegister');

Route::get('homepage/{id}', 'HomeController@getHomepage');

Route::post('login', 'HomeController@postLogin');

Route::get('logout/{id}', 'HomeController@getLogout');

Route::get('searchflights/{id}', 'HomeController@getSearchflights');
Route::post('searchflights/{id}', 'HomeController@postSearchflights');


Route::get('myflights/{id}', 'HomeController@getMyflights');

Route::get('searchresults/{id}', 'HomeController@getSearchresults');

Route::get('flightinfo/{id}/{tripNum}', 'HomeController@getFlightInfo');
Route::post('flightinfo/{id}/{tripNum}', 'HomeController@postFlightInfo');


Route::get('bookflight/{id}/{tripNum}', 'HomeController@getBookflight');
