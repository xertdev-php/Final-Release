<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', "LoginController@index");
Route::post('login-process', "LoginController@login_process");
Route::get('logout', "LoginController@logout");
Route::group(['middleware' => 'checkLogin'], function () {
    Route::get('dashboard', "DashboardController@index");

    // Users
    Route::match(['post'], 'users/datatable', 'UsersController@datatable');
    Route::match(['post'], 'users/destroy', 'UsersController@destroy');
    Route::match(['get'], 'users/change-password/{id}', 'UsersController@change_password');
    Route::match(['post'], 'users/update-password', 'UsersController@update_password');
    Route::resource("/users", "UsersController");

    // Department
    Route::match(['post'], 'department/datatable', 'DepartmentController@datatable');
    Route::match(['post'], 'department/destroy', 'DepartmentController@destroy');
    Route::resource("/department", "DepartmentController");

    // Country
    Route::match(['post'], 'country/datatable', 'CountryController@datatable');
    Route::match(['post'], 'country/destroy', 'CountryController@destroy');
    Route::resource("/country", "CountryController");

    // State
    Route::match(['post'], 'state/datatable', 'StateController@datatable');
    Route::match(['post'], 'state/destroy', 'StateController@destroy');
    Route::resource("/state", "StateController");

    // City
    Route::match(['post'], 'city/datatable', 'CityController@datatable');
    Route::match(['post'], 'city/destroy', 'CityController@destroy');
    Route::resource("/city", "CityController");

    // Employee
    Route::match(['post'], 'employee/datatable', 'EmployeeController@datatable');
    Route::match(['post'], 'employee/destroy', 'EmployeeController@destroy');
    Route::match(['post'], 'employee/get_state', 'EmployeeController@get_state');
    Route::match(['post'], 'employee/get_city', 'EmployeeController@get_city');
    Route::resource("/employee", "EmployeeController");
});