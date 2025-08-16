<?php

namespace App\Http\Controllers\Auth;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRegister;
use App\Services\AuthService;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    protected $authService;

    /**
     * Create a new class instance.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Function: register
     * @param AuthRegister $request
     */
    public function register(AuthRegister $request)
    {
        try {
            $response = $this->authService->authRegister($request);

            return $response ? ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $response, statusCode: self::SUCCESS) : ApiResponse::error(status: self::ERROR_STATUS, message: self::FAILED_MESSAGE, statusCode: self::ERROR);
        } catch (\Throwable $th) {
            Log::error('Exception ocurred while registering user' . $th->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::EXCEPTION_MESSAGE, self::ERROR);
        }
    }
}
