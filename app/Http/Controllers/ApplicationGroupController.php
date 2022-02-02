<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApplicationGroupController extends Controller
{
    private function getUserLogin()
    {
        $token = JWTAuth::parseToken();
        $user = $token->authenticate();
        return $user;
    }

    public function groupapp(Request $request)
    {

        $app = Application::get_group_app();

        return $this->createSuccessResponse([
            'success' => [
                'data' => $app
            ]
        ], 200);

    }
}
