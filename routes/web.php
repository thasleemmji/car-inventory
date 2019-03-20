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
Route::group(['middleware' => 'guest'], function () {
	Route::get('/', 'LoginController@index')->name('login');
	Route::get('login', 'LoginController@index')->name('login');
	Route::post('login', 'LoginController@authenticate')->name('login');
});

Route::group(['middleware' => 'autherized'], function () {
	Route::post('logout', 'LoginController@logout')->name('logout');
	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
	
	Route::resource('manufacturers', 'ManufacturerController');
	Route::get('getManufatureres', 'ManufacturerController@getAll');

	Route::resource('models', 'ModelController');

	Route::get('inventory', 'InventoryController@index');
	Route::post('updateSold', 'InventoryController@sell');
	//ajax routes
	Route::post('checkExist', 'AjaxController@checkExist');
	Route::post('uploadimage', 'AjaxController@uploadImg');
});