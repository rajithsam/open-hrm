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

// Org route
Route::get('org','System\OrgController@index');
Route::post('org/create','System\OrgController@store');
Route::get('api/org.json','System\OrgController@getOrg');

// Department route
Route::get('department','System\DepartmentController@index');
Route::post('department/create','System\DepartmentController@store');
Route::post('department/update','System\DepartmentController@update');
Route::post('department/remove','System\DepartmentController@remove');
Route::get('api/departments.json','System\DepartmentController@getAll');
Route::get('departments.json','System\DepartmentController@getActiveDepartments');

// Designation route
Route::get('designation','System\DesignationController@index');
Route::post('designation/create','System\DesignationController@store');
Route::post('designation/update','System\DesignationController@update');
Route::post('designation/remove','System\DesignationController@remove');
Route::get('api/designations.json','System\DesignationController@getAll');
Route::get('designations/{department_id}','System\DesignationController@getByDepartment');
Route::get('api/designations-with-child.json','System\DesignationController@getAllWithChild');
// WorkWeek route
Route::get('workweek','System\WorkweekController@index');
Route::post('workweek/create','System\WorkweekController@store');
Route::get('api/workweek.json','System\WorkweekController@getAll');

// User route
Route::get('users','User\UserController@index');
Route::post('user/create','User\UserController@store');
Route::post('user/update','User\UserController@update');
Route::post('user/remove','User\UserController@remove');
Route::get('api/users.json','User\UserController@getAll');

// Role route
Route::get('role','User\RoleController@index');
Route::any('role/create','User\RoleController@store');
Route::get('api/roles.json','User\RoleController@getAll');

// Permission route
Route::get('permissions/{id}', 'User\PermissionController@index');
Route::post('permission/create','User\PermissionController@store');
Route::get('api/permissions.json','User\PermissionController@getAll');
Route::get('api/{id}/permission_role.json','User\PermissionController@getAllPermissionRole');

// Employee route
Route::get('employee','Employee\EmployeeController@index');
Route::get('api/available-employees.json','Employee\EmployeeController@getAvailableEmployees');
Route::get('api/assigned-employees.json','Employee\EmployeeController@getAssignedEmployees');
Route::post('employee/create','Employee\EmployeeController@store');
Route::post('employee/update/{option}','Employee\EmployeeController@update');

Route::get('holiday','System\HolidayController@index');
Route::post('holiday/create','System\HolidayController@store');
Route::post('holiday/update/{id}/{option}','System\HolidayController@update');
Route::get('holidays.json','System\HolidayController@getAll');
Route::get('holidays/{date}','System\HolidayController@getAll');
Route::post('holiday/delete','System\HolidayController@delete');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',

]);
