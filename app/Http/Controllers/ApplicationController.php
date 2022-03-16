<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Tymon\JWTAuth\Facades\JWTAuth;
use Image;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwtauth');
    }

    private function getUserLogin()
    {
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();
        return $user;
    }

    public function application(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $keyword  = $_dataAll['keyword'];
        $field  = $_dataAll['field'];
        $sort  = $_dataAll['sort'];
        $app = Application::get_application($keyword, $field, $sort);

        return $this->createSuccessResponse([
            'success' => [
                'data' => $app
            ]
        ], 200);
    }

    public function getcategory(Request $request)
    {

        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $keyword  = $_dataAll['keyword'];
        $field  = $_dataAll['field'];
        $sort  = $_dataAll['sort'];
        $cat = Application::get_category($keyword, $field, $sort);

        return $this->createSuccessResponse([
            'success' => [
                'data' => $cat
            ]
        ], 200);
    }

    public function addapplication(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $description_th  = $_dataAll['description_th'];
        $description_en  = $_dataAll['description_en'];
        $category_id  = $_dataAll['category_id'];
        $key_app  = $_dataAll['key_app'];
        $type_login  = $_dataAll['type_login'];
        $status  = $_dataAll['status'];
        $status_sso  = $_dataAll['status_sso'];
        $image  = $_dataAll['image'];
        $url  = $_dataAll['url'];

        $field_error = '';
        if ($name_th == '') {
            $field_error .= ' name_th,';
        }
        if ($name_en == '') {
            $field_error .= ' name_en,';
        }
        if ($description_th == '') {
            $field_error .= ' description_th,';
        }
        if ($description_en == '') {
            $field_error .= ' description_en,';
        }
        if ($category_id == '') {
            $field_error .= ' category_id,';
        }
        if ($key_app == '' && $status_sso == 1) {
            $field_error .= ' key_app,';
        }
        if ($type_login == '') {
            $field_error .= ' type_login,';
        }
        if ($status == '') {
            $field_error .= ' status,';
        }
        if ($status_sso == '') {
            $field_error .= ' status_sso,';
        }

        if ($image == '') {
            $field_error .= ' image,';
        }else{
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();
    
            $destinationPath = public_path('images/banner-app');
            $img = Image::make($image->path());
            $img->resize(240,180, function($constraint){
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);
        }

        if ($url  == '') {
            $field_error .= ' url,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $app = Application::check_add_application(
                $name_th,
                $name_en,
                $description_th,
                $description_en,
                $category_id,
                $key_app,
                $type_login,
                $status,
                $status_sso,
                $input['imagename'],
                $url,
                $user->user_id
            );

            return $app;
        }
    }

    public function updateapplication(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $app_id  = $_dataAll['app_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $description_th  = $_dataAll['description_th'];
        $description_en  = $_dataAll['description_en'];
        $category_id  = $_dataAll['category_id'];
        $key_app  = $_dataAll['key_app'];
        $type_login  = $_dataAll['type_login'];
        $status  = $_dataAll['status'];
        $status_sso  = $_dataAll['status_sso'];
        $image  = $_dataAll['image'];
        $url  = $_dataAll['url'];

        $field_error = '';
        if ($app_id == '') {
            $field_error .= ' app_id,';
        }
        if ($name_th == '') {
            $field_error .= ' name_th,';
        }
        if ($name_en == '') {
            $field_error .= ' name_en,';
        }
        if ($description_th == '') {
            $field_error .= ' description_th,';
        }
        if ($description_en == '') {
            $field_error .= ' description_en,';
        }
        if ($category_id == '') {
            $field_error .= ' category_id,';
        }
        if ($key_app == '') {
            $field_error .= ' key_app,';
        }
        if ($type_login == '') {
            $field_error .= ' type_login,';
        }
        if ($status == '') {
            $field_error .= ' status,';
        }
        if ($status_sso == '') {
            $field_error .= ' status_sso,';
        }

        if ($image != ''){
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();
    
            $destinationPath = public_path('images/banner-app');
            $img = Image::make($image->path());
            $img->resize(240,180, function($constraint){
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);
        }

        if ($url  == '') {
            $field_error .= ' url,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $app = Application::update_application(
                $app_id,
                $name_th,
                $name_en,
                $description_th,
                $description_en,
                $category_id,
                $key_app,
                $type_login,
                $status,
                $status_sso,
                ($image == '' ? '' : $input['imagename']),
                $url,
                $user->user_id
            );

            return $app;
        }
    }

    public function deleteapplication(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $app_id  = $_dataAll['app_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $confirm  = $_dataAll['confirm'];

        $field_error = '';
        if ($app_id == '') {
            $field_error .= ' app_id,';
        }
        if ($name_th == '') {
            $field_error .= ' name_th,';
        }
        if ($name_en == '') {
            $field_error .= ' name_en,';
        }
        if ($confirm == '') {
            $field_error .= ' confirm,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $app = Application::delete_application(
                $app_id,
                $name_th,
                $name_en,
                $user->user_id,
                $confirm
            );

            return $app;
        }
    }

    public function addcategory(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];

        $field_error = '';
        if ($name_th == '') {
            $field_error .= ' name_th,';
        }
        if ($name_en == '') {
            $field_error .= ' name_en,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $app = Application::add_category(
                $name_th,
                $name_en,
                $user->user_id
            );
            return $app;
        }
    }

    public function updatecategory(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $category_id  = $_dataAll['category_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];

        $field_error = '';
        if ($name_th == '') {
            $field_error .= ' name_th,';
        }
        if ($name_en == '') {
            $field_error .= ' name_en,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $app = Application::update_category(
                $category_id,
                $name_th,
                $name_en,
                $user->user_id
            );

            return $this->createSuccessResponse([
                'success' => [
                    'data' => 'Categoty Updated'
                ]
            ], 200);
        }
    }

    public function deletecategory(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $category_id  = $_dataAll['category_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];

        $field_error = '';
        if ($category_id == '') {
            $field_error .= ' category_id,';
        }
        if ($name_th == '') {
            $field_error .= ' name_th,';
        }
        if ($name_en == '') {
            $field_error .= ' name_en,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $app = Application::delete_category(
                $category_id,
                $name_th,
                $name_en,
                $user->user_id
            );
            return $app;
        }
        
    }
}
