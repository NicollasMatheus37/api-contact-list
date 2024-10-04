<?php

namespace App\Actions\Contact;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class GetContactsAction
{
    public static function execute(Request $request): Collection
    {
        return Contact::where('user_id', auth()->id())
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->input('search')}%")
                    ->orWhere('cpf', 'like', "%{$request->input('search')}%");
            })
            ->orderBy('name', 'ASC')
            ->get();
    }
}
