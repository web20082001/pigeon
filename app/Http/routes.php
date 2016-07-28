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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/area', 'AreaController');
Route::post('/area/action', 'AreaController@postAction');
Route::post('/area/{id}', 'AreaController@update');


Route::resource('/host', 'HostController');
Route::post('/host/action', 'HostController@postAction');
Route::post('/host/{id}', 'HostController@update');


Route::resource('/role', 'RoleController');
Route::post('/role/action', 'RoleController@postAction');
Route::post('/role/{id}', 'RoleController@update');