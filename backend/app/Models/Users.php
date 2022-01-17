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

    public static function create_user($name, $email, $password)
    {
        $datetime_now = date('Y-m-d H:i:s');
        $password     = bcrypt($password);
        $sql = "INSERT INTO users 
        (name 
        ,email
        ,password
        ,updated_at
        ,created_at)
        VALUES 
        ('{$name}'
        ,'{$email}'
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

    public static function check_user($email, $password, $status)
    {
        $sql = "
        SELECT * FROM users WHERE
        email = '{$email}'
        AND status = '{$status}'";

        $sql_user = DB::select($sql);

        if (count($sql_user) > 0) {
            $credentials = request(['email', 'password']);

            if (!$token = JwtAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $token;
        }


        // return $datas;

    }
}
