<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;

class LoginAction
{
    /**
     * Handle user login
     * @param LoginRequest $request
     * @return array
     */
    public function handle(LoginRequest $request): array
    {
        $request->validated();

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('login-token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
}
