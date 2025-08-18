<?php

namespace App\Http\Controllers\Auth;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLogin;
use App\Http\Requests\AuthRegister;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

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
     * @return JsonResponse
     */
    public function register(AuthRegister $request)
    {
        try {
            $response = $this->authService->authRegister($request);

            if (!$response) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::FAILED_MESSAGE, statusCode: self::ERROR);
            }

            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $response, statusCode: self::SUCCESS);
        } catch (\Throwable $th) {
            Log::error('Exception ocurred while registering user' . $th->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::EXCEPTION_MESSAGE, self::ERROR);
        }
    }

    /**
     * Function: login
     * @param AuthLogin $request
     * @return JsonResponse
     */
    public function login(AuthLogin $request)
    {
        try {
            $response = $this->authService->userLogin($request);

            if (!$response) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::INVALID_CREDENTIALS, statusCode: self::ERROR);
            }

            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $response, statusCode: self::SUCCESS);
        } catch (\Throwable $th) {
            Log::error('Exception ocurred while login user' . $th->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::EXCEPTION_MESSAGE, self::ERROR);
        }
    }


    /**
     * Function: login
     * @param NA
     * @return JsonResponse
     */
    public function logOut()
    {
        try {
            $response = $this->authService->userLogOut();

            if (!$response) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::USER_NOT_FOUND, statusCode: self::ERROR);
            }

            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::USER_LOGED_OUT, statusCode: self::SUCCESS);
        } catch (\Throwable $th) {
            Log::error('Exception ocurred while logging out user' . $th->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::EXCEPTION_MESSAGE, self::ERROR);
        }
    }

    /**
     * Function userProfile
     */
    public function userProfile()
    {
        try {
            $authUser = $this->authService->userProfile();
            if (!$authUser) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::USER_NOT_FOUND, statusCode: self::ERROR);
            }

            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $authUser, statusCode: self::SUCCESS);
        } catch (\Throwable $th) {
            Log::error('Exception ocurred while retreiving user' . $th->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::EXCEPTION_MESSAGE, self::ERROR);
        }
    }

    public function user(Request $request)
    {
        $user = $request->user();
        // Load roles and permissions
        $user->load('roles', 'permissions');

        return response()->json([
            'user' => $user,
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'roles' => $user->getRoleNames()
        ]);
    }
}
