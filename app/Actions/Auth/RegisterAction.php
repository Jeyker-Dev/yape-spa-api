<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class RegisterAction
{
    /**
     * Handle user login
     * @param RegisterRequest $request
     * @return array
     */
    public function handle(RegisterRequest $request): array
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $token = $user->createToken('register-token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
}
