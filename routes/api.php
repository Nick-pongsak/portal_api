<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationGroupController;
use App\Http\Controllers\UserController;


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
Route::post('/application-detail', [ApplicationController::class, 'application']);
Route::post('/add-application', [ApplicationController::class, 'addapplication']);
Route::post('/update-application', [ApplicationController::class, 'updateapplication']);
Route::post('/delete-application', [ApplicationController::class, 'deleteapplication']);

// category
Route::post('/get_category', [ApplicationController::class, 'getcategory']);
Route::post('/add_category', [ApplicationController::class, 'addcategory']);
Route::post('/update_category', [ApplicationController::class, 'updatecategory']);
Route::post('/delete_category', [ApplicationController::class, 'deletecategory']);

// application_group
Route::post('/get-group-app', [ApplicationGroupController::class, 'groupapp']);
Route::post('/add_group', [ApplicationGroupController::class, 'addgroup']);
Route::post('/update_group', [ApplicationGroupController::class, 'updategroup']);
Route::post('/delete_group', [ApplicationGroupController::class, 'deletegroup']);

// users
Route::post('/get-user-list', [UserController::class, 'userlist']);

