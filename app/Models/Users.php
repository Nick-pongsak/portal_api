<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class Users extends Model
{

    // protected $table = 'userInfo';
    //    protected $primaryKey = 'id';
    // public $timestamps = false;

    public static function create_user($emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group, $type, $username, $password)
    {
        $datetime_now = date('Y-m-d H:i:s');
        $password = bcrypt($password);
        $sql = "INSERT INTO users 
        (emp_code 
        ,name_th
        ,name_en
        ,postname_th
        ,postname_en
        ,email
        ,status
        ,group_app
        ,type
        ,username
        ,password
        ,created_at
        ,updated_at)
        VALUES 
        ('{$emp_code}'
        ,'{$name_th}'
        ,'{$name_en}'
        ,'{$postname_th}'
        ,'{$postname_en}'
        ,'{$email}'
        ,'{$status}'
        ,'{$group}'
        ,'{$type}'
        ,'{$username}'
        ,'{$password}'
        ,'{$datetime_now}'
        ,'{$datetime_now}')";

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
            $credentials = array('username'=>$username,'password'=>$password,'type'=>$type);

            if (!$token = JwtAuth::attempt($credentials)) {
                return response()->json([
                    'data' =>$user[] = array(
                        'error' => 'Unauthorized'
                    )
                ], 401);
            }
            return response()->json([
                'data' => $user[] = array(
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => config('jwt.ttl')
                )
            ], 200);
        } else {
            return response()->json([
                 'data' =>$user[] = array(
                     'error' => 'Unknow Username or Password'
                )
            ], 401);
        }


        // return $datas;

    }


    public static function check_register($emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group, $type, $username, $password)
    {
        $sql = "
        SELECT * FROM users WHERE
        emp_code = '{$emp_code}'
        AND type = '{$type}'";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 0) {
            $user = Users::create_user($emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group, $type, $username, $password);
            return 'User Created!';
        } else {
            return 'User Duplicate Status LDAP or User';
        }


        // return $datas;

    }
}
