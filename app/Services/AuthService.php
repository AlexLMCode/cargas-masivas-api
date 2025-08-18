<?php

namespace App\Services;

use App\Repository\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    protected $authRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Function: authRegister
     * @param Request $request
     * @return User
     */
    public function authRegister($request)
    {
        $request = $request->all();
        $request['password'] = Hash::make($request['password']);
        $registeredUser = $this->authRepository->registerUser($request);

        $token = $registeredUser->createToken('token')->accessToken;
        return [
            'user' => [
                'email' => $registeredUser->email,
                'name' => $registeredUser->name,
            ],
            'token' => $token,
            'permissions' => $registeredUser->getAllPermissions()
        ];
    }

    /**
     * Function: userLogin
     * @param Request $request
     * @return User
     */
    public function userLogin($request)
    {
        if (!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return false;
        }

        $authUser = Auth::user();
        $token = $authUser->createToken('token')->accessToken;
        return [
            'email' => $authUser->email,
            'name' => $authUser->name,
            'token' => $token,
            'role' => $authUser->getRoleNames(),
            'permissions' => $authUser->getAllPermissions()
        ];
    }


    /**
     * Function: userLogOut
     * @param NA
     * @return Boolean
     */
    public function userLogOut()
    {
        $user = Auth::user();

        if ($user) {
            $user->token()->revoke();
            return true;
        }

        return false;
    }

    /**
     * Function userProfile
     */
    public function userProfile()
    {
        $authUser = Auth::user();
        return [
            'email' => $authUser->email,
            'name' => $authUser->name,
            'role' => $authUser->getRoleNames(),
            'permissions' => $authUser->getAllPermissions()
        ];
    }
}
