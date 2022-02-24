<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApplicationGroupController extends Controller
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

        $field_error = '';
        if ($group_id == '') {
            $field_error .= ' group_id,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $group = Application::groupdetail($group_id);

            return $this->createSuccessResponse([
                'success' => [
                    'data' => $group
                ]
            ], 200);
        }
    }

    public function dropdowngroup(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $group_id  = $_dataAll['group_id'];
        $user_id  = $_dataAll['user_id'];

        $field_error = '';
        if ($group_id == '') {
            $field_error .= ' group_id,';
        }
        if ($user_id == '') {
            $field_error .= ' user_id,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $group = Application::dropdown_group($group_id, $user_id);

            return $group;
        }
    }

    public function appuser(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $group_id  = $_dataAll['group_id'];
        $user_id  = $_dataAll['user_id'];

        $field_error = '';
        if ($group_id == '') {
            $field_error .= ' group_id,';
        }
        if ($user_id == '') {
            $field_error .= ' user_id,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $group = Application::app_user($group_id, $user_id);

            return $group;
        }
    }

    public function addgroup(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $app_id  = implode(",", $_dataAll['app_id']);

        $field_error = '';
        if ($name_th == "") {
            $field_error .= ' name_th,';
        }
        if ($name_en == "") {
            $field_error .= ' name_en,';
        }
        if ($app_id == "") {
            $field_error .= ' app_id,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $group = Application::add_group_app($name_th, $name_en, $app_id, $user->user_id);

            return $group;
        }
    }

    public function updategroup(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $group_id = $_dataAll['group_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $app_id   = implode(",", $_dataAll['app_id']);

        $field_error = '';
        if ($group_id == '') {
            $field_error .= ' group_id,';
        }
        if ($name_th == '') {
            $field_error .= ' name_th,';
        }
        if ($name_en == '') {
            $field_error .= ' name_en,';
        }
        if ($app_id == '') {
            $field_error .= ' app_id,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $group = Application::update_group_app($group_id, $name_th, $name_en, $app_id, $user->user_id);

            return $group;
        }
    }

    public function deletegroup(Request $request)
    {
        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $group_id = $_dataAll['group_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];

        $field_error = '';
        if ($group_id == '') {
            $field_error .= ' group_id,';
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
            $group = Application::delete_group_app($group_id, $name_th, $name_en, $user->user_id);

            return $group;
        }
    }
}
