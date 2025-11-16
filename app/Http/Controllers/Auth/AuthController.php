<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Handle user login
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('login-token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    /**
     * Handle user register
     * @param Request $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $request->validated();

        $user = $request->createUser($request);

        $token = $user->createToken('register-token')->plainTextToken;

        return response()->json(['message' => 'User registered successfully.', 'user' => $user, 'token' => $token], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Session Closed']);
    }
}
