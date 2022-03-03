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
        AND u.active = 1";

        $sql_user = DB::select($sql);

        if (count($sql_user) == 1) {
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
            ,1)";

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
                ,updateby)
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
                ,'{$user_update}')";
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
}
