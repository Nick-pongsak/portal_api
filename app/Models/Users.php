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
        if ($type == 1) {
            $password = bcrypt($password);
        }
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
        if($password == 'LDAP'){
            $password = bcrypt($password);
        }
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
        $sql_id = "UPDATE users SET id = {$user_id} WHERE type = {$type} AND emp_code = '{$emp_code}' AND active = 1";
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
        $sql_order = "
        SELECT * FROM user_profile
        WHERE NOT(group_id = {$group_id})
        AND user_id = {$user_id}";

        $sql_or = DB::select($sql_order);
        if (!empty($sql_or)) {

            $sql_delete_order = "
            UPDATE user_setting SET
            app_order = '' 
            WHERE user_id = {$user_id}";

            $sql_delete = DB::insert($sql_delete_order);
        }

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
        ,updateby
        ,verify)
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
        ,'{$user_create}'
        , 0)";

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
            ,updateby
            ,verify)
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
            ,'{$user_update}'
            , 0)";
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
        u.username = '{$username}'
        AND u.type = '{$type}'
        AND u.active = 1
        AND pro.status = 1";

        $sql_user = DB::select($sql);




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
        u.username = '{$username}'
        AND u.type = '{$type}'
        AND u.active = 1
        AND pro.status = 1";

        $sql_language = DB::select($sql_language);

        if (count($sql_user) == 1 && count($sql_language) == 0) {
            $credentials = array('username' => $username, 'password' => $password, 'type' => $type, 'active' => 1);

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
                    'image' => ($item->image == '' ? '' : 'http://10.7.200.229/apiweb/images/user-profile/' . $item->image),
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
            $credentials = array('username' => $username, 'password' => $password, 'type' => $type, 'active' => 1);

            if (!$token = JwtAuth::attempt($credentials)) {
                return response()->json([
                    'error' => [
                        'data' => $credentials
                    ]
                ], 400);
            }
            foreach ($sql_language as $item) {
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
                    'image' => ($item->image == '' ? '' : 'http://10.7.200.229/apiweb/images/user-profile/' . $item->image),
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
        }else {
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
        (emp_code = '{$emp_code}'
        OR username = '{$username}')
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
                    'data' => 'ไม่สามารถบันทึกข้อมูลได้ เนื่องจากรหัสพนักงานหรือชื่อผู้ใช้งานนี้ ถูกใช้งานแล้ว'
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

        $sql_emp = "
        SELECT * FROM users WHERE
        emp_code = '{$emp_code}'
        AND type = {$type}
        AND active = 1";

        $sql_check_emp = DB::select($sql_emp);

        $sql_username = "
        SELECT * FROM users WHERE
        username = '{$username}'
        AND type = {$type}
        AND active = 1";

        $sql_check_username = DB::select($sql_username);

        if (count($sql_user) == 1) {
            if ($sql_user[0]->emp_code == $emp_code && $sql_user[0]->username == $username){
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
            }else{
                if ($sql_user[0]->emp_code == $emp_code && count($sql_check_username) == 0){
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
                }else if (count($sql_check_emp) == 0 && $sql_user[0]->username == $username){
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
                }else if (count($sql_check_emp) == 0 && count($sql_check_username) == 0){
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
                }else{
                    return response()->json([
                        'error' => [
                            'data' => 'ไม่สามารถแก้ไขได้เนื่องจาก emp_code หรือ username นี้มีการใช้งานเเล้วใน user(LDAP) หรือ user ในระบบ'
                        ]
                    ], 229);        
                }
            }
            
        } else {
            return response()->json([
                'error' => [
                    'data' => 'ไม่พบ user ที่ต้องการแก้ไข'
                ]
            ], 230);
        }
    }

    public static function update_profile($user_id, $name_th, $name_en, $postname_th, $postname_en, $email, $user_update, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone)
    {
        $sql = "
        SELECT * FROM users WHERE
        user_id = {$user_id}
        AND active = 1";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 1) {
            // $user = Users::edit_user($user_id, $emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_update);


            $user_profile = Users::edit_profile($user_id, $name_th, $name_en, $postname_th, $postname_en, $email, $user_update, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone);

            // foreach ($app as $item) {
            //     $app_id =  $item->app_id;
            //     $username =  $item->username;
            //     $password_sso =  $item->password;
            //     $user_sso = Users::edit_username_sso($user_id, $emp_code, $app_id, $username, $password_sso, $user_update);
            // }

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
            $search = "AND ((pro.name_th like '%{$keyword}%') OR 
            (pro.name_en like '%{$keyword}%') OR 
            (pro.emp_code like '%{$keyword}%') OR
            (pro.postname_th like '%{$keyword}%') OR
            (pro.postname_en like '%{$keyword}%') OR
            (gp.name_th like '%{$keyword}%') OR
            (gp.name_en like '%{$keyword}%')
            )";
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
        ,IFNULL(pro.image,'') as image
        ,pro.status_permission
        ,pro.admin_menu
        ,gp.name_th as group_name_th
        ,gp.name_en as group_name_en
        ,gp.active
        FROM users user
        JOIN user_profile pro 
        ON user.user_id=pro.user_id
        JOIN application_group gp
        ON pro.group_id=gp.group_id
        WHERE user.active = 1
        {$search}
        {$order_by}
        ";

        $sql_app = DB::select($sql);

        $datas = array();
        if (!empty($sql_app)) {
            $i = 0;
            foreach ($sql_app as $item) {
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
                        'group_name_th' => ($item->active == 0 ? '' : $item->group_name_th),
                        'group_name_en' => ($item->active == 0 ? '' : $item->group_name_en),
                        'type_login' => $item->type_login,
                        'image' => ($item->image == '' ? '' : 'http://10.7.200.229/apiweb/images/user-profile/' . $item->image),
                        'status_permission' => $item->status_permission,
                        'admin_menu' => $item->admin_menu,
                    );
                    $i++;
            }
        }
        return $datas;
    }

    public static function saveorder($user_id, $emp_code, $order)
    {
        $sql = "
        SELECT * FROM user_setting WHERE
        user_id = {$user_id}";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 1) {
            $datetime_now = date('Y-m-d H:i:s');
            $sql_users = "
            UPDATE user_setting SET
            app_order = '{$order}',
            updatedate = '{$datetime_now}',
            updateby = {$user_id}
            WHERE user_id = {$user_id}";
            $users = DB::select($sql_users);

            return response()->json([
                'success' => [
                    'data' => 'Save Success'
                ]
            ], 200);
        } else {

            $datetime_now = date('Y-m-d H:i:s');
            $sql = "
            INSERT INTO user_setting 
            (user_id
            ,emp_code
            ,app_order
            ,createdate
            ,updatedate
            ,createby
            ,updateby
            ,language)
            VALUES 
            ({$user_id}
            ,'{$emp_code}'
            ,'{$order}'
            ,'{$datetime_now}'
            ,'{$datetime_now}'
            ,{$user_id}
            ,{$user_id}
            ,'th')";

            $sql_user = DB::insert($sql);
            return response()->json([
                'success' => [
                    'data' => 'Save Success'
                ]
            ], 200);
        }
    }


    public static function upload_img($user_id, $image)
    {
        $sql = "
        SELECT * FROM user_profile WHERE
        user_id = {$user_id}
        AND active = 1";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 1) {
            $datetime_now = date('Y-m-d H:i:s');
            $sql_users = "
            UPDATE user_profile SET
            image = '{$image}',
            updatedate = '{$datetime_now}',
            updateby = {$user_id}
            WHERE user_id = {$user_id}";
            $users = DB::select($sql_users);

            return response()->json([
                'success' => [
                    'data' => 'http://10.7.200.229/apiweb/images/user-profile/' . $image
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'data' => 'ไม่พบ user_id ที่ต้องการ upload image'
                ]
            ], 223);
        }
    }

    public static function delimg($user_id)
    {
        $sql = "
        SELECT * FROM user_profile WHERE
        user_id = {$user_id}
        AND active = 1";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 1) {
            $datetime_now = date('Y-m-d H:i:s');
            $sql_users = "
            UPDATE user_profile SET
            image = '',
            updatedate = '{$datetime_now}',
            updateby = {$user_id}
            WHERE user_id = {$user_id}";
            $users = DB::select($sql_users);

            return response()->json([
                'success' => [
                    'data' => 'Image Deleted'
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'data' => 'ไม่พบ user_id ที่ต้องการ delete image'
                ]
            ], 224);
        }
    }

    public static function edit_profile($user_id, $name_th, $name_en, $postname_th, $postname_en, $email, $user_update, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone)
    {
        // $sql_order = "
        // SELECT * FROM user_profile
        // WHERE NOT(group_id = {$group_id})
        // AND user_id = {$user_id}";

        // $sql_or = DB::select($sql_order);
        // if(!empty($sql_or)){

        //     $sql_delete_order = "
        //     UPDATE user_setting SET
        //     app_order = '' 
        //     WHERE user_id = {$user_id}";

        //     $sql_delete = DB::insert($sql_delete_order);

        // }

        $datetime_now = date('Y-m-d H:i:s');

        $sql = "UPDATE user_profile SET
         name_th  = '{$name_th}'
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
        ,updatedate = '{$datetime_now}'
        ,updateby   = '{$user_update}'
        WHERE user_id = {$user_id}";

        $sql_user = DB::insert($sql);

        $datas = array();
        if (!empty($sql_user)) {
            $datas = $sql_user;
        }
        return $datas;
    }

    public static function decrypt_crypto($ciphertext, $password) {
        $ciphertext = base64_decode($ciphertext);
        if (substr($ciphertext, 0, 8) != "Salted__") {
            return false;
        }
        $salt = substr($ciphertext, 8, 8);
        $keyAndIV = Users::evpKDF($password, $salt);
        $decryptPassword = openssl_decrypt(
            substr($ciphertext, 16),
            "aes-256-cbc",
            $keyAndIV["key"],
            OPENSSL_RAW_DATA, // base64 was already decoded
            $keyAndIV["iv"]);
        return $decryptPassword;
    }

    public static function evpKDF($password, $salt, $keySize = 8, $ivSize = 4, $iterations = 1, $hashAlgorithm = "md5") {
        $targetKeySize = $keySize + $ivSize;
        $derivedBytes = "";
        $numberOfDerivedWords = 0;
        $block = NULL;
        $hasher = hash_init($hashAlgorithm);
        while ($numberOfDerivedWords < $targetKeySize) {
            if ($block != NULL) {
                hash_update($hasher, $block);
            }
            hash_update($hasher, $password);
            hash_update($hasher, $salt);
            $block = hash_final($hasher, TRUE);
            $hasher = hash_init($hashAlgorithm);
            // Iterations
            for ($i = 1; $i < $iterations; $i++) {
                hash_update($hasher, $block);
                $block = hash_final($hasher, TRUE);
                $hasher = hash_init($hashAlgorithm);
            }
            $derivedBytes .= substr($block, 0, min(strlen($block), ($targetKeySize - $numberOfDerivedWords) * 4));
            $numberOfDerivedWords += strlen($block)/4;
        }
        return array(
            "key" => substr($derivedBytes, 0, $keySize * 4),
            "iv"  => substr($derivedBytes, $keySize * 4, $ivSize * 4)
        );
    }

    public static function update_username_sso($user_id, $emp_code, $app_id, $username, $user_update)
    {
            $sql = "
            SELECT * FROM sso WHERE
            user_id = {$user_id}
            AND app_id = {$app_id}
            AND emp_code = '{$emp_code}'";

            $sql_user = DB::select($sql);

            $sql_user_id = "
            SELECT * FROM users WHERE
            user_id = {$user_id}
            AND active = 1";

            $sql_user_id = DB::select($sql_user_id);

            if (count($sql_user) == 1 && count($sql_user_id) == 1) {
                $datetime_now = date('Y-m-d H:i:s');
                $sql = "
                UPDATE sso SET
                username = '{$username}',
                verify   = 1,
                updateby = '{$user_update}',
                updatedate = '{$datetime_now}'
                WHERE
                user_id = {$user_id}
                AND app_id = {$app_id}
                AND emp_code = '{$emp_code}'";
    
                $sql_user = DB::select($sql);

                return response()->json([
                    'success' => [
                        'data' => 'update username sso success',
                    ]
                ], 200);
                
            } else if (count($sql_user) == 0 && count($sql_user_id) == 1) {
                $datetime_now = date('Y-m-d H:i:s');
                $sql = "INSERT INTO sso 
                (emp_code
                ,user_id
                ,app_id
                ,username
                ,password
                ,createdate
                ,updatedate
                ,createby
                ,updateby
                ,verify)
                VALUES 
                (
                 '{$emp_code}'
                , {$user_id}
                , {$app_id}
                ,'{$username}'
                ,''
                ,'{$datetime_now}'
                ,'{$datetime_now}'
                ,'{$user_update}'
                ,'{$user_update}'
                , 1)";
                $sql_user = DB::insert($sql);

                return response()->json([
                    'success' => [
                        'data' => 'update username sso success',
                    ]
                ], 200);

            } else {
                return response()->json([
                    'error' => [
                        'data' => 'ไม่พบ user ที่ต้องการเพิ่ม/แก้ไข username',
                    ]
                ], 227);
            }
    }

    public static function update_language($user_id, $emp_code, $language, $user_update)
    {
        $sql = "
        SELECT * FROM user_setting WHERE
        user_id = {$user_id}";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 1) {
            $datetime_now = date('Y-m-d H:i:s');
            $sql_users = "
            UPDATE user_setting SET
            language = '{$language}',
            updatedate = '{$datetime_now}',
            updateby = {$user_id}
            WHERE user_id = {$user_id}";
            $users = DB::select($sql_users);

            return response()->json([
                'success' => [
                    'data' => 'Save Success'
                ]
            ], 200);
        } else {

            $datetime_now = date('Y-m-d H:i:s');
            $sql = "
            INSERT INTO user_setting 
            (user_id
            ,emp_code
            ,app_order
            ,createdate
            ,updatedate
            ,createby
            ,updateby
            ,language)
            VALUES 
            ({$user_id}
            ,'{$emp_code}'
            ,'0'
            ,'{$datetime_now}'
            ,'{$datetime_now}'
            ,{$user_id}
            ,{$user_id}
            ,'{$language}')";

            $sql_user = DB::insert($sql);
            return response()->json([
                'success' => [
                    'data' => 'Save Success'
                ]
            ], 200);
        }
    }

    public static function insert_temporary(
    $type, $emp_code, $name_th, 
    $name_en, $postname_th, $postname_en, 
    $email, $cx, $group_id, 
    $username, $password, 
    $status,$user_create,
    $data_status,$note)
    {
        if($type == ''){
            $type = -1;
        }else{
            if($type != '0' && $type != '1'){
                $type = -1;
            }
        }

        if($status == ''){
            $status = -1;
        }else{
            if($status != '0' && $status != '1'){
                $status = -1;
            }
        }

        if($group_id == ''){
            $group_id = -1;
        }else{
            if(!ctype_digit($group_id)){
                $group_id = -1;
            }else{
                $sql_group_id = "
                SELECT * FROM application_group
                WHERE group_id = {$group_id}
                AND active = 1";
                $check_group_id = DB::select($sql_group_id);
        
                if(count($check_group_id) == 0){
                    $group_id = -1;
                }
            }
        }
        $datetime_now = date('Y-m-d H:i:s');
        $sql = "
        INSERT INTO temporary 
        (type
        ,emp_code,name_th,name_en
        ,postname_th,postname_en,email
        ,3cx,group_id,username,password,phone
        ,status_permission,admin_menu,status
        ,nickname1_th,nickname1_en
        ,nickname2_th,nickname2_en
        ,createdate,updatedate,createby,updateby
        ,active,data_status,note)
        VALUES 
        ( {$type}
        ,'{$emp_code}'
        ,'{$name_th}'
        ,'{$name_en}'
        ,'{$postname_th}'
        ,'{$postname_en}'
        ,'{$email}'
        ,'{$cx}'
        , {$group_id}
        ,'{$username}'
        ,'{$password}'
        ,''
        , 0
        , 0
        , {$status}
        ,''
        ,''
        ,''
        ,''
        ,'{$datetime_now}'
        ,'{$datetime_now}'
        ,'{$user_create}'
        ,'{$user_create}'
        , 1
        , {$data_status}
        ,'{$note}'
        )";

        $sql_user = DB::insert($sql);
            
    }

    public static function update_temporary(
        $type, $emp_code, $name_th, 
        $name_en, $postname_th, $postname_en, 
        $email, $cx, $group_id, 
        $username, $password, 
        $status,$user_create,
        $data_status,$note)
        {
            // $datetime_now = date('Y-m-d H:i:s');
            $sql = "
            UPDATE temporary SET
            data_status = {$data_status},
            note = '{$note}'
            WHERE emp_code = '{$emp_code}' 
            AND type = '{$type}' 
            AND createby = '{$user_create}'
            AND status = '{$status}'";
    
            $sql_user = DB::insert($sql);
                
        }

    public static function delete_temporary($user_id)
    {
        $sql = " DELETE FROM temporary WHERE createby = '{$user_id}'";
        $delete_temporary = DB::select($sql);
            
    }

    public static function checkdata_status($type, $emp_code, $name_th, 
    $name_en, $postname_th, $postname_en, 
    $email, $cx, $group_id, 
    $username, $password, 
    $status,$user_create)
    {
        // 0 = error
        // 1 = new
        // 2 = update
        if ($type == '' || $emp_code == ''){
            return 0;
        }else{
            if($type != '0' && $type != '1'){
                return 0;
            }
            if($status != ''){
                if($status != '0' && $status != '1'){
                    return 0;
                }
            }
            $sql = "
            SELECT *, 3cx as cx FROM user_profile
            WHERE emp_code = '{$emp_code}'
            AND type = {$type}
            AND active = 1";
            $check_user_profile = DB::select($sql);

            $sql_user = "
            SELECT * FROM users
            WHERE emp_code = '{$emp_code}'
            AND type = {$type}
            AND active = 1";
            $check_user = DB::select($sql_user);
    
            if($group_id != ''){
                if(!ctype_digit($group_id)){
                    return 0;
                }else{
                    $sql_group_id = "
                    SELECT * FROM application_group
                    WHERE group_id = {$group_id}
                    AND active = 1";
                    $check_group_id = DB::select($sql_group_id);
            
                    if(count($check_group_id) == 0){
                        return 0;
                    }
                }
            }
            
            if(count($check_user_profile) == 0 && count($check_user) == 0){
                if ($type == 0){
                    if(
                        $type == '' ||
                        $emp_code =='' ||
                        $name_th == '' ||
                        $name_en == '' ||
                        $postname_th == '' ||
                        $postname_en == '' ||
                        // $email  == ''
                        // $cx == ''
                        $group_id == '' ||
                        $username  == '' ||
                        $password == '' ||
                        $status == '' ||
                        $user_create  == ''
                    ){
                        return 0;
                    }else{
                        $sql_username = "
                        SELECT * FROM users
                        WHERE username = '{$username}'
                        AND type = {$type}
                        AND active = 1";
                        $check_username = DB::select($sql_username);

                        $sql_username_temp = "
                        SELECT * FROM temporary
                        WHERE username = '{$username}'
                        AND type = {$type}
                        AND createby = '{$user_create}'";
                        $check_username_temp = DB::select($sql_username_temp);

                        if(count($check_username) != 0 || count($check_username_temp) != 0){
                            return 0;
                        }else{
                            return 1;
                        }
                    }
                }
                if ($type == 1){
                    $username_ldap = Users::searchLDAP($emp_code);
                    if($username_ldap == ''){
                        return 0;
                    }

                    if(
                        $type == '' ||
                        $emp_code =='' ||
                        $name_th == '' ||
                        $name_en == '' ||
                        $postname_th == '' ||
                        $postname_en == '' ||
                        $email  == '' ||
                        // $cx == ''
                        $group_id == '' ||
                        // $username  == '' ||
                        // $password == '' ||
                        $status == '' ||
                        $user_create  == ''
                    ){
                        return 0;
                    }else if(
                        $username  != '' ||
                        $password  != '' 
                    ){
                        return 0;
                    }else{
                        return 1;
                    }
                }
            } else {
                if ($type == 0){
                    $hash = $check_user[0]->password;
                    $sh = 0;
                    if(password_verify($password, $hash)){
                        $sh = 1;
                    }
                    if(
                        $type != '' &&
                        $emp_code !='' &&
                        $user_create  == ''
                    ){
                        return 0;
                    }else if(
                        (($type == $check_user_profile[0]->type) &&
                        ($emp_code == $check_user_profile[0]->emp_code) &&
                        ($name_th == '' || ($name_th == $check_user_profile[0]->name_th)) &&
                        ($name_en == '' || ($name_en == $check_user_profile[0]->name_en)) &&
                        ($postname_th == '' || ($postname_th == $check_user_profile[0]->postname_th)) &&
                        ($postname_en == '' || ($postname_en == $check_user_profile[0]->postname_en)) &&
                        ($email  == '' || ($email  == $check_user_profile[0]->email)) &&
                        ($cx == '' || ($cx == $check_user_profile[0]->cx)) &&
                        ($group_id == '' || ($group_id == $check_user_profile[0]->group_id)) &&
                        ($username  == '' || ($username  == $check_user[0]->username)) &&
                        ($password == '' || ($sh == 1)) &&
                        ($status == '' || ($status == $check_user_profile[0]->status)))
                    ){
                        return 0;
                    }else{
                        if(($username  == '' || ($username  == $check_user[0]->username))){
                            return 2;
                        }else{
                            $sql_username = "
                            SELECT * FROM users
                            WHERE username = '{$username}'
                            AND type = {$type}
                            AND active = 1";
                            $check_username = DB::select($sql_username);
    
                            $sql_username_temp = "
                            SELECT * FROM temporary
                            WHERE username = '{$username}'
                            AND type = {$type}
                            AND createby = '{$user_create}'";
                            $check_username_temp = DB::select($sql_username_temp);
                            if(count($check_username) == 0 && count($check_username_temp) ==0 ){
                                return 2;
                            }else{
                                return 0;
                            }
                            
                        }
                    }

                }
                if ($type == 1){
                    if(
                        $type != '' &&
                        $emp_code !='' &&
                        $user_create  == ''
                    ){
                        return 0;
                    }else if(
                        $username  != '' ||
                        $password  != ''
                    ){
                        return 0;
                    }else if(
                        (($type == $check_user_profile[0]->type) &&
                        ($emp_code == $check_user_profile[0]->emp_code) &&
                        ($name_th == '' || ($name_th == $check_user_profile[0]->name_th)) &&
                        ($name_en == '' || ($name_en == $check_user_profile[0]->name_en)) &&
                        ($postname_th == '' || ($postname_th == $check_user_profile[0]->postname_th)) &&
                        ($postname_en == '' || ($postname_en == $check_user_profile[0]->postname_en)) &&
                        ($email  == '' || ($email  == $check_user_profile[0]->email)) &&
                        ($cx == '' || ($cx == $check_user_profile[0]->cx)) &&
                        ($group_id == '' || ($group_id == $check_user_profile[0]->group_id)) &&
                        ($status == '' || ($status == $check_user_profile[0]->status)))
                    ){
                        return 0;
                    }else{
                        return 2;
                    }
                }
            }           
        }

        
            
    }

    public static function checkdata_status_update($type, $emp_code, $name_th, 
    $name_en, $postname_th, $postname_en, 
    $email, $cx, $group_id, 
    $username, $password, 
    $status,$user_create)
    {
        // 0 = error
        // 1 = new
        // 2 = update
        if ($type == -1 || $emp_code == ''){
            return 0;
        }else{
            if($type != '0' && $type != '1'){
                return 0;
            }
            if($status != -1){
                if($status != '0' && $status != '1'){
                    return 0;
                }
            }
            $sql = "
            SELECT *, 3cx as cx FROM user_profile
            WHERE emp_code = '{$emp_code}'
            AND type = {$type}
            AND active = 1";
            $check_user_profile = DB::select($sql);

            $sql_user = "
            SELECT * FROM users
            WHERE emp_code = '{$emp_code}'
            AND type = {$type}
            AND active = 1";
            $check_user = DB::select($sql_user);

            if($group_id != -1){
                $sql_group_id = "
                SELECT * FROM application_group
                WHERE group_id = {$group_id}
                AND active = 1";
                $check_group_id = DB::select($sql_group_id);
        
                if(count($check_group_id) == 0){
                    return 0;
                }
            }
    
            if(count($check_user_profile) == 0 && count($check_user) == 0){
                if ($type == 0){
                    if(
                        $type == -1 ||
                        $emp_code =='' ||
                        $name_th == '' ||
                        $name_en == '' ||
                        $postname_th == '' ||
                        $postname_en == '' ||
                        // $email  == ''
                        // $cx == ''
                        $group_id == -1 ||
                        $username  == '' ||
                        $password == '' ||
                        $status == -1 ||
                        $user_create  == ''
                    ){
                        return 0;
                    }else{
                        $sql_username = "
                        SELECT * FROM users
                        WHERE username = '{$username}'
                        AND type = {$type}
                        AND active = 1";
                        $check_username = DB::select($sql_username);

                        if(count($check_username) != 0){
                            return 0;
                        }else{
                            return 1;
                        }
                    }
                }
                if ($type == 1){
                    $username_ldap = Users::searchLDAP($emp_code);
                    if($username_ldap == ''){
                        return 0;
                    }

                    if(
                        $type == -1 ||
                        $emp_code =='' ||
                        $name_th == '' ||
                        $name_en == '' ||
                        $postname_th == '' ||
                        $postname_en == '' ||
                        $email  == '' ||
                        // $cx == ''
                        $group_id == -1 ||
                        // $username  == '' ||
                        // $password == '' ||
                        $status == -1 ||
                        $user_create  == ''
                    ){
                        return 0;
                    }else if(
                        $username  != '' ||
                        $password  != '' 
                    ){
                        return 0;
                    }else{
                        return 1;
                    }
                }
            } else {
                if ($type == 0){
                    $hash = $check_user[0]->password;
                    $sh = 0;
                    if(password_verify($password, $hash)){
                        $sh = 1;
                    }
                    if(
                        $type != -1 &&
                        $emp_code !='' &&
                        $user_create  == ''

                    ){
                        return 0;
                    }else if(
                        (($type == $check_user_profile[0]->type) &&
                        ($emp_code == $check_user_profile[0]->emp_code) &&
                        ($name_th == '' || ($name_th == $check_user_profile[0]->name_th)) &&
                        ($name_en == '' || ($name_en == $check_user_profile[0]->name_en)) &&
                        ($postname_th == '' || ($postname_th == $check_user_profile[0]->postname_th)) &&
                        ($postname_en == '' || ($postname_en == $check_user_profile[0]->postname_en)) &&
                        ($email  == '' || ($email  == $check_user_profile[0]->email)) &&
                        ($cx == '' || ($cx == $check_user_profile[0]->cx)) &&
                        ($group_id == -1 || ($group_id == $check_user_profile[0]->group_id)) &&
                        ($username  == '' || ($username  == $check_user[0]->username)) &&
                        ($password == '' || ($sh == 1)) &&
                        ($status == -1 || ($status == $check_user_profile[0]->status)))
                    ){
                        return 0;
                    }else{
                        if(($username  == '' || ($username  == $check_user[0]->username))){
                            return 2;
                        }else{
                            $sql_username = "
                            SELECT * FROM users
                            WHERE username = '{$username}'
                            AND type = {$type}
                            AND active = 1";
                            $check_username = DB::select($sql_username);

                            if(count($check_username) == 0){
                                return 2;
                            }else{
                                return 0;
                            }
                            
                        }
                    }

                }
                if ($type == 1){
                    if(
                        $type != -1 &&
                        $emp_code !='' &&
                        $user_create  == ''
                    ){
                        return 0;
                    }else if(
                        $username  != '' ||
                        $password  != ''
                    ){
                        return 0;
                    }else if(
                        (($type == $check_user_profile[0]->type) &&
                        ($emp_code == $check_user_profile[0]->emp_code) &&
                        ($name_th == '' || ($name_th == $check_user_profile[0]->name_th)) &&
                        ($name_en == '' || ($name_en == $check_user_profile[0]->name_en)) &&
                        ($postname_th == '' || ($postname_th == $check_user_profile[0]->postname_th)) &&
                        ($postname_en == '' || ($postname_en == $check_user_profile[0]->postname_en)) &&
                        ($email  == '' || ($email  == $check_user_profile[0]->email)) &&
                        ($cx == '' || ($cx == $check_user_profile[0]->cx)) &&
                        ($group_id == -1 || ($group_id == $check_user_profile[0]->group_id)) &&
                        ($status == -1 || ($status == $check_user_profile[0]->status)))
                    ){
                        return 0;
                    }else{
                        return 2;
                    }
                }
            }           
        }

        
            
    }

    public static function checkerror_note($type, $emp_code, $name_th, 
    $name_en, $postname_th, $postname_en, 
    $email, $cx, $group_id, 
    $username, $password, 
    $status,$user_create)
    {
        if ($type == '' || $emp_code == ''){
            return 'ข้อมูลไม่ถูกต้อง';
        }else{
            if($type != '0' && $type != '1'){
                return 'ข้อมูลไม่ถูกต้อง';
            }
            if($status != ''){
                if($status != '0' && $status != '1'){
                    return 'ข้อมูลไม่ถูกต้อง';
                }
            }
            $sql = "
            SELECT *, 3cx as cx FROM user_profile
            WHERE emp_code = '{$emp_code}'
            AND type = {$type}
            AND active = 1";
            $check_user_profile = DB::select($sql);

            $sql_user = "
            SELECT * FROM users
            WHERE emp_code = '{$emp_code}'
            AND type = {$type}
            AND active = 1";
            $check_user = DB::select($sql_user);
    
            if($group_id != ''){
                if(!ctype_digit($group_id)){
                    return 'ข้อมูลไม่ถูกต้อง';
                }else{
                    $sql_group_id = "
                    SELECT * FROM application_group
                    WHERE group_id = {$group_id}
                    AND active = 1";
                    $check_group_id = DB::select($sql_group_id);
            
                    if(count($check_group_id) == 0){
                        return 'ข้อมูลไม่ถูกต้อง';
                    }
                }
            }
            
            if(count($check_user_profile) == 0 && count($check_user) == 0){
                if ($type == 0){
                    if(
                        $type == '' ||
                        $emp_code =='' ||
                        $name_th == '' ||
                        $name_en == '' ||
                        $postname_th == '' ||
                        $postname_en == '' ||
                        // $email  == ''
                        // $cx == ''
                        $group_id == '' ||
                        $username  == '' ||
                        $password == '' ||
                        $status == '' ||
                        $user_create  == ''
                    ){
                        return 'ข้อมูลผู้ใช้งานใหม่ไม่ถูกต้อง';
                    }else{
                        $sql_username = "
                        SELECT * FROM users
                        WHERE username = '{$username}'
                        AND type = {$type}
                        AND active = 1";
                        $check_username = DB::select($sql_username);

                        $sql_username_temp = "
                        SELECT * FROM temporary
                        WHERE username = '{$username}'
                        AND type = {$type}
                        AND createby = '{$user_create}'";
                        $check_username_temp = DB::select($sql_username_temp);

                        if(count($check_username) != 0 || count($check_username_temp) != 0){
                            return 'ข้อมูลไม่ถูกต้อง';
                        }else{
                            return 'new user';
                        }
                    }
                }
                if ($type == 1){
                    $username_ldap = Users::searchLDAP($emp_code);
                    if($username_ldap == ''){
                        return 'ข้อมูลผู้ใช้งานใหม่ไม่ถูกต้อง';
                    }

                    if(
                        $type == '' ||
                        $emp_code =='' ||
                        $name_th == '' ||
                        $name_en == '' ||
                        $postname_th == '' ||
                        $postname_en == '' ||
                        $email  == '' ||
                        // $cx == ''
                        $group_id == '' ||
                        // $username  == '' ||
                        // $password == '' ||
                        $status == '' ||
                        $user_create  == ''
                    ){
                        return 'ข้อมูลผู้ใช้งานใหม่ไม่ถูกต้อง';
                    }else if(
                        $username  != '' ||
                        $password  != '' 
                    ){
                        return 'ข้อมูลผู้ใช้งานใหม่ไม่ถูกต้อง';
                    }else{
                        return 'new user LDAP';
                    }
                }
            } else {
                if ($type == 0){
                    $hash = $check_user[0]->password;
                    $sh = 0;
                    if(password_verify($password, $hash)){
                        $sh = 1;
                    }
                    if(
                        $type != '' &&
                        $emp_code !='' &&
                        $user_create  == ''
                    ){
                        return 'ไม่สามารถอัปเดตข้อมูลได้';
                    }else if(
                        (($type == $check_user_profile[0]->type) &&
                        ($emp_code == $check_user_profile[0]->emp_code) &&
                        ($name_th == '' || ($name_th == $check_user_profile[0]->name_th)) &&
                        ($name_en == '' || ($name_en == $check_user_profile[0]->name_en)) &&
                        ($postname_th == '' || ($postname_th == $check_user_profile[0]->postname_th)) &&
                        ($postname_en == '' || ($postname_en == $check_user_profile[0]->postname_en)) &&
                        ($email  == '' || ($email  == $check_user_profile[0]->email)) &&
                        ($cx == '' || ($cx == $check_user_profile[0]->cx)) &&
                        ($group_id == '' || ($group_id == $check_user_profile[0]->group_id)) &&
                        ($username  == '' || ($username  == $check_user[0]->username)) &&
                        ($password == '' || ($sh == 1)) &&
                        ($status == '' || ($status == $check_user_profile[0]->status)))
                    ){
                        return 'ไม่พบข้อมูลที่ต้องการอัปเดต';
                    }else{
                        if(($username  == '' || ($username  == $check_user[0]->username))){
                            return 'update user';
                        }else{
                            $sql_username = "
                            SELECT * FROM users
                            WHERE username = '{$username}'
                            AND type = {$type}
                            AND active = 1";
                            $check_username = DB::select($sql_username);
    
                            $sql_username_temp = "
                            SELECT * FROM temporary
                            WHERE username = '{$username}'
                            AND type = {$type}
                            AND createby = '{$user_create}'";
                            $check_username_temp = DB::select($sql_username_temp);
                            if(count($check_username) == 0 && count($check_username_temp) ==0 ){
                                return 'update user';
                            }else{
                                return 'ข้อมูลไม่ถูกต้อง';
                            }
                            
                        }
                    }
                }
                if ($type == 1){
                    if(
                        $type != '' &&
                        $emp_code !='' &&
                        $user_create  == ''
                    ){
                        return 'ไม่สามารถอัปเดตข้อมูลได้';
                    }else if(
                        $username  != '' ||
                        $password  != ''
                    ){
                        return 'ไม่สามารถอัปเดตข้อมูล Username&Password';
                    }else if(
                        (($type == $check_user_profile[0]->type) &&
                        ($emp_code == $check_user_profile[0]->emp_code) &&
                        ($name_th == '' || ($name_th == $check_user_profile[0]->name_th)) &&
                        ($name_en == '' || ($name_en == $check_user_profile[0]->name_en)) &&
                        ($postname_th == '' || ($postname_th == $check_user_profile[0]->postname_th)) &&
                        ($postname_en == '' || ($postname_en == $check_user_profile[0]->postname_en)) &&
                        ($email  == '' || ($email  == $check_user_profile[0]->email)) &&
                        ($cx == '' || ($cx == $check_user_profile[0]->cx)) &&
                        ($group_id == '' || ($group_id == $check_user_profile[0]->group_id)) &&
                        ($status == '' || ($status == $check_user_profile[0]->status)))
                    ){
                        return 'ไม่พบข้อมูลที่ต้องการอัปเดต';
                    }else{
                        return 'update user LDAP';
                    }
                }
            }
        }

        
            
    }

    public static function checkerror_note_update($type, $emp_code, $name_th, 
    $name_en, $postname_th, $postname_en, 
    $email, $cx, $group_id, 
    $username, $password, 
    $status,$user_create)
    {
        if ($type == -1 || $emp_code == ''){
            return 'ข้อมูลไม่ถูกต้อง';
        }else{
            if($type != '0' && $type != '1'){
                return 'ข้อมูลไม่ถูกต้อง';
            }
            if($status != -1){
                if($status != '0' && $status != '1'){
                    return 'ข้อมูลไม่ถูกต้อง';
                }
            }
            $sql = "
            SELECT *, 3cx as cx FROM user_profile
            WHERE emp_code = '{$emp_code}'
            AND type = {$type}
            AND active = 1";
            $check_user_profile = DB::select($sql);

            $sql_user = "
            SELECT * FROM users
            WHERE emp_code = '{$emp_code}'
            AND type = {$type}
            AND active = 1";
            $check_user = DB::select($sql_user);

            if($group_id != -1){
                $sql_group_id = "
                SELECT * FROM application_group
                WHERE group_id = {$group_id}
                AND active = 1";
                $check_group_id = DB::select($sql_group_id);
        
                if(count($check_group_id) == 0){
                    return 'ข้อมูลไม่ถูกต้อง';
                }            
            }
    
            if(count($check_user_profile) == 0 && count($check_user) == 0){
                if ($type == 0){
                    if(
                        $type == -1 ||
                        $emp_code =='' ||
                        $name_th == '' ||
                        $name_en == '' ||
                        $postname_th == '' ||
                        $postname_en == '' ||
                        // $email  == ''
                        // $cx == ''
                        $group_id == -1 ||
                        $username  == '' ||
                        $password == '' ||
                        $status == -1 ||
                        $user_create  == ''
                    ){
                        return 'ข้อมูลผู้ใช้งานใหม่ไม่ถูกต้อง';
                    }else{
                        $sql_username = "
                        SELECT * FROM users
                        WHERE username = '{$username}'
                        AND type = {$type}
                        AND active = 1";
                        $check_username = DB::select($sql_username);

                        if(count($check_username) != 0){
                            return 'ข้อมูลไม่ถูกต้อง';
                        }else{
                            return 'new user';
                        }
                    }
                }
                if ($type == 1){
                    $username_ldap = Users::searchLDAP($emp_code);
                    if($username_ldap == ''){
                        return 'ข้อมูลผู้ใช้งานใหม่ไม่ถูกต้อง';
                    }

                    if(
                        $type == -1 ||
                        $emp_code =='' ||
                        $name_th == '' ||
                        $name_en == '' ||
                        $postname_th == '' ||
                        $postname_en == '' ||
                        $email  == '' ||
                        // $cx == ''
                        $group_id == -1 ||
                        // $username  == '' ||
                        // $password == '' ||
                        $status == -1 ||
                        $user_create  == ''
                    ){
                        return 'ข้อมูลผู้ใช้งานใหม่ไม่ถูกต้อง';
                    }else if(
                        $username  != '' ||
                        $password  != '' 
                    ){
                        return 'ข้อมูลผู้ใช้งานใหม่ไม่ถูกต้อง';
                    }else{
                        return 'new user LDAP';
                    }
                }
            } else {
                if ($type == 0){
                    $hash = $check_user[0]->password;
                    $sh = 0;
                    if(password_verify($password, $hash)){
                        $sh = 1;
                    }
                    if(
                        $type != -1 &&
                        $emp_code !='' &&
                        $user_create  == ''
                    ){
                        return 'ไม่สามารถอัปเดตข้อมูลได้';
                    }else if(
                        (($type == $check_user_profile[0]->type) &&
                        ($emp_code == $check_user_profile[0]->emp_code) &&
                        ($name_th == '' || ($name_th == $check_user_profile[0]->name_th)) &&
                        ($name_en == '' || ($name_en == $check_user_profile[0]->name_en)) &&
                        ($postname_th == '' || ($postname_th == $check_user_profile[0]->postname_th)) &&
                        ($postname_en == '' || ($postname_en == $check_user_profile[0]->postname_en)) &&
                        ($email  == '' || ($email  == $check_user_profile[0]->email)) &&
                        ($cx == '' || ($cx == $check_user_profile[0]->cx)) &&
                        ($group_id == -1 || ($group_id == $check_user_profile[0]->group_id)) &&
                        ($username  == '' || ($username  == $check_user[0]->username)) &&
                        ($password == '' || ($sh == 1)) &&
                        ($status == -1 || ($status == $check_user_profile[0]->status)))
                    ){
                        return 'ไม่พบข้อมูลที่ต้องการอัปเดต';
                    }else{
                        if(($username  == '' || ($username  == $check_user[0]->username))){
                            return 'update user';
                        }else{
                            $sql_username = "
                            SELECT * FROM users
                            WHERE username = '{$username}'
                            AND type = {$type}
                            AND active = 1";
                            $check_username = DB::select($sql_username);

                            if(count($check_username) == 0){
                                return 'update user';
                            }else{
                                return 'ข้อมูลไม่ถูกต้อง';
                            }
                            
                        }
                    }

                }
                if ($type == 1){
                    if(
                        $type != -1 &&
                        $emp_code !='' &&
                        $user_create  == ''
                    ){
                        return 'ไม่สามารถอัปเดตข้อมูลได้';
                    }else if(
                        $username  != '' ||
                        $password  != ''
                    ){
                        return 'ไม่สามารถอัปเดตข้อมูล Username&Password';
                    }else if(
                        (($type == $check_user_profile[0]->type) &&
                        ($emp_code == $check_user_profile[0]->emp_code) &&
                        ($name_th == '' || ($name_th == $check_user_profile[0]->name_th)) &&
                        ($name_en == '' || ($name_en == $check_user_profile[0]->name_en)) &&
                        ($postname_th == '' || ($postname_th == $check_user_profile[0]->postname_th)) &&
                        ($postname_en == '' || ($postname_en == $check_user_profile[0]->postname_en)) &&
                        ($email  == '' || ($email  == $check_user_profile[0]->email)) &&
                        ($cx == '' || ($cx == $check_user_profile[0]->cx)) &&
                        ($group_id == -1 || ($group_id == $check_user_profile[0]->group_id)) &&
                        ($status == -1 || ($status == $check_user_profile[0]->status)))
                    ){
                        return 'ไม่พบข้อมูลที่ต้องการอัปเดต';
                    }else{
                        return 'update user LDAP';
                    }
                }
            }
        }

        
            
    }

    public static function get_temporary_new($keyword, $field, $sort, $user_id)
    {
        $search = '';
        $order_by = '';
        if ($keyword != '') {
            $search = "AND ((temp.name_th like '%{$keyword}%') OR 
            (temp.name_en like '%{$keyword}%') OR 
            (temp.emp_code like '%{$keyword}%') OR
            (temp.postname_th like '%{$keyword}%') OR
            (temp.postname_en like '%{$keyword}%') OR
            (gp.name_th like '%{$keyword}%') OR
            (gp.name_en like '%{$keyword}%')
            )";
        }
        if ($field != '') {
            $order_by = "ORDER BY {$field} {$sort}";
        } else {
            $order_by = "ORDER BY temp.emp_code";
        }
        $sql_new = "
        SELECT 
         temp.emp_code
        ,temp.username
        ,temp.password
        ,temp.name_th
        ,temp.name_en
        ,temp.postname_th
        ,temp.postname_en
        ,temp.nickname1_th
        ,temp.nickname1_en
        ,temp.nickname2_th
        ,temp.nickname2_en
        ,temp.email
        ,temp.3cx as cx
        ,temp.phone
        ,temp.status
        ,temp.group_id
        ,temp.type as type_login
        ,temp.status_permission
        ,temp.admin_menu
        ,temp.data_status
        ,temp.note
        ,gp.name_th as group_name_th
        ,gp.name_en as group_name_en
        ,gp.active
        FROM temporary temp
        JOIN application_group gp
        ON temp.group_id=gp.group_id
        WHERE temp.active = 1
        AND temp.data_status = 1
        AND temp.createby = '{$user_id}'
        {$search}
        {$order_by}
        ";

        $sql_new = DB::select($sql_new);

        $new = array();
        if (!empty($sql_new)) {
            $i = 0;
            foreach ($sql_new as $item) {
                    $new[] = array(
                        'index'  => $i,
                        'type_login' => ($item->type_login == -1 ? '' : $item->type_login),
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
                        'status' => ($item->status == -1 ? '' : $item->status),
                        'group_id' => $item->group_id,
                        'group_name_th' => ($item->active == 0 ? '' : $item->group_name_th),
                        'group_name_en' => ($item->active == 0 ? '' : $item->group_name_en),
                        // 'image' => ($item->image == '' ? '' : 'http://10.7.200.229/apiweb/images/user-profile/' . $item->image),
                        'status_permission' => $item->status_permission,
                        'admin_menu' => $item->admin_menu,
                        'data_status' => $item->data_status,
                        'note' => $item->note
                    );

                    $i++;
            }
        }
        
        return $new;
    }

    public static function get_temporary_update($keyword, $field, $sort, $user_id)
    {
        $search = '';
        $order_by = '';
        if ($keyword != '') {
            $search = "AND ((temp.name_th like '%{$keyword}%') OR 
            (temp.name_en like '%{$keyword}%') OR 
            (temp.emp_code like '%{$keyword}%') OR
            (temp.postname_th like '%{$keyword}%') OR
            (temp.postname_en like '%{$keyword}%') OR
            (gp.name_th like '%{$keyword}%') OR
            (gp.name_en like '%{$keyword}%')
            )";
        }
        if ($field != '') {
            $order_by = "ORDER BY {$field} {$sort}";
        } else {
            $order_by = "ORDER BY temp.emp_code";
        }
        $sql_update = "
        SELECT 
         temp.emp_code
        ,temp.username
        ,temp.password
        ,temp.name_th
        ,temp.name_en
        ,temp.postname_th
        ,temp.postname_en
        ,temp.nickname1_th
        ,temp.nickname1_en
        ,temp.nickname2_th
        ,temp.nickname2_en
        ,temp.email
        ,temp.3cx as cx
        ,temp.phone
        ,temp.status
        ,temp.group_id
        ,temp.type as type_login
        ,temp.status_permission
        ,temp.admin_menu
        ,temp.data_status
        ,temp.note
        ,gp.name_th as group_name_th
        ,gp.name_en as group_name_en
        ,gp.active
        FROM temporary temp
        JOIN application_group gp
        ON temp.group_id=gp.group_id
        WHERE temp.active = 1
        AND temp.data_status = 2
        AND temp.createby = '{$user_id}'
        {$search}
        {$order_by}
        ";

        $sql_update = DB::select($sql_update);

        $update = array();
        if (!empty($sql_update)) {
            $i = 0;
            foreach ($sql_update as $item) {
                    $update[] = array(
                        'index'  => $i,
                        'type_login' => ($item->type_login == -1 ? '' : $item->type_login),
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
                        'status' => ($item->status == -1 ? '' : $item->status),
                        'group_id' => ($item->group_id == -1 ? '' : $item->group_id),
                        'group_name_th' => ($item->active == 0 ? '' : $item->group_name_th),
                        'group_name_en' => ($item->active == 0 ? '' : $item->group_name_en),
                        // 'image' => ($item->image == '' ? '' : 'http://10.7.200.229/apiweb/images/user-profile/' . $item->image),
                        'status_permission' => $item->status_permission,
                        'admin_menu' => $item->admin_menu,
                        'data_status' => $item->data_status,
                        'note' => $item->note
                    );

                    $i++;
            }
        }
        
        return $update;
    }

    public static function get_temporary_error($keyword, $field, $sort, $user_id)
    {
        $search = '';
        $order_by = '';
        if ($keyword != '') {
            $search = "AND ((temp.name_th like '%{$keyword}%') OR 
            (temp.name_en like '%{$keyword}%') OR 
            (temp.emp_code like '%{$keyword}%') OR
            (temp.postname_th like '%{$keyword}%') OR
            (temp.postname_en like '%{$keyword}%') OR
            (gp.name_th like '%{$keyword}%') OR
            (gp.name_en like '%{$keyword}%')
            )";
        }
        if ($field != '') {
            $order_by = "ORDER BY {$field} {$sort}";
        } else {
            $order_by = "ORDER BY temp.emp_code";
        }
        $sql_error = "
        SELECT 
         temp.emp_code
        ,temp.username
        ,temp.password
        ,temp.name_th
        ,temp.name_en
        ,temp.postname_th
        ,temp.postname_en
        ,temp.nickname1_th
        ,temp.nickname1_en
        ,temp.nickname2_th
        ,temp.nickname2_en
        ,temp.email
        ,temp.3cx as cx
        ,temp.phone
        ,temp.status
        ,temp.group_id
        ,temp.type as type_login
        ,temp.status_permission
        ,temp.admin_menu
        ,temp.data_status
        ,temp.note
        ,gp.name_th as group_name_th
        ,gp.name_en as group_name_en
        ,gp.active
        FROM temporary temp
        JOIN application_group gp
        ON temp.group_id=gp.group_id
        WHERE temp.active = 1
        AND temp.data_status = 0
        AND temp.createby = '{$user_id}'
        {$search}
        {$order_by}
        ";

        $sql_error = DB::select($sql_error);

        $mistake = array();
        if (!empty($sql_error)) {
            $i = 0;
            foreach ($sql_error as $item) {
                    $mistake[] = array(
                        'index'  => $i,
                        'type_login' => ($item->type_login == -1 ? '' : $item->type_login),
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
                        'status' => ($item->status == -1 ? '' : $item->status),
                        'group_id' => ($item->group_id == -1 ? '' : $item->group_id),
                        'group_name_th' => ($item->active == 0 ? '' : $item->group_name_th),
                        'group_name_en' => ($item->active == 0 ? '' : $item->group_name_en),
                        // 'image' => ($item->image == '' ? '' : 'http://10.7.200.229/apiweb/images/user-profile/' . $item->image),
                        'status_permission' => $item->status_permission,
                        'admin_menu' => $item->admin_menu,
                        'data_status' => $item->data_status,
                        'note' => ($item->note == 'ข้อมูลไม่ถูกต้อง' ? 1 : ( $item->note == 'ข้อมูลผู้ใช้งานใหม่ไม่ถูกต้อง' ? 2 : ( $item->note == 'ไม่พบข้อมูลที่ต้องการอัปเดต' ? 3 : ( $item->note == 'ไม่สามารถอัปเดตข้อมูล Username&Password' ? 4 : $item->note ) ) ) ),
                    );

                    $i++;
            }
        }
        
        return $mistake;
    }

    public static function count_temporary_new($user_id)
    {

        $sql_count_temporary_new = "
        SELECT * FROM temporary
        WHERE active = 1
        AND data_status = 1
        AND createby = '{$user_id}'
        ";

        $sql_count = DB::select($sql_count_temporary_new);

        $count = count($sql_count);
        
        return $count;
    }

    public static function count_temporary_update($user_id)
    {

        $sql_count_temporary_update = "
        SELECT * FROM temporary
        WHERE active = 1
        AND data_status = 2
        AND createby = '{$user_id}'
        ";

        $sql_count = DB::select($sql_count_temporary_update);

        $count = count($sql_count);
        
        return $count;
    }

    public static function count_temporary_error($user_id)
    {

        $sql_count_temporary_error = "
        SELECT * FROM temporary
        WHERE active = 1
        AND data_status = 0
        AND createby = '{$user_id}'
        ";

        $sql_count = DB::select($sql_count_temporary_error);

        $count = count($sql_count);
        
        return $count;
    }

    public static function insert_new_user_csv($item,$user_create)
    {

        $user = Users::create_user($item->emp_code, $item->name_th, $item->name_en, $item->postname_th, $item->postname_en, $item->email, $item->status, $item->group_id, $item->type, $item->username, $item->password, $user_create);
        $sql = "
        SELECT * FROM users WHERE
        emp_code = '{$item->emp_code}'
        AND type = {$item->type}
        AND active = 1";
        $sql_user = DB::select($sql);
        $user_id = 0;
        foreach ($sql_user as $user) {
            $user_id =  $user->user_id;
        }
        $user_profile = Users::create_user_profile($user_id, $item->emp_code, $item->name_th, $item->name_en, $item->postname_th, $item->postname_en, $item->email, $item->status, $item->group_id, $item->type, $item->username, $item->password, $user_create, $item->cx, $item->nickname1_th, $item->nickname1_en, $item->nickname2_th, $item->nickname2_en, $item->phone, $item->status_permission, $item->admin_menu);
        
        return $item;
    }

    public static function insert_new_user_ldap_csv($item,$user_create)
    {
        $username = Users::searchLDAP($item->emp_code);
        $user = Users::create_user($item->emp_code, $item->name_th, $item->name_en, $item->postname_th, $item->postname_en, $item->email, $item->status, $item->group_id, $item->type, $username, 'LDAP', $user_create);
        $sql = "
        SELECT * FROM users WHERE
        emp_code = '{$item->emp_code}'
        AND type = {$item->type}
        AND active = 1";
        $sql_user = DB::select($sql);
        $user_id = 0;
        foreach ($sql_user as $user) {
            $user_id =  $user->user_id;
        }
        $user_profile = Users::create_user_profile($user_id, $item->emp_code, $item->name_th, $item->name_en, $item->postname_th, $item->postname_en, $item->email, $item->status, $item->group_id, $item->type, $username, 'LDAP', $user_create, $item->cx, $item->nickname1_th, $item->nickname1_en, $item->nickname2_th, $item->nickname2_en, $item->phone, $item->status_permission, $item->admin_menu);
        
        return $item;
    }

    public static function update_user_csv($item,$user_create)
    {

        $datetime_now = date('Y-m-d H:i:s');
        $update = '';
        $update_pro = '';
        $password = '';

        // update users
        if($item->password != ''){
            $password = bcrypt($item->password);
        }
        if($item->password != ''){
            $update .= "password = '{$password}',";
        }
        if($item->username != ''){
            $update .= "username = '{$item->username}',";
        }
        if($item->emp_code != ''){
            $update .= "emp_code = '{$item->emp_code}'";
        }
        if($item->type != -1){
            $update .= ",type = {$item->type}";
        }
        $update .= ",updatedate = '{$datetime_now}'";
        $update .= ",updateby = '{$user_create}'";
        
        $sql = "UPDATE users SET
        {$update}
        WHERE emp_code = '{$item->emp_code}'
        AND type = {$item->type}
        AND active = 1";

        $sql_user = DB::insert($sql);

        // update user_profile
        $sql_order = "
        SELECT * FROM user_profile
        WHERE emp_code = '{$item->emp_code}'
        AND type = {$item->type}
        AND NOT(group_id = {$item->group_id})
        AND active = 1";

        $sql_or = DB::select($sql_order);
        if (!empty($sql_or)) {

            $sql_delete_order = "
            UPDATE user_setting SET
            app_order = '' 
            WHERE user_id = {$sql_or[0]->user_id}";

            $sql_delete = DB::insert($sql_delete_order);
        }

        

        if($item->name_th != ''){
            $update_pro .= "name_th = '{$item->name_th}',";
        }
        if($item->name_en != ''){
            $update_pro .= "name_en = '{$item->name_en}',";
        }
        if($item->nickname1_th != ''){
            $update_pro .= "nickname1_th = '{$item->nickname1_th}',";
        }
        if($item->nickname1_en != ''){
            $update_pro .= "nickname1_en = '{$item->nickname1_en}',";
        }
        if($item->nickname2_th != ''){
            $update_pro .= "nickname2_th = '{$item->nickname2_th}',";
        }
        if($item->nickname2_en != ''){
            $update_pro .= "nickname2_en = '{$item->nickname2_en}',";
        }
        if($item->postname_th != ''){
            $update_pro .= "postname_th = '{$item->postname_th}',";
        }
        if($item->postname_en != ''){
            $update_pro .= "postname_en = '{$item->postname_en}',";
        }
        if($item->email != ''){
            $update_pro .= "email = '{$item->email}',";
        }
        if($item->cx != ''){
            $update_pro .= "3cx = '{$item->cx}',";
        }
        if($item->status != -1){
            $update_pro .= "status = {$item->status},";
        }
        if($item->group_id != -1){
            $update_pro .= "group_id = {$item->group_id},";
        }

        if($item->emp_code != ''){
            $update_pro .= "emp_code = '{$item->emp_code}'";
        }
        if($item->type != -1){
            $update_pro .= ",type = {$item->type}";
        }
        $datetime_now = date('Y-m-d H:i:s');
        $update_pro .= ",updatedate = '{$datetime_now}'";
        $update_pro .= ",updateby = '{$user_create}'";

        $sql_pro = "UPDATE user_profile SET
        {$update_pro}
        WHERE emp_code = '{$item->emp_code}'
        AND type = {$item->type}
        AND active = 1";

        $sql_user_pro = DB::insert($sql_pro);
        
        return 'success';
    }

    public static function update_user_ldap_csv($item,$user_create)
    {

        $datetime_now = date('Y-m-d H:i:s');
        $update = '';
        $update_pro = '';

        // update users
        if($item->emp_code != ''){
            $update .= "emp_code = '{$item->emp_code}'";
        }
        if($item->type != -1){
            $update .= ",type = {$item->type}";
        }
        $update .= ",updatedate = '{$datetime_now}'";
        $update .= ",updateby = '{$user_create}'";
        
        $sql = "UPDATE users SET
        {$update}
        WHERE emp_code = '{$item->emp_code}'
        AND type = {$item->type}
        AND active = 1";

        $sql_user = DB::insert($sql);

        // update user_profile
        $sql_order = "
        SELECT * FROM user_profile
        WHERE emp_code = '{$item->emp_code}'
        AND type = {$item->type}
        AND NOT(group_id = {$item->group_id})
        AND active = 1";

        $sql_or = DB::select($sql_order);
        if (!empty($sql_or)) {

            $sql_delete_order = "
            UPDATE user_setting SET
            app_order = '' 
            WHERE user_id = {$sql_or[0]->user_id}";

            $sql_delete = DB::insert($sql_delete_order);
        }

        $datetime_now = date('Y-m-d H:i:s');

        if($item->name_th != ''){
            $update_pro .= "name_th = '{$item->name_th}',";
        }
        if($item->name_en != ''){
            $update_pro .= "name_en = '{$item->name_en}',";
        }
        if($item->nickname1_th != ''){
            $update_pro .= "nickname1_th = '{$item->nickname1_th}',";
        }
        if($item->nickname1_en != ''){
            $update_pro .= "nickname1_en = '{$item->nickname1_en}',";
        }
        if($item->nickname2_th != ''){
            $update_pro .= "nickname2_th = '{$item->nickname2_th}',";
        }
        if($item->nickname2_en != ''){
            $update_pro .= "nickname2_en = '{$item->nickname2_en}',";
        }
        if($item->postname_th != ''){
            $update_pro .= "postname_th = '{$item->postname_th}',";
        }
        if($item->postname_en != ''){
            $update_pro .= "postname_en = '{$item->postname_en}',";
        }
        if($item->email != ''){
            $update_pro .= "email = '{$item->email}',";
        }
        if($item->cx != ''){
            $update_pro .= "3cx = '{$item->cx}',";
        }
        if($item->status != -1){
            $update_pro .= "status = {$item->status},";
        }
        if($item->group_id != -1){
            $update_pro .= "group_id = {$item->group_id},";
        }

        if($item->emp_code != ''){
            $update_pro .= "emp_code = '{$item->emp_code}'";
        }
        if($item->type != -1){
            $update_pro .= ",type = {$item->type}";
        }
        $update .= ",updatedate = '{$datetime_now}'";
        $update .= ",updateby = '{$user_create}'";

        $sql_pro = "UPDATE user_profile SET
        {$update_pro}
        WHERE emp_code = '{$item->emp_code}'
        AND type = {$item->type}
        AND active = 1";

        $sql_user_pro = DB::insert($sql_pro);
        
        return 'success';
    }

    public static function searchLDAP($emp_code)
    {
        $ldap = file_get_contents(API_Sync . "iauthen/get-all-profile?user_name=&emp_number={$emp_code}");
        $data = json_decode($ldap);
        if (isset($data->data->code)) {
            return '';
        }else{
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
    
            return $user[0]['username'];
        }
        
    }
}
