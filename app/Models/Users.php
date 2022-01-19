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

    public static function create_user($name, $email, $password, $status)
    {
        $datetime_now = date('Y-m-d H:i:s');
        $password     = bcrypt($password);
        $sql = "INSERT INTO users 
        (name 
        ,email
        ,password
        ,updated_at
        ,created_at
        ,status)
        VALUES 
        ('{$name}'
        ,'{$email}'
        ,'{$password}'
        ,'{$datetime_now}'
        ,'{$datetime_now}'
        ,'{$status}')";

        $sql_user = DB::insert($sql);

        $datas = array();
        if (!empty($sql_user)) {
            $datas = $sql_user;
        }
        return $datas;
    }

    public static function check_user($email, $password, $status)
    {
        $sql = "
        SELECT * FROM users WHERE
        email = '{$email}'
        AND status = '{$status}'";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 1) {
            $credentials = request(['email', 'password']);

            if (!$token = JwtAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $token;
        }
        else{
            return 'Unknow Username or Password';
        }


        // return $datas;

    }


    public static function check_register($name, $email, $password, $status)
    {
        $sql = "
        SELECT * FROM users WHERE
        email = '{$email}'
        AND status = '{$status}'";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 0) {
            $user = Users::create_user($name, $email, $password, $status);
            return 'User Created!';
        }
        else{
            return 'User Duplicate Status LDAP or User';
        }


        // return $datas;

    }
}
