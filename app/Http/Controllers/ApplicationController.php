<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function Addapplication(Request $request)
    {
        $_dataAll = $request->all();
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $description_th  = $_dataAll['description_th'];
        $description_en  = $_dataAll['description_en'];
        $catagory_id  = $_dataAll['catagory_id'];
        $type_login  = $_dataAll['type_login'];
        $status  = $_dataAll['status'];
        $status_sso  = $_dataAll['status_sso'];
        $image  = $_dataAll['image'];
        $url  = $_dataAll['url'];

        $app = Application::check_add_application($name_th
        ,$name_en
        ,$description_th
        ,$description_en
        ,$catagory_id
        ,$type_login
        ,$status
        ,$status_sso
        ,$image
        ,$url);

        return response()->json([
            // 'message' => '',
            'message' => $app
        ]);
    }
}
