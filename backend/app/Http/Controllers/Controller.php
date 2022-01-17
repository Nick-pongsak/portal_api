<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function createSuccessResponse($data, $code)
    {
        //return response()->json(['data' => $data], $code);
        return response()->json($data, $code);
    }

    public function createErrorResponse($message, $code)
    {
        return response()->json(['message' => $message, 'code' => $code], $code);
    }
}
