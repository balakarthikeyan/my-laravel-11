<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function passes($attribute, $value)
    {
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/';

        return preg_match($pattern, $value) === 1;
    }

    public function message()
    {
        return 'The :attribute must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.';
    }
}
// 'password' => ['required', 'string', 'confirmed', new StrongPassword()],