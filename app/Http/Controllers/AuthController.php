<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Users;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwtauth', ['except' => ['login', 'register', 'searchLDAP']]);
    }

    private function getUserLogin()
    {
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();
        return $user;
    }

    public function register(Request $request)
    {
        $_dataAll = $request->all();
        $user_create = $this->getUserLogin();
        $emp_code = $_dataAll['emp_code'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $postname_th  = $_dataAll['postname_th'];
        $postname_en  = $_dataAll['postname_en'];
        $email    = $_dataAll['email'];
        $status   = $_dataAll['status'];
        $group_id    = $_dataAll['group_id'];
        $type     = $_dataAll['type_login'];
        $username = $_dataAll['username'];
        $password = $_dataAll['password'];
        $cx       = $_dataAll['cx'];
        $phone     = $_dataAll['phone'];
        $nickname1_th = $_dataAll['nickname1_th'];
        $nickname1_en = $_dataAll['nickname1_en'];
        $nickname2_th = $_dataAll['nickname2_th'];
        $nickname2_en = $_dataAll['nickname2_en'];
        $permission   = $_dataAll['status_permission'];
        $admin_menu   = $_dataAll['admin_menu'];
        $app          = json_decode($_dataAll['app']);

        $field_error = '';
        if ($emp_code == '') {
            $field_error .= ' emp_code,';
        }if ($name_th == '') {
            $field_error .= ' name_th,';
        }if ($name_en == '') {
            $field_error .= ' name_en,';
        }if ($postname_th == '') {
            $field_error .= ' postname_th,';
        }if ($postname_en == '') {
            $field_error .= ' postname_en,';
        }if ($status == '') {
            $field_error .= ' status,';
        }if ($group_id == '') {
            $field_error .= ' group_id,';
        }if ($type == '') {
            $field_error .= ' type_login,';
        }if ($username == '') {
            $field_error .= ' username,';
        }if ($password == '') {
            $field_error .= ' password,';
        }if ($permission  == '') {
            $field_error .= ' status_permission,';
        }if ($admin_menu == '') {
            $field_error .= ' admin_menu,';
        }if ($app == '') {
            $field_error .= ' app,';
        }if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $user = Users::check_register($emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_create->user_id, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone, $permission, $admin_menu, $app);
            return $user;
        }
    }

    public function login(Request $request)
    {
        $_dataAll = $request->all();
        $username = $_dataAll['username'];
        $password = $_dataAll['password'];

        // decrypt password AES-256
        $key      = 'WebPortalKey';
        $password = Users::decrypt_crypto($password, $key);

        $type   = $_dataAll['type'];
        if ($type == 1) {
            $url = API_Sync . 'iauthen/ldap-authen';
            $data = array('login' => $username, 'password' => $password);

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result === FALSE) { /* Handle error */
                return response()->json([
                    'data' => $user[] = array(
                        'error' => 'Validate parameter '
                    )
                ], 500);
            } else {
                $data = json_decode($result);
                if (isset($data->success->data->access_token)) {
                    $password = 'LDAP';
                    $user = Users::check_user($username, $password, $type);
                    return $user;
                } else {
                    return response()->json([
                        'error' => [
                            'data' => 'Validate Username or Password'
                        ]
                    ], 400);
                }
            }
        } else {
            $user = Users::check_user($username, $password, $type);
            return $user;
        }
    }

    public function me()
    {
        // return response()->json(auth()->user());
        $user_create = $this->getUserLogin();

        $sql = "
        SELECT
         pro.user_id
        ,pro.emp_code
        ,pro.name_th
        ,pro.name_en
        ,pro.postname_th
        ,pro.postname_en
        ,pro.nickname1_th
        ,pro.nickname1_en
        ,pro.nickname2_th
        ,pro.nickname2_en
        ,pro.email
        ,pro.3cx as cx
        ,pro.phone
        ,pro.status
        ,pro.group_id
        ,pro.type as type_login
        ,IFNULL(pro.image,'') as image
        ,pro.status_permission
        ,pro.admin_menu,
        g.name_en as group_name_en,
        g.name_th as group_name_th 
        FROM users u
        INNER JOIN user_profile pro
        ON u.user_id = pro.user_id
        INNER JOIN application_group g
        ON pro.group_id = g.group_id
        WHERE
        u.user_id = {$user_create->user_id}
        AND u.active = 1";

        $sql_user = DB::select($sql);

        // language
        $sql_language = "
        SELECT
         pro.user_id
        ,pro.emp_code
        ,pro.name_th
        ,pro.name_en
        ,pro.postname_th
        ,pro.postname_en
        ,pro.nickname1_th
        ,pro.nickname1_en
        ,pro.nickname2_th
        ,pro.nickname2_en
        ,pro.email
        ,pro.3cx as cx
        ,pro.phone
        ,pro.status
        ,pro.group_id
        ,pro.type as type_login
        ,IFNULL(pro.image,'') as image
        ,pro.status_permission
        ,pro.admin_menu,
        g.name_en as group_name_en,
        g.name_th as group_name_th,
        s.language 
        FROM users u
        INNER JOIN user_profile pro
        ON u.user_id = pro.user_id
        INNER JOIN user_setting s
        ON u.user_id = s.user_id
        INNER JOIN application_group g
        ON pro.group_id = g.group_id
        WHERE
        u.user_id = {$user_create->user_id}
        AND u.active = 1";

        $sql_language = DB::select($sql_language);

        if (count($sql_user) == 1 && count($sql_language) == 0) {
            foreach ($sql_user as $item) {
                $datas = array(
                    'user_id' => $item->user_id,
                    'emp_code' => $item->emp_code,
                    'name_th' => $item->name_th,
                    'name_en' => $item->name_en,
                    'postname_th' => $item->postname_th,
                    'postname_en' => $item->postname_en,
                    'nickname1_th' => $item->nickname1_th,
                    'nickname1_en' => $item->nickname1_en,
                    'nickname2_th' => $item->nickname2_th,
                    'nickname2_en' => $item->nickname2_en,
                    'email' => $item->email,
                    'cx' => $item->cx,
                    'phone' => $item->phone,
                    'status' => $item->status,
                    'group_id' => $item->group_id,
                    'group_name_th' => $item->group_name_th,
                    'group_name_en' => $item->group_name_en,
                    'type_login' => $item->type_login,
                    'image' => ($item->image == '' ? '' : Path_Image.'apiweb/images/user-profile/' . $item->image),
                    'status_permission' => $item->status_permission,
                    'admin_menu' => $item->admin_menu,
                    'language' => 'th',
                );
            }
            return response()->json([
                'success' => [
                    'data' => $datas
                ]
            ], 200);
        }else if (count($sql_user) == 1 && count($sql_language) == 1) {
            foreach ($sql_language as $item) {
                $datas = array(
                    'user_id' => $item->user_id,
                    'emp_code' => $item->emp_code,
                    'name_th' => $item->name_th,
                    'name_en' => $item->name_en,
                    'postname_th' => $item->postname_th,
                    'postname_en' => $item->postname_en,
                    'nickname1_th' => $item->nickname1_th,
                    'nickname1_en' => $item->nickname1_en,
                    'nickname2_th' => $item->nickname2_th,
                    'nickname2_en' => $item->nickname2_en,
                    'email' => $item->email,
                    'cx' => $item->cx,
                    'phone' => $item->phone,
                    'status' => $item->status,
                    'group_id' => $item->group_id,
                    'group_name_th' => $item->group_name_th,
                    'group_name_en' => $item->group_name_en,
                    'type_login' => $item->type_login,
                    'image' => ($item->image == '' ? '' : Path_Image.'apiweb/images/user-profile/' . $item->image),
                    'status_permission' => $item->status_permission,
                    'admin_menu' => $item->admin_menu,
                    'language' => $item->language,
                );
            }
            return response()->json([
                'success' => [
                    'data' => $datas
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'data' => 'token expired'
                ]
            ], 401);
        }
    }

    public function tokenExpired()
    {
        if (Carbon::parse(date('Y-m-d H:i:s')) < Carbon::now()) {
            return response()->json(auth()->user());
        }
        return response()->json(['message' => 'Acess token expires']);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    protected function respondWithToken($token)
    {
        return response()->json([
            'data' => $user[] = array(
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl')
            )
        ]);
    }

    public function searchLDAP(Request $request)
    {
        $_dataAll = $request->all();
        $emp_code = $_dataAll['emp_code'];
        $ldap = file_get_contents(API_Sync . "iauthen/get-all-profile?user_name=&emp_number={$emp_code}");
        $data = json_decode($ldap);
        $i = 0;
        foreach ($data->data as $item) {
            $user[] = array(
                'index'       => $i,
                'user_id'     => '',
                'emp_code'    => $item->employeenumber,
                'username'    => $item->uid,
                'name_th'     => trim($item->fnamethai, ' ') . ' ' . $item->lnamethai,
                'name_en'     => $item->firstname . ' ' . $item->lastname,
                'postname_th' => $item->postname_thai,
                'postname_en' => $item->postname_en,
                'nickname1_th' => '',
                'nickname1_en' => '',
                'nickname2_th' => '',
                'nickname2_en' => '',
                'email'       => $item->email,
                'cx'          => '',
                'phone'       => '',
                'group_id'    => '',
                'group_name_th' => '',
                'group_name_en' => '',
                'type_login'  => 1,
                'image'       => '',
                'status_permission' => '',
                'admin_menu'  => '',
            );
            $i++;
        }

        return $this->createSuccessResponse([
            'success' => [
                'data' => $user
            ]
        ], 200);
    }
}
