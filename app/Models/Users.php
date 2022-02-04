<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Crypt;

class Users extends Model
{

    // protected $table = 'userInfo';
    //    protected $primaryKey = 'id';
    // public $timestamps = false;

    public static function create_user($emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_create)
    {
        $datetime_now = date('Y-m-d H:i:s');
        $password = bcrypt($password);
        $sql = "INSERT INTO users 
        (id
        ,emp_code
        ,type 
        ,username
        ,password
        ,createdate
        ,updatedate
        ,createby
        ,updateby
        ,last_login
        ,active)
        VALUES 
        (0
        ,'{$emp_code}'
        , {$type}
        ,'{$username}'
        ,'{$password}'
        ,'{$datetime_now}'
        ,'{$datetime_now}'
        ,'{$user_create}'
        ,'{$user_create}'
        ,'{$datetime_now}'
        , 1)";

        $sql_user = DB::insert($sql);

        $datas = array();
        if (!empty($sql_user)) {
            $datas = $sql_user;
        }
        return $datas;
    }

    public static function create_user_profile($user_id, $emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_create, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone, $permission, $admin_menu)
    {
        $datetime_now = date('Y-m-d H:i:s');
        $sql_id = "UPDATE users SET id = {$user_id} WHERE type = {$type} AND emp_code = '{$emp_code}'";
        $sql_add_id = DB::insert($sql_id);

        $sql = "INSERT INTO user_profile 
        (user_id
        ,emp_code
        ,name_th
        ,name_en
        ,nickname1_th
        ,nickname1_en
        ,nickname2_th
        ,nickname2_en
        ,postname_th
        ,postname_en
        ,email
        ,3cx
        ,phone
        ,status
        ,group_id
        ,type
        ,createdate
        ,updatedate
        ,createby
        ,updateby
        ,image
        ,status_permission
        ,admin_menu
        ,active)
        VALUES 
        ({$user_id}
        ,'{$emp_code}'
        ,'{$name_th}'
        ,'{$name_en}'
        ,'{$nickname1_th}'
        ,'{$nickname1_en}'
        ,'{$nickname2_th}'
        ,'{$nickname2_en}'
        ,'{$postname_th}'
        ,'{$postname_en}'
        ,'{$email}'
        ,'{$cx}'
        ,'{$phone}'
        ,'{$status}'
        , {$group_id}
        , {$type}
        ,'{$datetime_now}'
        ,'{$datetime_now}'
        ,'{$user_create}'
        ,'{$user_create}'
        ,''
        ,'{$permission}'
        ,'{$admin_menu}'
        , 1)";

        $sql_user = DB::insert($sql);

        $datas = array();
        if (!empty($sql_user)) {
            $datas = $sql_user;
        }
        return $datas;
    }

    public static function check_user($username, $password, $type)
    {
        $sql = "
        SELECT * FROM users WHERE
        username = '{$username}'
        AND type = '{$type}'";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 1) {
            $credentials = array('username' => $username, 'password' => $password, 'type' => $type);

            if (!$token = JwtAuth::attempt($credentials)) {
                return response()->json([
                    'error' => [
                        'data' => $credentials
                    ]
                ], 400);
            }
            return response()->json([
                'success' => [
                    'data' => $user[] = array(
                        'access_token' => $token,
                        'token_type' => 'bearer',
                        'expires_in' => config('jwt.ttl')
                    )
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'data' => 'Validate Username or Password'
                ]
            ], 400);
        }


        // return $datas;

    }


    public static function check_register($emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_create, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone, $permission, $admin_menu)
    {
        $sql = "
        SELECT * FROM users WHERE
        emp_code = '{$emp_code}'
        AND type = '{$type}'
        AND active = 1";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 0) {
            $user = Users::create_user($emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_create);
            $sql = "
            SELECT * FROM users WHERE
            emp_code = '{$emp_code}'
            AND type = '{$type}'
            AND active = 1";

            $sql_user = DB::select($sql);
            $user_id = 0;
            foreach ($sql_user as $user) {
                $user_id =  $user->user_id;
            }
            $user_profile = Users::create_user_profile($user_id, $emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_create, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone, $permission, $admin_menu);
            return response()->json([
                'success' => [
                    'data' => 'User Created'
                ]
            ], 400);
        } else {
            return response()->json([
                'error' => [
                    'data' => 'User Duplicate!'
                ]
            ], 400);
        }
    }
}
