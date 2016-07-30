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

// 登录
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::group(['middleware' => 'auth'], function () {

    //任务
    Route::resource('/task', 'TaskController');
    Route::post('/task/action', 'TaskController@postAction');
    Route::post('/task/{id}', 'TaskController@update');

//地区
    Route::resource('/area', 'AreaController');
    Route::post('/area/action', 'AreaController@postAction');
    Route::post('/area/{id}', 'AreaController@update');

//主机
    Route::resource('/host', 'HostController');
    Route::post('/host/action', 'HostController@postAction');
    Route::post('/host/{id}', 'HostController@update');

//代理
    Route::resource('/host_proxy', 'HostProxyController');
    Route::post('/host_proxy/action', 'HostProxyController@postAction');
    Route::post('/host_proxy/{id}', 'HostProxyController@update');

//权限
    Route::resource('/role', 'RoleController');
    Route::post('/role/action', 'RoleController@postAction');
    Route::post('/role/{id}', 'RoleController@update');

//管理员
    Route::resource('/user', 'UserController');
    Route::post('/user/action', 'UserController@postAction');
    Route::post('/user/{id}', 'UserController@update');

//接口
    Route::get('/api/action', 'ApiController@postAction');
    Route::resource('/api', 'ApiController');
    Route::post('/api/{id}', 'ApiController@update');

    
});
