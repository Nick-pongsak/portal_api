<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    private function getUserLogin()
    {
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();
        return $user;
    }

    public function userlist(Request $request)
    {

        $_dataAll = $request->all();
        $user_s = $this->getUserLogin();
        $keyword  = $_dataAll['keyword'];
        $field  = $_dataAll['field'];
        $sort  = $_dataAll['sort'];
        $user = Users::get_user_list($keyword, $field, $sort);

        return $this->createSuccessResponse([
            'success' => [
                'data' => $user
            ]
        ], 200);
    }

    public function updateuser(Request $request)
    {

        $_dataAll = $request->all();
        $user_s = $this->getUserLogin();
        $user_create = $this->getUserLogin();
        $user_id = $_dataAll['user_id'];
        $emp_code = $_dataAll['emp_code'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $postname_th  = $_dataAll['postname_th'];
        $postname_en  = $_dataAll['postname_en'];
        $email    = $_dataAll['email'];
        $status   = $_dataAll['status'];
        $group_id    = $_dataAll['group_id'];
        $type     = $_dataAll['type'];
        $username = $_dataAll['username'];
        $password = $_dataAll['password'];
        $cx       = $_dataAll['cx'];
        $phone     = $_dataAll['phone'];
        $nickname1_th = $_dataAll['nickname1_th'];
        $nickname1_en = $_dataAll['nickname1_en'];
        $nickname2_th = $_dataAll['nickname2_th'];
        $nickname2_en = $_dataAll['nickname2_en'];
        $permission   = $_dataAll['permission'];
        $admin_menu   = $_dataAll['admin_menu'];

        $user = Users::update_user($user_id, $emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_create->user_id, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone, $permission, $admin_menu);

        return $this->createSuccessResponse([
            'success' => [
                'data' => $user
            ]
        ], 200);
    }

    public function deleteuser(Request $request)
    {

        $_dataAll = $request->all();
        $user_s = $this->getUserLogin();
        $user_id  = $_dataAll['user_id'];
        $user = Users::delete_user($user_id);

        return $this->createSuccessResponse([
            'success' => [
                'data' => $user
            ]
        ], 200);
    }
}
