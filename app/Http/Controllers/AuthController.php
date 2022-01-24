<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Models\Users;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $_dataAll = $request->all();
        $emp_code = $_dataAll['emp_code'];
        $name_th  = $_dataAll['name_th'];
        $name_en  = $_dataAll['name_en'];
        $postname_th  = $_dataAll['postname_th'];
        $postname_en  = $_dataAll['postname_en'];
        $email    = $_dataAll['email'];
        $status   = $_dataAll['status'];
        $group    = $_dataAll['group'];
        $type     = $_dataAll['type'];
        $username = $_dataAll['username'];
        $password = $_dataAll['password'];

        // if ($type == 'USER') {
        //     $validator = validator()->make(request()->all(), [
        //         'username' => 'string|required',
        //         'email' => 'email|required',
        //         'password' => 'string|min:6'
        //     ]);

        //     if ($validator->fails()) {
        //         return response()->json([
        //             'message' => 'Registrantion Faild'
        //         ]);
        //     }
        // }
        // $user = User::create(['name' => request()->get('name'),
        //                       'email' => request()->get('email'),
        //                       'password' => bcrypt(request()->get('password'))]);
        $user = Users::check_register($emp_code, $name_th, $name_en, $postname_th, $postname_en, $email, $status, $group, $type, $username, $password);

        return response()->json([
            // 'message' => '',
            'message' => $user
        ]);
    }

    public function login(Request $request)
    {
        $_dataAll = $request->all();
        $username = $_dataAll['username'];
        $password = $_dataAll['password'];
        $type   = $_dataAll['type'];
        if ($type == 'LDAP') {
            $url = 'http://10.7.200.178:82/iauthen/ldap-authen';
            $data = array('login' => $username, 'password' => $password);

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result === FALSE) { /* Handle error */
                return response()->json([
                    'data' =>$user[] = array(
                        'error' => 'Unknow parameter '
                   )
               ], 401);
            } else {
                $data = json_decode($result);
                if (isset($data->success->data->access_token)) {
                    $password = 'LDAP';
                    $user = Users::check_user($username, $password, $type);
                    return $user;
                } else {
                    return response()->json([
                        'data' =>$user[] = array(
                            'error' => 'Unknow Username or Password'
                       )
                   ], 401);
                }
            }
        } else {
        $user = Users::check_user($username, $password, $type);
        return $user;
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function tokenExpired()
    {
        if (Carbon::parse(date('Y-m-d H:i:s')) < Carbon::now()) {
            return response()->json(auth()->user());
        }
        return response()->json(['message' => 'Acess token expires']);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    protected function respondWithToken($token)
    {
        return response()->json([
            'data' => $user[] = array(
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl')
            )
        ]);
    }

    public function searchLDAP(Request $request)
    {
        $_dataAll = $request->all();
        $emp_code = $_dataAll['emp_code'];
        $ldap = file_get_contents("http://10.7.200.178:82/iauthen/get-all-profile?user_name=&emp_number={$emp_code}");
        $data = json_decode($ldap);
        foreach ($data->data as $item) {
            $user[] = array(
                'emp_code'    => $item->employeenumber,
                'name_th'     => trim($item->fnamethai, ' ') . ' ' . $item->lnamethai,
                'name_en'     => $item->firstname . ' ' . $item->lastname,
                'postname_th' => $item->postname_thai,
                'postname_en' => $item->postname_en,
                'email'       => $item->email,
                'username'    => $item->uid,
            );
        }
        return response()->json([
            'data' => $user
        ], 200);
    }
}
