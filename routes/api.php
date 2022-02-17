<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationGroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\imageController;


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
Route::post('/get-category', [ApplicationController::class, 'getcategory']);
Route::post('/add-category', [ApplicationController::class, 'addcategory']);
Route::post('/update-category', [ApplicationController::class, 'updatecategory']);
Route::post('/delete-category', [ApplicationController::class, 'deletecategory']);

// application_group
Route::post('/get-group-app', [ApplicationGroupController::class, 'groupapp']);
Route::post('/group-detail', [ApplicationGroupController::class, 'groupdetail']);
Route::post('/add-group', [ApplicationGroupController::class, 'addgroup']);
Route::post('/update-group', [ApplicationGroupController::class, 'updategroup']);
Route::post('/delete-group', [ApplicationGroupController::class, 'deletegroup']);


// users
Route::post('/dropdown-group', [ApplicationGroupController::class, 'dropdowngroup']);
Route::post('/get-user-list', [UserController::class, 'userlist']);
Route::post('/update-user', [UserController::class, 'updateuser']);
Route::post('/delete-user', [UserController::class, 'deleteuser']);

// image
Route::post('/upload-image', [imageController::class, 'upload_img']);

// font-end
Route::post('/application-user', [ApplicationGroupController::class, 'appuser']);

//user-setting-order
Route::post('/save-order', [UserController::class, 'saveorder']);

