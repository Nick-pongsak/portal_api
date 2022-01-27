<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthPortalController;
use App\Http\Controllers\DepartmentManageController;
use App\Http\Controllers\ApplicationController;


Route::get('/date_now', function () {
    return date("Y-m-d H:i:s");
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'App\Http\Controllers'

], function ($router) {

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    Route::post('user-profile', 'AuthController@me');
    Route::post('tokenExpired', 'AuthController@tokenExpired');
    Route::get('setting-count-department', 'DepartmentManageController@getCountDepartment');
    Route::post('search-emp-ldap', 'AuthController@searchLDAP');
});
Route::post('/add-application', [ApplicationController::class, 'Addapplication']);

