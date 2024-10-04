<?php

namespace App\Http\Controllers;

use App\Actions\Contact\CreateOrUpdateContactAction;
use App\Actions\Contact\GetContactsAction;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $contacts = GetContactsAction::execute($request);

        return response()->json([
            'data' => $contacts,
            'meta' => [
                'total' => count($contacts),
            ]
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        return response()->json([
            'data' => Contact::find($id),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $contact = CreateOrUpdateContactAction::execute($request);

        return response()->json([
            'message' => 'Contact created',
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $contact = CreateOrUpdateContactAction::execute($request, $id);

        return response()->json([
            'message' => 'Contact updated',
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        Contact::find($id)->delete();

        return response()->json(['message' => 'Contact deleted']);
    }
}
