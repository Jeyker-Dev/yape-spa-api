<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Actions\Auth\LoginAction;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Handle user login
     * @param LoginRequest $request
     * @param LoginAction $loginAction
     * @return JsonResponse
     */
    public function login(LoginRequest $request, LoginAction $loginAction): JsonResponse
    {
        $data = $loginAction->handle($request);

        return response()->json(['token' => $data['token'], 'user' => $data['user']], 200);
    }

    /**
     * Handle user register
     * @param RegisterRequest $request
     * @param RegisterAction $registerAction
     * @return JsonResponse
     */
    public function register(RegisterRequest $request, RegisterAction $registerAction): JsonResponse
    {
        $data = $registerAction->handle($request);

        return response()->json(['message' => 'User registered successfully.', 'user' => $data['user'], 'token' => $data['token']], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Session Closed']);
    }
}
