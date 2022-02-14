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

    public static function edit_user($user_id, $emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_update)
    {
        $datetime_now = date('Y-m-d H:i:s');
        // $password = bcrypt($password);
        $sql = "UPDATE users SET
         emp_code = '{$emp_code}'
        ,type = {$type}
        ,username = '{$username}'
        ,password = '{$password}'
        ,updatedate = '{$datetime_now}'
        ,updateby = '{$user_update}'
        WHERE user_id = {$user_id}";

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

    public static function edit_user_profile($user_id, $emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_update, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone, $permission, $admin_menu)
    {
        $datetime_now = date('Y-m-d H:i:s');

        $sql = "UPDATE user_profile SET 
         emp_code = '{$emp_code}'
        ,name_th  = '{$name_th}'
        ,name_en  = '{$name_en}'
        ,nickname1_th = '{$nickname1_th}'
        ,nickname1_en = '{$nickname1_en}'
        ,nickname2_th = '{$nickname2_th}'
        ,nickname2_en = '{$nickname2_en}'
        ,postname_th  = '{$postname_th}'
        ,postname_en  = '{$postname_en}'
        ,email = '{$email}'
        ,3cx   = '{$cx}'
        ,phone = '{$phone}'
        ,status = '{$status}'
        ,group_id = {$group_id}
        ,type = {$type}
        ,updatedate = '{$datetime_now}'
        ,updateby   = '{$user_update}'
        ,image      = ''
        ,status_permission = '{$permission}'
        ,admin_menu = '{$admin_menu}'
        WHERE user_id = {$user_id}";

        $sql_user = DB::insert($sql);

        $datas = array();
        if (!empty($sql_user)) {
            $datas = $sql_user;
        }
        return $datas;
    }

    public static function create_username_sso($user_id, $emp_code, $app_id, $username, $password_sso, $user_create)
    {
        $datetime_now = date('Y-m-d H:i:s');
        // $password = bcrypt($password);
        $sql = "INSERT INTO sso 
        (emp_code
        ,user_id
        ,app_id
        ,username
        ,password
        ,createdate
        ,updatedate
        ,createby
        ,updateby)
        VALUES 
        (
         '{$emp_code}'
        , {$user_id}
        , {$app_id}
        ,'{$username}'
        ,'{$password_sso}'
        ,'{$datetime_now}'
        ,'{$datetime_now}'
        ,'{$user_create}'
        ,'{$user_create}')";

        $sql_user = DB::insert($sql);

        $datas = array();
        if (!empty($sql_user)) {
            $datas = $sql_user;
        }
        return $datas;
    }

    public static function edit_username_sso($user_id, $emp_code, $app_id, $username, $password_sso, $user_update)
    {
        $datetime_now = date('Y-m-d H:i:s');
        // $password = bcrypt($password);
        $sql_app = "
        SELECT * FROM sso
        WHERE app_id = {$app_id}
        AND user_id = {$user_id}";
        $sql_check_app = DB::select($sql_app);

        if (count($sql_check_app) == 1) {
            $sql = "UPDATE sso SET
             username = '{$username}'
            ,password = '{$password_sso}'
            ,updatedate = '{$datetime_now}'
            ,updateby   = '{$user_update}'
            WHERE user_id = {$user_id}
            AND app_id = {$app_id} 
            AND emp_code = '{$emp_code}'";

            $sql_user = DB::insert($sql);
        }
        if (count($sql_check_app) == 0) {
            $sql = "INSERT INTO sso 
            (emp_code
            ,user_id
            ,app_id
            ,username
            ,password
            ,createdate
            ,updatedate
            ,createby
            ,updateby)
            VALUES 
            (
             '{$emp_code}'
            , {$user_id}
            , {$app_id}
            ,'{$username}'
            ,'{$password_sso}'
            ,'{$datetime_now}'
            ,'{$datetime_now}'
            ,'{$user_update}'
            ,'{$user_update}')";
            $sql_user = DB::insert($sql);
        }


        $datas = array();
        if (!empty($sql_user)) {
            $datas = $sql_user;
        }
        return $datas;
    }

    public static function check_user($username, $password, $type)
    {
        $sql = "
        SELECT p.*,
        p.3cx as cx, 
        p.type as type_login,
        g.name_en as group_name_en,
        g.name_th as group_name_th 
        FROM users u
        INNER JOIN user_profile p
        ON u.user_id = p.user_id
        INNER JOIN application_group g
        ON p.group_id = g.group_id
        WHERE
        u.username = '{$username}'
        AND u.type = '{$type}'
        AND u.active = 1";

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
            foreach ($sql_user as $item) {
                $datas = array(
                    'access_token' => $token,
                    'username' => $username,
                    'token_type' => 'bearer',
                    'expires_in' => config('jwt.ttl'),
                    'user_id' => $item->user_id,
                    'emp_code' => $item->emp_code,
                    'username' => $username,
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
                    'image' => $item->image,
                    'status_permission' => $item->status_permission,
                    'admin_menu' => $item->admin_menu,
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
                    'data' => 'Validate Username or Password'
                ]
            ], 400);
        }

    }


    public static function check_register($emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_create, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone, $permission, $admin_menu, $app)
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

            foreach ($app as $item) {
                $app_id =  $item->app_id;
                $username =  $item->username;
                $password_sso =  $item->password;
                $user_sso = Users::create_username_sso($user_id, $emp_code, $app_id, $username, $password_sso, $user_create);
            }

            return response()->json([
                'success' => [
                    'data' => 'User Created'
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'data' => 'User type นี้มีการใช้งานเเล้ว (API : register)'
                ]
            ], 211);
        }
    }

    public static function update_user($user_id, $emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_update, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone, $permission, $admin_menu, $app)
    {
        $sql = "
        SELECT * FROM users WHERE
        user_id = {$user_id}
        AND active = 1";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 1) {
            $user = Users::edit_user($user_id, $emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_update);


            $user_profile = Users::edit_user_profile($user_id, $emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_update, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone, $permission, $admin_menu);

            foreach ($app as $item) {
                $app_id =  $item->app_id;
                $username =  $item->username;
                $password_sso =  $item->password;
                $user_sso = Users::edit_username_sso($user_id, $emp_code, $app_id, $username, $password_sso, $user_update);
            }

            return response()->json([
                'success' => [
                    'data' => 'User Updated'
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'data' => 'ไม่พบ user ที่จะแก้ไข'
                ]
            ], 400);
        }
    }

    public static function delete_user($user_id)
    {
        $sql = "
        SELECT * FROM users WHERE
        user_id = {$user_id}
        AND active = 1";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 1) {
            $sql_users = "
            UPDATE users SET
            active = 0
            WHERE user_id = {$user_id}";
            $users = DB::select($sql_users);

            $sql_users_profile = "
            UPDATE user_profile SET
            active = 0
            WHERE user_id = {$user_id}";
            $sql_user_profile = DB::select($sql_users_profile);

            return response()->json([
                'success' => [
                    'data' => 'User Deleted'
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'data' => 'ไม่พบ user ที่จะลบ ตรวจสอบ user_id (API : delete-user)'
                ]
            ], 212);
        }
    }

    public static function get_user_list($keyword, $field, $sort)
    {
        $search = '';
        $order_by = '';
        if ($keyword != '') {
            $search = "AND ((pro.name_th like '%{$keyword}%') OR (pro.name_en like '%{$keyword}%') OR (pro.emp_code like '%{$keyword}%'))";
        }
        if ($field != '') {
            $order_by = "ORDER BY {$field} {$sort}";
        } else {
            $order_by = "ORDER BY pro.emp_code";
        }
        $sql = "
        SELECT user.user_id
        ,user.emp_code
        ,user.username
        ,user.password
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
        ,pro.image
        ,pro.status_permission
        ,pro.admin_menu
        FROM users user
        JOIN user_profile pro 
        ON user.user_id=pro.user_id
        WHERE user.active = 1
        {$search}
        {$order_by}
        ";

        $sql_app = DB::select($sql);

        $datas = array();
        if (!empty($sql_app)) {
            $i = 0;
            foreach ($sql_app as $item) {
                $sql = "
                SELECT name_th as group_name_th, name_en as group_name_en
                FROM application_group
                WHERE group_id = {$item->group_id}";

                $sql_group_id = DB::select($sql);

                foreach ($sql_group_id as $item_gorup_id) {
                    $datas[] = array(
                        'index'  => $i,
                        'user_id' => $item->user_id,
                        'emp_code' => $item->emp_code,
                        'username' => $item->username,
                        'password' => $item->password,
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
                        'group_name_th' => $item_gorup_id->group_name_th,
                        'group_name_en' => $item_gorup_id->group_name_en,
                        'type_login' => $item->type_login,
                        'image' => $item->image,
                        'status_permission' => $item->status_permission,
                        'admin_menu' => $item->admin_menu,
                    );
                    $i++;
                }


                
            }
        }
        return $datas;
    }
}
