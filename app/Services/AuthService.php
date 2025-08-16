<?php

namespace App\Services;

use App\Repository\AuthRepository;
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
        
        //Return user
        return $this->authRepository->registerUser($request);
    }
}
