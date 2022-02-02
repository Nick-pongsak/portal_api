<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Application extends Model
{
    use HasFactory;

    public static function check_add_application(
        $name_th,
        $name_en,
        $description_th,
        $description_en,
        $category_id,
        $type_login,
        $status,
        $status_sso,
        $image,
        $url,
        $user_id
    ) {

        $sql = "
        SELECT * FROM application WHERE
        name_th = '{$name_th}'
        OR name_en = '{$name_en}'";

        $sql_app = DB::select($sql);

        if (count($sql_app) == 0) {
            $app = Application::create_app($name_th, $name_en, $description_th, $description_en, $category_id, $type_login, $status, $status_sso, $image, $url, $user_id);
            return response()->json([
                'success' => [
                    'data' => 'Application Created',
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'data' => 'Application Duplicate!',
                ]
            ], 400);
        }
    }

    public static function create_app($name_th, $name_en, $description_th, $description_en, $category_id, $type_login, $status, $status_sso, $image, $url, $user_id)
    {
        $datetime_now = date('Y-m-d H:i:s');
        $sql = "INSERT INTO application 
        (name_th
        ,name_en
        ,description_th
        ,description_en
        ,category_id
        ,type_login
        ,status
        ,status_sso
        ,createdate
        ,updatedate
        ,createby
        ,updateby
        ,image
        ,url
        ,active)
        VALUES 
        ('{$name_th}'
        ,'{$name_en}'
        ,'{$description_th}'
        ,'{$description_en}'
        , {$category_id}
        , {$type_login}
        , {$status}
        , {$status_sso}
        ,'{$datetime_now}'
        ,'{$datetime_now}'
        ,'{$user_id}'
        ,'{$user_id}'
        ,'{$image}'
        ,'{$url}'
        , 1)";

        $sql_app = DB::insert($sql);

        $datas = array();
        if (!empty($sql_app)) {
            $datas = $sql_app;
        }
        return $datas;
    }


    public static function update_application(
        $app_id,
        $name_th,
        $name_en,
        $description_th,
        $description_en,
        $category_id,
        $type_login,
        $status,
        $status_sso,
        $image,
        $url,
        $user_id
    ) {

        $sql = "
        SELECT * FROM application WHERE
        app_id = '{$app_id}'";

        $sql_app = DB::select($sql);

        if (count($sql_app) == 1) {
            $sql_name = "
            SELECT * FROM application WHERE
            name_th = '{$name_th}'
            OR name_en = '{$name_en}'";

            $sql_check_name = DB::select($sql_name);

            if (count($sql_check_name) == 0) {
                $app = Application::update_app($app_id, $name_th, $name_en, $description_th, $description_en, $category_id, $type_login, $status, $status_sso, $image, $url, $user_id);
                return response()->json([
                    'success' => [
                        'data' => 'Application Updated',
                    ]
                ], 200);
            } else {
                return response()->json([
                    'error' => [
                        'data' => 'Validate Name Application!',
                    ]
                ], 400);
            }
        } else {
            return response()->json([
                'error' => [
                    'data' => 'Validate Application!',
                ]
            ], 400);
        }
    }

    public static function update_app($app_id, $name_th, $name_en, $description_th, $description_en, $category_id, $type_login, $status, $status_sso, $image, $url, $user_id)
    {
        $datetime_now = date('Y-m-d H:i:s');
        $sql = "UPDATE application SET
         name_th = '{$name_th}'
        ,name_en = '{$name_en}'
        ,description_th = '{$description_th}'
        ,description_en = '{$description_en}'
        ,category_id = {$category_id}
        ,type_login = {$type_login}
        ,status = {$status}
        ,status_sso = {$status_sso}
        ,updatedate = '{$datetime_now}'
        ,updateby = '{$user_id}'
        ,image = '{$image}'
        ,url = '{$url}'
        ,active = 1
        WHERE app_id = {$app_id}";

        $sql_app = DB::insert($sql);

        $datas = array();
        if (!empty($sql_app)) {
            $datas = $sql_app;
        }
        return $datas;
    }

    public static function delete_application($app_id, $name_th, $name_en, $user_id)
    // , $description_th, $description_en, $category_id, $type_login, $status, $status_sso, $image, $url, $emp_code)
    {
        $sql_check = "SELECT * FROM application
        WHERE app_id = {$app_id}";
        $sql_check_id = DB::select($sql_check);

        if (count($sql_check_id) == 1) {
            $sql = "SELECT group_id FROM application_group
            WHERE app_id like '%{$app_id}%'";

            $sql_app = DB::select($sql);

            if (!empty($sql_app)) {
                foreach ($sql_app as $item) {
                    $id[] = array(
                        'group_id' => $item->group_id,
                    );
                }
                $group = implode(', ', array_map(function ($entry) {
                    return ($entry[key($entry)]);
                }, $id));

                $sql = "SELECT * FROM user_profile
            WHERE active = 1 AND group_id in ($group)";

                $sql_group = DB::select($sql);
                if (count($sql_group) > 0) {
                    return response()->json([
                        'error' => [
                            'data' => 'Application active!',
                        ]
                    ], 400);
                }
            } else {
                $datetime_now = date('Y-m-d H:i:s');
                $sql = "UPDATE application SET
            active = 0,
            updateby = '{$user_id}',
            updatedate = '{$datetime_now}'
            WHERE app_id = {$app_id}";

                $sql_app = DB::select($sql);
                return response()->json([
                    'success' => [
                        'data' => 'Application Deleted',
                    ]
                ], 200);
            }
        }else{
            return response()->json([
                'error' => [
                    'data' => 'Validate App ID!',
                ]
            ], 400);
        }
    }

    public static function get_application()
    {
        $sql = "
        SELECT app.app_id
        ,app.name_th
        ,app.name_en
        ,cat.name_th as category_name_th
        ,cat.name_en as category_name_en
        ,app.type_login
        ,app.status
        FROM application app
        JOIN category cat 
        ON app.category_id=cat.category_id
        WHERE app.active = 1
        ORDER BY app.name_en,app.name_th";

        $sql_app = DB::select($sql);

        $datas = array();
        if (!empty($sql_app)) {
            $datas = $sql_app;
        }
        return $datas;
    }

    public static function get_category()
    {
        $sql = "
        SELECT * FROM category WHERE active = 1";

        $sql_cat = DB::select($sql);

        $datas = array();
        if (!empty($sql_cat)) {
            $datas = $sql_cat;
        }
        return $datas;
    }

    public static function add_category($name_th, $name_en, $user_id)
    {
        $sql = "
        SELECT * FROM category WHERE
        name_th = '{$name_th}'
        OR name_en = '{$name_en}'";

        $sql_cat = DB::select($sql);

        if (count($sql_cat) == 0) {
            $datetime_now = date('Y-m-d H:i:s');
            $sql = "INSERT INTO category 
            (name_th
            ,name_en
            ,createdate
            ,updatedate
            ,createby
            ,updateby
            ,active)
            VALUES
            ('{$name_th}'
            ,'{$name_en}'
            ,'{$datetime_now}'
            ,'{$datetime_now}'
            ,'{$user_id}'
            ,'{$user_id}'
            ,1)";

            $sql_cat = DB::select($sql);
            return response()->json([
                'success' => [
                    'data' => 'Catagory Created',
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'data' => 'Catagory Duplicate!',
                ]
            ], 400);
        }
    }

    public static function update_category($category_id, $name_th, $name_en, $user_id)
    {

        $sql = "
        SELECT * FROM category WHERE
        category_id = '{$category_id}'";

        $sql_cat = DB::select($sql);

        if (count($sql_cat) == 1) {
            $datetime_now = date('Y-m-d H:i:s');
            $sql = "UPDATE category SET 
             name_th = '{$name_th}'
            ,name_en = '{$name_en}'
            ,updatedate = '{$datetime_now}'
            ,updateby = '{$user_id}'
            WHERE category_id = $category_id";

            $sql_cat = DB::select($sql);
            return response()->json([
                'success' => [
                    'data' => 'Catagory Updated',
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'data' => 'Validate Catagory!',
                ]
            ], 400);
        }
    }

    public static function delete_category($category_id, $name_th, $name_en, $user_id)
    {

        $sql = "
        SELECT * FROM category WHERE
        category_id = '{$category_id}'";

        $sql_cat = DB::select($sql);

        if (count($sql_cat) == 1) {
            $datetime_now = date('Y-m-d H:i:s');
            $sql = "UPDATE category SET 
             active = 0
            ,updatedate = '{$datetime_now}'
            ,updateby = '{$user_id}'
            WHERE category_id = $category_id";

            $sql_cat = DB::select($sql);
            return response()->json([
                'success' => [
                    'data' => 'Catagory Deleted',
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'data' => 'Validate Catagory!',
                ]
            ], 400);
        }
    }

    public static function get_group_app()
    {
        $sql = "
        SELECT name_en
        FROM application_group
        ";

        $sql_group = DB::select($sql);

        $datas = array();
        if (!empty($sql_group)) {
            $datas = $sql_group;
        }
        return $datas;
    }
}
