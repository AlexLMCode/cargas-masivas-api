<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Function: success
     * @param status
     * @param message
     * @param data
     * @param statusCode
     * @return JsonResponse
     */
    public static function success($status = 'success', $message = null, $data = [], $statusCode = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Function: success
     * @param status
     * @param message
     * @param data
     * @param statusCode
     * @return JsonResponse
     */
    public static function error($status = 'error', $message = null, $statusCode = 500)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ], $statusCode);
    }
}
