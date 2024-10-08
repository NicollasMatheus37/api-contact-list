<?php

namespace App\Http\Controllers;

use App\Actions\Address\SearchForCepAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CepController extends Controller
{
    public function searchForCep(Request $request): JsonResponse
    {
        $address = SearchForCepAction::execute($request->get('cep'));

        if (!$address) {
            return response()->json(['message' => 'CEP not found'], 404);
        }

        return response()->json($address);
    }
}
