<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CfgDepartment;


class DepartmentManageController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getCountDepartment()
    {

        // $datas = CfgDepartment::getCountDepartment();
        // print_r($datas); exit();
        return $this->createSuccessResponse([
          'success' => [
              'data' => 'cssscs',
          ]], 200);

    }

}