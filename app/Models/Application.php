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
        $catagory_id,
        $type_login,
        $status,
        $status_sso,
        $image,
        $url
    ) {

        $sql = "
        SELECT * FROM application WHERE
        name_th = '{$name_th}'
        OR name_en = '{$name_en}'";

        $sql_app = DB::select($sql);

        if (count($sql_app) == 0) {
            $app = Application::create_app($name_th, $name_en, $description_th, $description_en, $catagory_id, $type_login, $status, $status_sso, $image, $url);
            return 'Application Created';
        } else {
            return 'Application Duplicate!';
        }
    }

    public static function create_app($name_th, $name_en, $description_th, $description_en, $catagory_id, $type_login, $status, $status_sso, $image, $url)
    {
        $datetime_now = date('Y-m-d H:i:s');
        $sql = "INSERT INTO application 
        (name_th
        ,name_en
        ,description_th
        ,description_en
        ,catagory_id
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
        , {$catagory_id}
        , {$type_login}
        , {$status}
        , {$status_sso}
        ,'{$datetime_now}'
        ,'{$datetime_now}'
        ,'admin'
        ,'admin'
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
        $catagory_id,
        $type_login,
        $status,
        $status_sso,
        $image,
        $url
    ) {

        $sql = "
        SELECT * FROM application WHERE
        app_id = '{$app_id}'";

        $sql_app = DB::select($sql);

        if (count($sql_app) == 1) {
            $app = Application::update_app($app_id, $name_th, $name_en, $description_th, $description_en, $catagory_id, $type_login, $status, $status_sso, $image, $url);
            return 'Application Updated';
        } else {
            return 'Unknow Application!';
        }
    }

    public static function update_app($app_id, $name_th, $name_en, $description_th, $description_en, $catagory_id, $type_login, $status, $status_sso, $image, $url)
    {
        $datetime_now = date('Y-m-d H:i:s');
        $sql = "UPDATE application SET
         name_th = '{$name_th}'
        ,name_en = '{$name_en}'
        ,description_th = '{$description_th}'
        ,description_en = '{$description_en}'
        ,catagory_id = {$catagory_id}
        ,type_login = {$type_login}
        ,status = {$status}
        ,status_sso = {$status_sso}
        ,createdate = '{$datetime_now}'
        ,updatedate = '{$datetime_now}'
        ,createby = 'admin'
        ,updateby = 'admin'
        ,image = '{$image}'
        ,url = '{$url}'
        ,active = 1";

        $sql_app = DB::insert($sql);

        $datas = array();
        if (!empty($sql_app)) {
            $datas = $sql_app;
        }
        return $datas;
    }

    public static function get_application()
    {
        $sql = "
        SELECT app.app_id
        ,app.name_th
        ,app.name_en
        ,cat.name_th as catagory_name_th
        ,cat.name_en as catagory_name_en
        ,app.type_login
        ,app.status
        FROM application app
        JOIN catagory cat 
        ON app.catagory_id=cat.catagory_id
        ORDER BY app.name_en,app.name_th";

        $sql_app = DB::select($sql);

        $datas = array();
        if (!empty($sql_app)) {
            $datas = $sql_app;
        }
        return $datas;
    }

    public static function get_catagory()
    {
        $sql = "
        SELECT * FROM catagory";

        $sql_cat = DB::select($sql);

        $datas = array();
        if (!empty($sql_cat)) {
            $datas = $sql_cat;
        }
        return $datas;
    }

    public static function add_catagory($name_th, $name_en, $emp_code)
    {
        $datetime_now = date('Y-m-d H:i:s');
        $sql = "INSERT INTO catagory 
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
            ,'{$emp_code}'
            ,'{$emp_code}'
            ,1)";

        $sql_cat = DB::select($sql);

        $datas = array();
        if (!empty($sql_cat)) {
            $datas = $sql_cat;
        }
        return $datas;
    }

    public static function update_catagory($catagory_id, $name_th, $name_en, $emp_code)
    {
        $datetime_now = date('Y-m-d H:i:s');
        $sql = "UPDATE catagory SET 
             name_th = '{$name_th}'
            ,name_en = '{$name_en}'
            ,updatedate = '{$datetime_now}'
            ,updateby = '{$emp_code}'
            WHERE catagory_id = $catagory_id";

        $sql_cat = DB::select($sql);

        $datas = array();
        if (!empty($sql_cat)) {
            $datas = $sql_cat;
        }
        return $datas;
    }
}
