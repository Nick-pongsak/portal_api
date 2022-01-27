<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Application extends Model
{
    use HasFactory;

    public static function check_add_application($name_th
    ,$name_en
    ,$description_th
    ,$description_en
    ,$catagory_id
    ,$type_login
    ,$status
    ,$status_sso
    ,$image
    ,$url){

        $sql = "
        SELECT * FROM application WHERE
        name_th = '{$name_th}'
        OR name_en = '{$name_en}'";

        $sql_app = DB::select($sql);

        if (count($sql_app) == 0) {
            $app = Application::create_app($name_th ,$name_en ,$description_th ,$description_en ,$catagory_id ,$type_login ,$status ,$status_sso ,$image ,$url);
            return 'Application Created';
        } else {
            return 'Application Duplicate!';
        }

    }

    public static function create_app($name_th ,$name_en ,$description_th ,$description_en ,$catagory_id ,$type_login ,$status ,$status_sso ,$image ,$url)
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
}
