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

Route::get('/', function()
{
	return View::make('hello');
});


//:: User Account Routes ::
Route::get('user/login', 'UserController@getLogin');

Route::get('user/logout', 'UserController@getLogout');

Route::group(['before' => 'csrf'], function(){
    Route::post('user/login', 'UserController@postLogin');
});


Route::get('user/login', 'UserController@getLogin');