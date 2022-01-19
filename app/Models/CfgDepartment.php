<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CfgDepartment extends Model {

    // protected $table = 'cfg_department';
//    protected $primaryKey = 'id';
    // public $timestamps = false;

    public static function getCountDepartment()
    {   
        // $limit = 100;
        $_sql_all = "
        SELECT * FROM users";
        $sql_all = DB::select($_sql_all);

        // $_sql_active = "
        // SELECT COUNT(code) AS count_active FROM cfg_department WHERE status = 1";
        // $sql_active = DB::select($_sql_active);

        // $_sql_inactive = "
        // SELECT COUNT(code) AS count_inactive FROM cfg_department WHERE status = 0 ";
        // $sql_inactive = DB::select($_sql_inactive);
       
        // $datas = array(
        //     'count_all' => ((isset($sql_all[0]->count_all)? $sql_all[0]->count_all: 0)),
        //     'count_active' => ((isset($sql_active[0]->count_active)? $sql_active[0]->count_active: 0)),
        //     'count_inactive' => ((isset($sql_inactive[0]->count_inactive)? $sql_inactive[0]->count_inactive: 0)),
        // );

        return $sql_all;

    }

}
