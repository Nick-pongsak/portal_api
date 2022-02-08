<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApplicationGroupController extends Controller
{
    private function getUserLogin()
    {
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();
        return $user;
    }

    public function groupapp(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $keyword  = $_dataAll['keyword'];
        $field    = $_dataAll['field'];
        $sort    = $_dataAll['sort'];
        $group = Application::get_group_app($keyword, $field, $sort);

        return $group;
    }

    public function groupdetail(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $group_id  = $_dataAll['group_id'];
        $group = Application::groupdetail($group_id);

        return $this->createSuccessResponse([
            'success' => [
                'data' => $group
            ]
        ], 200);
    }

    public function dropdowngroup(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $group_id  = $_dataAll['group_id'];
        $user_id  = $_dataAll['user_id'];
        $group = Application::dropdown_group($group_id, $user_id);

        return $group;
    }

    public function addgroup(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $app_id  = implode(",",$_dataAll['app_id']);

        $group = Application::add_group_app($name_th, $name_en, $app_id, $user->user_id);

        return $group;
    }

    public function updategroup(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $group_id = $_dataAll['group_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $app_id   = implode(",",$_dataAll['app_id']);

        $group = Application::update_group_app($group_id, $name_th, $name_en, $app_id, $user->user_id);

        return $group;
    }

    public function deletegroup(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $group_id = $_dataAll['group_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];

        $group = Application::delete_group_app($group_id, $name_th, $name_en, $user->user_id);

        return $group;
    }
}