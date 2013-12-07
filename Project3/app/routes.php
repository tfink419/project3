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

Route::get('edittrips/{id}/{tripNum}', 'HomeController@getEditTrips');
Route::get('editplane/{id}/{tripNum}/{legNum}', 'HomeController@getEditPlane');

Route::get('bookflight/{id}/{tripNum}', 'HomeController@getBookflight');
Route::post('bookflight/{id}/{tripNum}', 'HomeController@postBookflight');

Route::get('confirmedit/{id}/{tripNum}/{legNum}/{planeID}', 'HomeController@getConfirmedit');
Route::get('confirmres/{id}', 'HomeController@getConfirmres');
Route::get('confirmadd/{id}', 'HomeController@getConfirmadd');
Route::get('confirmdel/{id}', 'HomeController@getConfirmdel');
Route::get('declinedel/{id}', 'HomeController@getDeclinedel');

Route::get('newtrip/{id}', 'HomeController@getNewtrip');
Route::post('newtrip/{id}', 'HomeController@postNewtrip');

Route::get('nextleg/{id}', 'HomeController@getNextleg');
Route::post('nextleg/{id}', 'HomeController@postNextleg');