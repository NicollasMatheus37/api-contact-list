<?php

namespace App\Actions\Contact;

use App\Models\Contact;
use App\Rules\CepValidator;
use App\Rules\CpfValidator;
use App\Rules\PhoneValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateOrUpdateContactAction
{
    public static function execute(Request $request, ?int $id = null): Contact
    {
        // validate request
        self::validateRequest($request);

        // create or update contact
        return Contact::updateOrCreate(
            ['id' => $id],
            $request->collect()->merge([
                'user_id' => auth()->id(),
            ])->toArray());
    }

    private static function validateRequest(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', new PhoneValidator()],
            'cpf' => ['required', 'unique:contacts', new CpfValidator()],
            'address' => ['required', 'string'],
            'number' => ['required', 'string'],
            'complement' => ['required', 'string'],
            'district' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'country' => ['required', 'string'],
            'zipcode' => ['required', new CepValidator()],
            'latitude' => ['required', 'string'],
            'longitude' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            abort(400, $validator->errors()->first());
        }
    }
}
