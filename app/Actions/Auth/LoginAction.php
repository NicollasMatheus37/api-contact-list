<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginAction
{
    public static function execute(Request $request): User
    {
        // validate the request
        self::validateRequest($request);

        // verify credentials
        $user = self::verifyCredentials($request);

        // generate a new token
        $user->auth_token = self::generateToken($user);

        // return the authenticated user
        return $user;
    }

    private static function validateRequest(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            abort(400, $validator->errors()->first());
        }
    }

    public static function verifyCredentials(Request $request): User
    {
        $authConditions = ['email' => $request->email, 'password' => $request->password, 'is_active' => true];

        if (!Auth::attempt($authConditions)) {
            abort(401, 'Invalid credentials');
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            abort(401, 'Invalid credentials');
        }

        return $user;
    }

    public static function generateToken(User $user): string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }
}
