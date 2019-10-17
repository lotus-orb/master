<?php

	/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'AdminController@login')->name('login');
Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function() {
	Route::get('/', 'AdminController@index');
	Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
	Route::get('/logout', 'AdminController@logout')->middleware('auth')->name('logout');

	// Route Main Content

	//Route untuk Data Ajax Main Content

	// Route Settings
	Route::resource('/users', 'UserController');
	Route::resource('/permissions', 'PermissionController');
	Route::resource('/roles', 'RoleController');

	// Route untuk Data Ajax for request and response
	Route::get('api_data', 'UserController@api_data')->name('api_data');
	Route::get('api_roles', 'RoleController@api_roles')->name('api_roles');
	Route::get('api_permissions', 'PermissionController@api_permissions')->name('api_permissions');
	
});
