<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PhonNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!is_string($value)|| !preg_match('/^\+\d{13}$/',$value)){
            $fail("raqam + belgisi bilan boshlanishi va undan kegin 13 ta raqam kiritilishi kerak");
        }
    }
}
