<?php

namespace App\Actions\Contact;

use App\Actions\Address\GetGeocodingAddressFromGMapsApiAction;
use App\Models\Contact;
use App\Rules\CepValidator;
use App\Rules\CpfValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateOrUpdateContactAction
{
    public static function execute(Request $request, ?int $id = null): Contact
    {
        // validate request
        self::validateRequest($request, $id);

        // create or update contact
        return self::createOrUpdateContact($request, $id);
    }

    private static function validateRequest(Request $request, int $id): void
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string'],
            'cpf' => ['required', Rule::unique('contacts')->ignore($id), new CpfValidator()],
            'address' => ['required', 'string'],
            'number' => ['required', 'string'],
            'complement' => ['string', 'nullable'],
            'district' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'country' => ['required', 'string'],
            'zipcode' => ['required', new CepValidator()],
        ]);

        if ($validator->fails()) {
            abort(400, $validator->errors()->first());
        }
    }

    private static function createOrUpdateContact(Request $request, ?int $id): Contact
    {
        if ($id) {
            $contact = Contact::find($id);
        } else {
            $contact = new Contact();
        }

        $contact->name = $request->get('name');
        // set phone and cpf without format
        $contact->phone = preg_replace('/[^0-9]/', '', $request->get('phone'));
        $contact->cpf = preg_replace('/[^0-9]/', '', $request->get('cpf'));

        $contact->user_id = $request->user()->id;
        $contact->address = $request->get('address');
        $contact->number = $request->get('number');
        $contact->complement = $request->get('complement');
        $contact->district = $request->get('district');
        $contact->city = $request->get('city');
        $contact->state = $request->get('state');
        $contact->country = $request->get('country');
        $contact->zipcode = $request->get('zipcode');

        $geocoding = GetGeocodingAddressFromGMapsApiAction::execute($contact);
        $contact->latitude = $geocoding->get('latitude');
        $contact->longitude = $geocoding->get('longitude');

        $contact->save();

        return $contact;
    }
}
