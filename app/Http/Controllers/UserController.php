<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Image;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwtauth');
    }

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
        } else {
            $image = $request->file('image');
            $input['imagename'] = time() . '.' . $image->extension();

            $destinationPath = public_path('images/user-profile');
            $img = Image::make($image->path());
            $img->resize(240, 180, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['imagename']);
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
        // if ($email == '') {
        //     $field_error .= ' email,';
        // }
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

    public function change_password(Request $request)
    {

        $_dataAll = $request->all();
        $user_update = $this->getUserLogin();
        $user_id = $_dataAll['user_id'];
        $old_password  = $_dataAll['old_password'];

        $field_error = '';
        if ($old_password == '') {
            $field_error .= ' old_password,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {

            $sql = "
        SELECT * FROM users WHERE
        user_id = {$user_id}
        AND active = 1";

            $sql_user = DB::select($sql);

            if (count($sql_user) == 1) {
                foreach ($sql_user as $item) {
                    $hash = $item->password;
                }
                // $hash = '$2y$10$f.AOeKBpQkYZyYEX5ULW0OfExjpfhxBJUYilbCH2BptVV6KBK9gDK';

                if (password_verify($old_password, $hash)) {
                    return response()->json([
                        'success' => [
                            'data' => 'password corrected',
                        ]
                    ], 200);
                } else {
                    return response()->json([
                        'error' => [
                            'data' => 'password incorrected',
                        ]
                    ], 400);
                }
            } else {
                return response()->json([
                    'error' => [
                        'data' => 'password incorrected',
                    ]
                ], 400);
            }
        }
    }

    public function change_password_new(Request $request)
    {

        $_dataAll = $request->all();
        $user_update = $this->getUserLogin();
        $user_id = $_dataAll['user_id'];
        $new_password  = $_dataAll['new_password'];

        $field_error = '';
        if ($new_password == '') {
            $field_error .= ' new_password,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {

            $sql = "
            SELECT * FROM users WHERE
            user_id = {$user_id}
            AND active = 1";

            $sql_user = DB::select($sql);

            if (count($sql_user) == 1) {
                $sql = "
                UPDATE users SET
                password = '{$new_password}'
                WHERE
                user_id = {$user_id}
                AND active = 1";
    
                $sql_user = DB::select($sql);

                return response()->json([
                    'success' => [
                        'data' => 'password updated',
                    ]
                ], 200);
                
            } else {
                return response()->json([
                    'error' => [
                        'data' => 'ไม่พบ user_id ที่ต้องการเปลี่ยน password ',
                    ]
                ], 225);
            }
        }
    }
    public function checkaccess(Request $request){
        
        $_dataAll = $request->all();
        #$user_s = $this->getUserLogin();
        $host = $_dataAll['host'];
        $url = $_dataAll['url'];
        $username = $_dataAll['username'];
        $pwd = $_dataAll['password'];
        $access = $this->cypherapi($host,$url,$username,$pwd);
        
        if($access){
            return response()->json([
                'success' => [
                    'data' => 'true',
                ]
            ], 200);
        }else{
            return response()->json([
                'success' => [
                    'data' => 'false',
                ]
            ], 401);
        }
        
    }
    private function cypherapi($host='',$url='' , $username = '', $pwd ='')
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            //CURLOPT_PORT => API_Cipher_PORT,
            //CURLOPT_URL => $host.$url."username={$username}&password={$pwd}",
            CURLOPT_URL => "http://".$host.$url."&username={$username}&password={$pwd}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            
            
            # print_r($response);die;
            $resource = json_decode($response);
            if(isset($resource->success->token)){
                return $resource->success->token;
            }else{
                return false;
            }
            
        }
        
    }
    
}
