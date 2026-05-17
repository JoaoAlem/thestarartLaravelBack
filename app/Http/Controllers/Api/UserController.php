<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        [
            'email' => $email,
            'password' => $password,
            'remember_token' => $rememberToken
        ] = $request->validated();

        if (!Auth::attempt(['email' => $email, 'password' => $password], $rememberToken)) {
            return response()->json([
                'error' => 'E-mail ou senha incorretos.',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
}
