<?php

namespace App\Actions\Address;

use App\Models\Contact;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GetGeocodingAddressFromGMapsApiAction
{
    public static function execute(Contact $contact): Collection
    {
        $response = self::getAddressFromGmaps($contact);

        if ($response->status() !== 200) {
            abort(400, 'Invalid address');
        }

        $location = $response->collect('results.0.geometry.location');

        $latitude = $location->get('lat');
        $longitude = $location->get('lng');

        return new Collection([
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }

    private static function getAddressFromGmaps(Contact $contact): Response
    {
        $address = $contact->address . ', ' . $contact->number . ' - ' . $contact->district . ', ' . $contact->city . ' - ' . $contact->state . ', ' . $contact->country . ', ' . $contact->zipcode;
        $address = str_replace(' ', '+', $address);
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . env('GOOGLE_MAPS_API_KEY');

        return Http::get($url);
    }
}
