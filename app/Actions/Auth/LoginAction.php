<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    /**
     * Handle user loginBien
     * @param LoginRequest $request
     * @return array
     */
    public function handle(LoginRequest $request): array
    {
        $request->validated();

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            abort(401, 'The provided credentials are incorrect.');
        }

        $token = $user->createToken('login-token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
}
