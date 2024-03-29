<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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

            $old_password = Users::decrypt_crypto($old_password, 'WebPortalKey');
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
    
    private function cypherapi($host='',$url='' , $username = '', $pwd ='')
    {
        $curl = curl_init();
        $pwd = urlencode($pwd);
        curl_setopt_array($curl, array(
            //CURLOPT_PORT => API_Cipher_PORT,
            //CURLOPT_URL => $host.$url."username={$username}&password={$pwd}",
            CURLOPT_URL => "http://".$host.$url."&username={$username}&password={$pwd}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "utf-8",
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
            
            $resource = json_decode($response);
            if(isset($resource->success->token)){
                return $resource->success->token;
            }else{
                return false;
            }
            
        }
        
    }

    private function corp_verify_curl($host='',$url='' , $username = '', $pwd ='')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://".$host.$url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => 'utf-8',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{"username":"'.$username.'", "password":"'.$pwd.'"}',
        //   CURLOPT_POSTFIELDS =>'{"username":"fake_channel_2", "password":"+ZJFhyUsjqcDQtThwnATHQ=="}',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        // print_r($response);
        // die;

        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            
            $resource = json_decode($response);
            // print_r($resource);die;
            if(isset($resource->data->access_token)){
                return true;
            }else{
                return false;
            }
            
        }
    }

    private function mktops_verify_curl($host='',$url='' , $username = '', $pwd ='')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://".$host.$url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => 'utf-8',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{"username":"'.$username.'", "password":"'.$pwd.'"}',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);

        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            
            $resource = json_decode($response);
            // print_r($resource);die;
            if(isset($resource->auth)){
                return true;
            }else{
                return false;
            }
            
        }
    }
    
    public function aes_decrypt(Request $request)
    {
        
        $_dataAll = $request->all();
        $user_update = $this->getUserLogin();
        $text = $_dataAll['text'];
        $key  = $_dataAll['key'];
        
        $rawText = Users::decrypt_crypto($text, $key);
        
        return response()->json([
            'success' => [
                'encrypted' => $rawText,
            ]
        ], 200);
    }
    
    
    public function aes_encrypt(Request $request)
    {
        
        $_dataAll = $request->all();
        $user_update = $this->getUserLogin();
        $text = $_dataAll['text'];
        $key  = $_dataAll['key'];
        
        // $encFile = AesCtr::decrypt($text,$key,256);
        $decrypted = openssl_decrypt($text, 'aes-256-ecb', $key);
        
        return response()->json([
            'success' => [
                'data' => $decrypted,
            ]
        ], 200);
    }
    
    public function update_username_sso(Request $request)
    {
        
        $_dataAll = $request->all();
        $user_update = $this->getUserLogin();
        $user_id  = $_dataAll['user_id'];
        $emp_code = $_dataAll['emp_code'];
        $app_id   = $_dataAll['app_id'];
        $username = $_dataAll['username'];
        
        $field_error = '';
        if ($user_id == '') {
            $field_error .= ' user_id,';
        }
        if ($emp_code == '') {
            $field_error .= ' emp_code,';
        }
        if ($app_id == '') {
            $field_error .= ' app_id,';
        }
        if ($username == '') {
            $field_error .= ' username,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $user = Users::update_username_sso($user_id, $emp_code, $app_id, $username, $user_update->user_id);
            
            return $user;
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
            ], 400);
        }
        
    }
    public function chkapp(Request $request){
        
        $_dataAll = $request->all();
        #$user_s = $this->getUserLogin();
        $host = $_dataAll['host'];
        $url = $_dataAll['url'];
        $username = $_dataAll['username'];
        $pwd = $_dataAll['password'];

        // $key = $username.'SalesOpsKEY';
        // $pwd = Users::decrypt_crypto($pwd, $key);
        
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
            ], 400);
        }
        
    }

    public function corp_verify(Request $request){
        
        $_dataAll = $request->all();
        #$user_s = $this->getUserLogin();
        $host = $_dataAll['host'];
        $url = $_dataAll['url'];
        $username = $_dataAll['username'];
        $pwd = $_dataAll['password'];

        // $key = $username.'SalesOpsKEY';
        // $pwd = Users::decrypt_crypto($pwd, $key);
        
        $access = $this->corp_verify_curl($host,$url,$username,$pwd);
        
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
            ], 400);
        }
        
    }

    public function mktops_verify(Request $request){
        
        $_dataAll = $request->all();
        #$user_s = $this->getUserLogin();
        $host = $_dataAll['host'];
        $url = $_dataAll['url'];
        $username = $_dataAll['username'];
        $pwd = $_dataAll['password'];

        // $key = $username.'SalesOpsKEY';
        // $pwd = Users::decrypt_crypto($pwd, $key);
        
        $access = $this->mktops_verify_curl($host,$url,$username,$pwd);
        
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
            ], 400);
        }
        
    }

    public function update_language(Request $request)
    {
        
        $_dataAll = $request->all();
        $user_update = $this->getUserLogin();
        $user_id  = $_dataAll['user_id'];
        $emp_code  = $_dataAll['emp_code'];
        $language = $_dataAll['language'];
        
        $field_error = '';
        if ($user_id == '') {
            $field_error .= ' user_id,';
        }
        if ($language == '') {
            $field_error .= ' language,';
        }
        if ($emp_code == '') {
            $field_error .= ' emp_code,';
        }
        if ($field_error != '') {
            return response()->json([
                'error' => [
                    'data' => 'ส่ง parameter ไม่ครบ feild',
                ]
            ], 210);
        } else {
            $user = Users::update_language($user_id, $emp_code, $language, $user_update->user_id);
            
            return $user;
        }
    }

    public function import_user(Request $request)
    {
        $user_s = $this->getUserLogin();
        $user_id = $user_s->user_id;
        Users::checkNullgroup_id($user_id);
        Users::delete_temporary($user_id);
        File::delete(base_path('resources/csv/import-user-'.$user_id.'.csv'));
        $user_update = $this->getUserLogin();
        $request->validate([
            'csv' => 'required|mimes:csv,txt'
        ]);

        $file = file($request->csv->getRealPath());
        $data = array_slice($file, 1);
        $filename = resource_path('csv/import-user-'.$user_id.'.csv');
        file_put_contents($filename, $data);
        
        $datetime_now = date('Ymd');
        $file = file($request->csv->getRealPath());
        $data = array_slice($file, 1);
        $filename = resource_path('csv/import-user-'.$user_id.'_'.$datetime_now.'.csv');
        file_put_contents($filename, $data);

        $path = resource_path('csv/import-user-'.$user_id.'.csv');
        $g = glob($path);
        foreach ($g as $file){
            $data = array_map('str_getcsv', file($file));
            foreach($data as $row){
                $data_status = Users::checkdata_status($row[1], $row[2], $row[3], $row[4],  $row[5],     $row[6],     $row[7], $row[8],   $row[9],    $row[10],  $row[11],     $row[12],  $user_update->user_id);
                $note         = Users::checkerror_note($row[1], $row[2], $row[3], $row[4],  $row[5],     $row[6],     $row[7], $row[8],   $row[9],    $row[10],  $row[11],     $row[12],  $user_update->user_id);
                $user        = Users::insert_temporary($row[1], $row[2], $row[3], $row[4],  $row[5],     $row[6],     $row[7], $row[8],   $row[9],    $row[10],  $row[11],     $row[12],  $user_update->user_id, $data_status, $note);
                /////////////////////////////////////// type,  emp_code, name_th, name_en, postname_th, postname_en,   email,    3cx      group_id    username   password       status         user create
            }
            return response()->json([
                'success' => [
                    'data' => 'import sucess',
                ]
            ], 200);
        }
        
    }

    public function get_temporary(Request $request)
    {
        $user_s = $this->getUserLogin();
        $user_id = $user_s->user_id;
        $_dataAll = $request->all();
        $keyword  = $_dataAll['keyword'];
        $field  = $_dataAll['field'];
        $sort  = $_dataAll['sort'];
        
        $new     = Users::get_temporary_new($keyword, $field, $sort ,$user_id);
        $update  = Users::get_temporary_update($keyword, $field, $sort, $user_id);
        $mistake = Users::get_temporary_error($keyword, $field, $sort, $user_id);
        $count_new     = Users::count_temporary_new($user_id);
        $count_update  = Users::count_temporary_update($user_id);
        $count_mistake = Users::count_temporary_error($user_id);

        return response()->json([
            'success' => [
                'data' => [
                    'count_new' => $count_new,
                    'count_update' => $count_update,
                    'count_mistake' => $count_mistake,
                    'new' => $new,
                    'update' => $update,
                    'mistake' => $mistake,
                    
                ]
            ]
        ], 200);
       
    }

    public function import_temporary_to_user_profile(Request $request)
    {
        // $_dataAll = $request->all();
        $user_update = $this->getUserLogin();
        $user_s = $this->getUserLogin();
        $user_id = $user_s->user_id;

        $sql_temporary_s = "
        SELECT *, 3cx as cx FROM temporary
        WHERE active = 1 AND createby = '{$user_id}'
        ";
        $data = DB::select($sql_temporary_s);
        $emp_update = array();
        foreach($data as $item){
            $data_status = Users::checkdata_status_update($item->type, $item->emp_code, $item->name_th, $item->name_en,  $item->postname_th,     $item->postname_en,     $item->email, $item->cx,   $item->group_id,    $item->username,  $item->password,     $item->status,  $user_update->user_id, $item->data_status, $item->note);
            $note         = Users::checkerror_note_update($item->type, $item->emp_code, $item->name_th, $item->name_en,  $item->postname_th,     $item->postname_en,     $item->email, $item->cx,   $item->group_id,    $item->username,  $item->password,     $item->status,  $user_update->user_id, $item->data_status, $item->note);
            if($item->data_status != $data_status){
                array_push($emp_update, $item->emp_code, $item->note);
                $user     = Users::update_temporary($item->type, $item->emp_code, $item->name_th, $item->name_en,  $item->postname_th,     $item->postname_en,     $item->email, $item->cx,   $item->group_id,    $item->username,  $item->password,     $item->status,  $user_update->user_id, $data_status, $note);
            }
            //////////////////////////////////////////// type,       emp_code,       name_th,       name_en,        postname_th,           postname_en,           zemail,     3cx          group_id           username         password            status             user create
        }
        $user_s = $this->getUserLogin();

        $sql_temporary = "
        SELECT *, 3cx as cx FROM temporary
        WHERE active = 1 AND createby = '{$user_id}'
        ";
        $sql_temp = DB::select($sql_temporary);

        $datas = array();
        if (!empty($sql_temp) && count($emp_update) == 0) {
            foreach ($sql_temp as $item) {
                $datas = array(
                    'data' => $item
                );
                if($item->data_status == 1 && $item->type == 0){
                    $insert = Users::insert_new_user_csv($item,$user_s->user_id);
                }
                if($item->data_status == 1 && $item->type == 1){
                    $insert_user_ldap = Users::insert_new_user_ldap_csv($item,$user_s->user_id);
                }
                if($item->data_status == 2 && $item->type == 0){
                    $update_user = Users::update_user_csv($item,$user_s->user_id);
                }
                if($item->data_status == 2 && $item->type == 1){
                    $update_user_ldap = Users::update_user_ldap_csv($item,$user_s->user_id);
                }
            }
        }
        return response()->json([
            'success' => [
                'data' => 'import temporary to users and user_porfile is success!!',
                'emp_update' => (count($emp_update) == 0 ? [] : $emp_update)
            ]
        ], 200);
       
    }

    public function UpdatestatusUser()
    {
        \Log::info("Strat process update user LDAP");
        $sql_user_s = "
        SELECT emp_code,status FROM user_profile
        WHERE type = 1 AND active = 1
        ";
        $data = DB::select($sql_user_s);
        $user = array();
        $emp_s = '';
        foreach($data as $item){
            // array_push($user,$item->emp_code);
            $user_update = Users::searchLDAP($item->emp_code);
            if ($user_update != '' && $item->status == 0){
                array_push($user,$item->emp_code);
                $emp_s .= $item->emp_code.'  ';
                // active
                $sql_user_active = "
                UPDATE user_profile SET
                status = 1
                WHERE emp_code = '{$item->emp_code}'
                AND type = 1
                AND active = 1
                ";
                $update_active = DB::select($sql_user_active);
            }else if ($user_update == ''){
                $emp_s .= $item->emp_code.'  ';
                // inactive
                $sql_user_inactive = "
                UPDATE user_profile SET
                status = 0
                WHERE emp_code = '{$item->emp_code}'
                AND type = 1
                AND active = 1
                ";
                $update_inactive = DB::select($sql_user_inactive);
            }
        }
        if(empty($user)){
            $user = 'empty user update';
        }else{
            $user = $emp_s;
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'dev-corp-plan.dhas.com/api/auth/botportal',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{"data":"'.$user.'","server":"'.Server_config.'"}',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        \Log::info("End process update user LDAP");
        return response()->json([
            'success' => [
                'data' => $user
            ]
        ], 200);
       
    }

}
