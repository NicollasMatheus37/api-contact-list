<?php

namespace App\Http\Controllers;

use App\Actions\User\DeleteUserAction;
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
        DeleteUserAction::execute($request);
        return response()->json(['message' => 'User deleted']);
    }
}
