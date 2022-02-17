<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Tymon\JWTAuth\Facades\JWTAuth;
use Image;

class UserController extends Controller
{

    private function getUserLogin()
    {
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();
        return $user;
    }

    public function userlist(Request $request)
    {

        $_dataAll = $request->all();
        $user_s = $this->getUserLogin();
        $keyword  = $_dataAll['keyword'];
        $field  = $_dataAll['field'];
        $sort  = $_dataAll['sort'];
        $user = Users::get_user_list($keyword, $field, $sort);

        return $this->createSuccessResponse([
            'success' => [
                'data' => $user
            ]
        ], 200);
    }

    public function updateuser(Request $request)
    {

        $_dataAll = $request->all();
        $user_update = $this->getUserLogin();
        $user_id = $_dataAll['user_id'];
        $emp_code = $_dataAll['emp_code'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $postname_th  = $_dataAll['postname_th'];
        $postname_en  = $_dataAll['postname_en'];
        $email    = $_dataAll['email'];
        $status   = $_dataAll['status'];
        $group_id    = $_dataAll['group_id'];
        $type     = $_dataAll['type_login'];
        $username = $_dataAll['username'];
        $password = $_dataAll['password'];
        $cx       = $_dataAll['cx'];
        $phone     = $_dataAll['phone'];
        $nickname1_th = $_dataAll['nickname1_th'];
        $nickname1_en = $_dataAll['nickname1_en'];
        $nickname2_th = $_dataAll['nickname2_th'];
        $nickname2_en = $_dataAll['nickname2_en'];
        $permission   = $_dataAll['status_permission'];
        $admin_menu   = $_dataAll['admin_menu'];
        $app          = json_decode($_dataAll['app']);

        $field_error = '';
        if ($user_id == '') {
            $field_error .= ' user_id,';
        }
        if ($emp_code == '') {
            $field_error .= ' emp_code,';
        }
        if ($name_th == '') {
            $field_error .= ' name_th,';
        }
        if ($name_en == '') {
            $field_error .= ' name_en,';
        }
        if ($postname_th == '') {
            $field_error .= ' postname_th,';
        }
        if ($postname_en == '') {
            $field_error .= ' postname_en,';
        }
        if ($email == '') {
            $field_error .= ' email,';
        }
        if ($status == '') {
            $field_error .= ' status,';
        }
        if ($group_id == '') {
            $field_error .= ' group_id,';
        }
        if ($type == '') {
            $field_error .= ' type_login,';
        }
        if ($username == '') {
            $field_error .= ' username,';
        }
        if ($password == '') {
            $field_error .= ' password,';
        }
        if ($permission  == '') {
            $field_error .= ' status_permission,';
        }
        if ($admin_menu == '') {
            $field_error .= ' admin_menu,';
        }
        if ($app == '') {
            $field_error .= ' app,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $user = Users::update_user($user_id, $emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group_id, $type, $username, $password, $user_update->user_id, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone, $permission, $admin_menu, $app);

            return $user;
        }
    }

    public function deleteuser(Request $request)
    {

        $_dataAll = $request->all();
        $user_s = $this->getUserLogin();
        $user_id  = $_dataAll['user_id'];

        $field_error = '';
        if ($user_id == '') {
            $field_error .= ' user_id,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $user = Users::delete_user($user_id);

            return $user;
        }
    }

    public function saveorder(Request $request)
    {

        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $user_id  = $_dataAll['user_id'];
        $order  = $_dataAll['order'];

        $field_error = '';
        if ($user_id == '') {
            $field_error .= ' user_id,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $user = Users::saveorder( 
                $user_id,
                $user->emp_code,
                $order,
            );

            return $user;
        } 
    }

    public function upload_img(Request $request)
    {

        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $user_id  = $_dataAll['user_id'];
        $image  = $_dataAll['image'];

        $field_error = '';
        if ($user_id == '') {
            $field_error .= ' user_id,';
        }
        if ($image == '') {
            $field_error .= ' image,';
        }
        else{
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();
    
            $destinationPath = public_path('images/user-profile');
            $img = Image::make($image->path());
            $img->resize(240,180, function($constraint){
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $user = Users::upload_img( 
                $user_id,
                $input['imagename']
            );

            return $user;
        } 
    }

    public function delimg(Request $request)
    {

        $_dataAll = $request->all();
        $user = $this->getUserLogin();
        $user_id  = $_dataAll['user_id'];

        $field_error = '';
        if ($user_id == '') {
            $field_error .= ' user_id,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $user = Users::delimg( 
                $user_id
            );

            return $user;
        } 
    }

    public function update_profile(Request $request)
    {

        $_dataAll = $request->all();
        $user_update = $this->getUserLogin();
        $user_id = $_dataAll['user_id'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $postname_th  = $_dataAll['postname_th'];
        $postname_en  = $_dataAll['postname_en'];
        $email    = $_dataAll['email'];
        $status   = $_dataAll['status'];
        $cx       = $_dataAll['cx'];
        $phone     = $_dataAll['phone'];
        $nickname1_th = $_dataAll['nickname1_th'];
        $nickname1_en = $_dataAll['nickname1_en'];
        $nickname2_th = $_dataAll['nickname2_th'];
        $nickname2_en = $_dataAll['nickname2_en'];

        $field_error = '';
        if ($user_id == '') {
            $field_error .= ' user_id,';
        }
        // if ($emp_code == '') {
        //     $field_error .= ' emp_code,';
        // }
        if ($name_th == '') {
            $field_error .= ' name_th,';
        }
        if ($name_en == '') {
            $field_error .= ' name_en,';
        }
        if ($postname_th == '') {
            $field_error .= ' postname_th,';
        }
        if ($postname_en == '') {
            $field_error .= ' postname_en,';
        }
        if ($email == '') {
            $field_error .= ' email,';
        }
        // if ($status == '') {
        //     $field_error .= ' status,';
        // }
        // if ($nickname1_th == '') {
        //     $field_error .= ' nickname1_th,';
        // }
        // if ($nickname1_en == '') {
        //     $field_error .= ' nickname1_en,';
        // }
        // if ($nickname2_th == '') {
        //     $field_error .= ' nickname2_th,';
        // }
        // if ($nickname2_en == '') {
        //     $field_error .= ' nickname2_en,';
        // }
        // if ($group_id == '') {
        //     $field_error .= ' group_id,';
        // }
        // if ($type == '') {
        //     $field_error .= ' type_login,';
        // }
        // if ($username == '') {
        //     $field_error .= ' username,';
        // }
        // if ($password == '') {
        //     $field_error .= ' password,';
        // }
        // if ($permission  == '') {
        //     $field_error .= ' status_permission,';
        // }
        // if ($admin_menu == '') {
        //     $field_error .= ' admin_menu,';
        // }
        // if ($app == '') {
        //     $field_error .= ' app,';
        // }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $user = Users::update_profile($user_id, $name_th, $name_en, $postname_th, $postname_en, $email, $user_update->user_id, $cx, $nickname1_th, $nickname1_en, $nickname2_th, $nickname2_en, $phone);

            return $user;
        }
    }

}
