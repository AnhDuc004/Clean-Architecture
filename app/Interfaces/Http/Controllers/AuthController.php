<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\UseCases\Auth\LoginUserUseCase;
use App\Application\UseCases\Auth\RefreshTokenUseCase;
use App\Application\UseCases\Auth\RegisterUserUseCase;
use App\Interfaces\Http\Requests\LoginRequest;
use App\Interfaces\Http\Requests\RegisterRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;

class AuthController
{
    public function register(RegisterRequest $request, RegisterUserUseCase $useCase)
    {
        $user = $useCase->execute($request->validated());
        return response()->json([
            'message' => 'User registered successfully',
            'user'    => $user->toArray(),
        ], 201);
    }

    public function login(LoginRequest $request, LoginUserUseCase $useCase)
    {
        $user = $useCase->execute($request->email, $request->password);

        if (!$user) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Xoá tất cả token cũ
        $user->tokens()->delete();

        // Tạo token mới
        $token = $user->createToken('auth_token');

        $accessToken = $token->accessToken ?? $token->token;
        $accessToken->save();

        return response()->json([
            'message' => 'Login successful',
            'token'   => $token->plainTextToken,
            'user'    => $user->toArray(),
        ]);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->user()->currentAccessToken()->delete();

        $newToken = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Token refreshed',
            'token' => $newToken
        ]);
    }
}
