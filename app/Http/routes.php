<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => 'loggedinauth'], function() {
	Route::get('/', 'LoginController@create');
	Route::post('/', 'LoginController@store');
});


//Page route ...

Route::get('/leaderboard','Pages@leaderboard');

Route::group(['middleware' => 'loginauth'], function() {
	
	Route::get('/logout', 'LoginController@logout');
	Route::get('/home','LoginController@index');
});


//API routes ...
Route::post('/getquestion','API@request_question');
Route::post('/answer','API@request_answer');

Route::post('/lock','API@lock_question');
Route::post('/locked','API@request_locked');
Route::post('/triesleft','API@tries_available');

