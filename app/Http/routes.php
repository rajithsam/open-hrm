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

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');
Route::get('test','TestController@index');
Route::get('role','RoleController@index');

Route::any('role/store','RoleController@store');
Route::get('api/roles.json','RoleController@all');

// Org route
Route::get('system/org','OrgController@index');
Route::post('org/store','OrgController@store');
Route::get('api/org.json','OrgController@getOrg');

// Department route
Route::get('system/department','DepartmentController@index');
Route::post('department/store','DepartmentController@store');
Route::get('api/departments.json','DepartmentController@getAll');

// WorkWeek route
Route::get('system/workweek','WorkweekController@index');
Route::post('workweek/store','WorkweekController@store');
Route::get('api/workweek.json','WorkweekController@getAll');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',

]);
