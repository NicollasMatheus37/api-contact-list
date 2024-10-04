<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\ForgotPasswordAction;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\RegisterUserAction;
use App\Http\Controllers\Controller;
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

    public function forgotPassword(Request $request): JsonResponse
    {
        ForgotPasswordAction::execute($request);

        return response()->json(['message' => 'Forgot password mail sent']);
    }

    public function resetPassword(Request $request): JsonResponse
    {

    }
}
