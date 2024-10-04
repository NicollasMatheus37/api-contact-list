<?php

namespace App\Rules;

use App\Actions\Cep\SearchForCepAction;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CepValidator implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (SearchForCepAction::execute($value) === null) {
            $fail("The :attribute is invalid.");
        }
    }
}
