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

    public function register(Request $request){
        $_dataAll = $request->all();
        $name     = $_dataAll['name'];
        $email    = $_dataAll['email'];
        $password = $_dataAll['password'];
        $status   = $_dataAll['status'];

        $validator = validator()->make(request()->all(),[
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'string|min:6'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Registrantion Faild'
            ]);
        }

        // $user = User::create(['name' => request()->get('name'),
        //                       'email' => request()->get('email'),
        //                       'password' => bcrypt(request()->get('password'))]);
        $user = Users::check_register($name, $email, $password, $status);
        
        return response()->json([
            // 'message' => '',
            'message' => $user
        ]);
    }

    public function login(Request $request)
    {
        $_dataAll = $request->all();
        $email = $_dataAll['email'];
        $password = $_dataAll['password'];
        $status = $_dataAll['status'];
        $user = Users::check_user($email, $password, $status);
        // $credentials = request(['email', 'password']);

        // if (! $token = JwtAuth::attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        return $this->respondWithToken($user);
        // return $user;
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
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl')
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
                'name_th'     => trim($item->fnamethai,' ').' '.$item->lnamethai,
                'name_en'     => $item->firstname.' '.$item->lastname,
                'postname_th' => $item->postname_thai,
                'postname_en' => $item->postname_en,
                'email'       => $item->email,
            );
        }
        return response()->json([
            'data' => $user
        ], 200);
    }

}