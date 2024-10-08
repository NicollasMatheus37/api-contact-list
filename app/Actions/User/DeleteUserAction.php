<?php

namespace App\Actions\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeleteUserAction
{
    public static function execute(Request $request)
    {
        // validate request
        self::validateRequest($request);

        // delete user
        $user = $request->user();

        $user->tokens()->delete();
        $user->contacts()->delete();
        $user->delete();
    }

    private static function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            abort(400, $validator->errors()->first());
        }
    }
}
