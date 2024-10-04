<?php

namespace App\Actions\Cep;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SearchForCepAction
{
    public static function execute(Request $request): ?Collection
    {
        $cep = $request->get('cep');

        // validate CEP
        try {
            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

            return $response->collect();
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
