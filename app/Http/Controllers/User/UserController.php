<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'List of users',
            'data' => $request->headers->all()
        ]);
    }

    public function show($id)
    {
        return response()->json(['message' => 'User details']);
    }

    public function store()
    {
        return response()->json(['message' => 'User created']);
    }

    public function update($id)
    {
        return response()->json(['message' => 'User updated']);
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'User deleted']);
    }
}
