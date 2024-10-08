<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\RegisterUserAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $user = RegisterUserAction::execute($request);
        return response()->json($user);
    }

    public function login(Request $request): JsonResponse
    {
        $user = LoginAction::execute($request);
        return response()->json($user);
    }

    public function logout(Request $request): JsonResponse
    {
        LogoutAction::execute($request);

        return response()->json(['message' => 'User logged out']);
    }
}
