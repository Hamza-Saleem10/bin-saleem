<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($success = true, $message = '', $data = null, $code = 200)
    {
        
        $response = [
            'success' => $success,
            'code'    => $code,
            'message' => $message
        ];

        if ($success) {
            $response['data'] = $data;
        }

        return response()->json($response, 200);
    }

}
