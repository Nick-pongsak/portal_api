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

// front-end
Route::post('/application-user', [ApplicationGroupController::class, 'appuser']);

//user-setting
Route::post('/save-order', [UserController::class, 'saveorder']);
Route::post('/upload-image', [UserController::class, 'upload_img']);
Route::post('/delete-image', [UserController::class, 'delimg']);
Route::post('/update-profile', [UserController::class, 'update_profile']);
Route::post('/change-password', [UserController::class, 'change_password']);
Route::post('/change-password-new', [UserController::class, 'change_password_new']);
Route::post('/update-language', [UserController::class, 'update_language']);

// AES256
Route::post('/aes-encrypt', [UserController::class, 'aes_encrypt']);
Route::post('/aes-decrypt', [UserController::class, 'aes_decrypt']);

// sso sales_ops
Route::post('/check-user-access', [UserController::class, 'checkaccess']); // login app
Route::post('/check-authen-app', [UserController::class, 'chkapp']); // login app
Route::post('/update-username-sso', [UserController::class, 'update_username_sso']);

// sso corporate
Route::post('/check-authen-corp', [UserController::class, 'corp_verify']); // verify

// sso mktops
Route::post('/check-authen-mktops', [UserController::class, 'mktops_verify']); // verify

// import user csv
Route::post('/import-user', [UserController::class, 'import_user']);
Route::post('/get-temporary', [UserController::class, 'get_temporary']);
Route::post('/import-temp-to-users', [UserController::class, 'import_temporary_to_user_profile']);