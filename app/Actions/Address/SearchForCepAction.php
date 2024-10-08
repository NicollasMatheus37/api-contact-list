<?php

namespace App\Actions\Address;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SearchForCepAction
{
    public static function execute(string $cep): ?Collection
    {
        try {
            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

            $collect = $response->collect();

            return new Collection([
                'address' => $collect->get('logradouro'),
                'district' => $collect->get('bairro'),
                'city' => $collect->get('localidade'),
                'state' => $collect->get('uf'),
            ]);
        } catch (Exception $e) {
            self::handleException($e);
        }

        return null;
    }

    private static function handleException(Exception $e)
    {
        // handle exception
    }
}
