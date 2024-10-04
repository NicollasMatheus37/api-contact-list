<?php

namespace App\Actions\Auth;

use Illuminate\Http\Request;

class LogoutAction
{
    public static function execute(Request $request): void
    {
        // validate request
        self::validateRequest($request);

        // revoke the token
        $request->user()->currentAccessToken()->delete();
    }

    private static function validateRequest(Request $request): void
    {
        if (!$request->user()) {
            abort(401, 'Unauthenticated');
        }
    }
}
