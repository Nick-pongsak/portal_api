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

        $app = Application::get_application();

        return response()->json([
            // 'message' => '',
            'data' => $app
        ]);
    }

    public function getcatagory(Request $request)
    {

        $cat = Application::get_catagory();

        return response()->json([
            // 'message' => '',
            'data' => $cat
        ]);
    }

    public function addapplication(Request $request)
    {
        $_dataAll = $request->all();
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $description_th  = $_dataAll['description_th'];
        $description_en  = $_dataAll['description_en'];
        $catagory_id  = $_dataAll['catagory_id'];
        $type_login  = $_dataAll['type_login'];
        $status  = $_dataAll['status'];
        $status_sso  = $_dataAll['status_sso'];
        $image  = $_dataAll['image'];
        $url  = $_dataAll['url'];

        $app = Application::check_add_application($name_th
        ,$name_en
        ,$description_th
        ,$description_en
        ,$catagory_id
        ,$type_login
        ,$status
        ,$status_sso
        ,$image
        ,$url);

        return response()->json([
            // 'message' => '',
            'message' => $app
        ]);
    }

    public function updateapplication(Request $request)
    {
        $_dataAll = $request->all();
        $app_id  = $_dataAll['app_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $description_th  = $_dataAll['description_th'];
        $description_en  = $_dataAll['description_en'];
        $catagory_id  = $_dataAll['catagory_id'];
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
        ,$catagory_id
        ,$type_login
        ,$status
        ,$status_sso
        ,$image
        ,$url);

        return response()->json([
            // 'message' => '',
            'message' => $app
        ]);
    }

    public function addcatagory(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];

        $app = Application::add_catagory($name_th
        ,$name_en
        ,$user->emp_code);


        return response()->json([
            // 'message' => '',
            'message' => 'success'
        ]);
    }

    public function updatecatagory(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $catagory_id  = $_dataAll['catagory_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];

        $app = Application::update_catagory($catagory_id, $name_th
        ,$name_en
        ,$user->emp_code);


        return response()->json([
            // 'message' => '',
            'message' => 'success'
        ]);
    }
}
