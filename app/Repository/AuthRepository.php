<?php

namespace App\Repository;

use App\Models\User;

class AuthRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Function: registeruser
     * @param Request $userRequest
     * @return User
     */
    public function registerUser($userRequest)
    {
        $user = User::create($userRequest);

        $user->assignRole($userRequest['role']);
        $token = $user->createToken('authToken')->plainTextToken;

        return $user;
    }
}
