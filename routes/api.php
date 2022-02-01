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
// application
Route::get('/application-detail', [ApplicationController::class, 'application']);
Route::post('/add-application', [ApplicationController::class, 'addapplication']);
Route::post('/update-application', [ApplicationController::class, 'updateapplication']);
Route::post('/delete-application', [ApplicationController::class, 'deleteapplication']);

// category
Route::get('/get_category', [ApplicationController::class, 'getcategory']);
Route::post('/add_category', [ApplicationController::class, 'addcategory']);
Route::post('/update_category', [ApplicationController::class, 'updatecategory']);
Route::post('/delete_category', [ApplicationController::class, 'deletecategory']);

