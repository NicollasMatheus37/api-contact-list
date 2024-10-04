<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request, int $id): JsonResponse
    {
        return response()->json([
            'data' => User::find($id),
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        $user->tokens()->delete();
        $user->contacts()->delete();
        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
