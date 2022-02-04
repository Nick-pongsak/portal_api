<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        $cat = Application::get_category();

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
        $type_login  = $_dataAll['type_login'];
        $status  = $_dataAll['status'];
        $status_sso  = $_dataAll['status_sso'];
        $image  = $_dataAll['image'];
        $url  = $_dataAll['url'];

        $app = Application::check_add_application($name_th
        ,$name_en
        ,$description_th
        ,$description_en
        ,$category_id
        ,$type_login
        ,$status
        ,$status_sso
        ,$image
        ,$url
        ,$user->user_id);

        return $app;

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
        $type_login  = $_dataAll['type_login'];
        $status  = $_dataAll['status'];
        $status_sso  = $_dataAll['status_sso'];
        $image  = $_dataAll['image'];
        $url  = $_dataAll['url'];

        $app = Application::update_application($app_id
        ,$name_th
        ,$name_en
        ,$description_th
        ,$description_en
        ,$category_id
        ,$type_login
        ,$status
        ,$status_sso
        ,$image
        ,$url
        ,$user->user_id);

        return $app;

    }

    public function deleteapplication(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $app_id  = $_dataAll['app_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        // $description_th  = $_dataAll['description_th'];
        // $description_en  = $_dataAll['description_en'];
        // $category_id  = $_dataAll['category_id'];
        // $type_login  = $_dataAll['type_login'];
        // $status  = $_dataAll['status'];
        // $status_sso  = $_dataAll['status_sso'];
        // $image  = $_dataAll['image'];
        // $url  = $_dataAll['url'];

        $app = Application::delete_application($app_id
        ,$name_th
        ,$name_en
        // ,$description_th
        // ,$description_en
        // ,$category_id
        // ,$type_login
        // ,$status
        // ,$status_sso
        // ,$image
        // ,$url
        ,$user->user_id);

        return $app;

    }

    public function addcategory(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];

        $app = Application::add_category($name_th
        ,$name_en
        ,$user->user_id);


        return $app;
    }

    public function updatecategory(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $category_id  = $_dataAll['category_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];

        $app = Application::update_category($category_id, $name_th
        ,$name_en
        ,$user->user_id);

        return $this->createSuccessResponse([
            'success' => [
                'data' => 'success'
            ]
        ], 200);
    }

    public function deletecategory(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $category_id  = $_dataAll['category_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];

        $app = Application::delete_category($category_id, $name_th
        ,$name_en
        ,$user->user_id);

        return $app;
    }
}
