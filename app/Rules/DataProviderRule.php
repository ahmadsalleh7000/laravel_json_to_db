<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DataProviderRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!(strcasecmp($value, 'DataProviderX') === 0 || strcasecmp($value, 'DataProviderY') === 0)) {
            $fail("The :attribute must be either 'DataProviderX' or 'DataProviderY'.");
        }
    }
}
