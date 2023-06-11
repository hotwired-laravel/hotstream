<?php

namespace Hotwired\Hotstream\Rules;

use Hotwired\Hotstream\Hotstream;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Role implements ValidationRule
{
    /**
     * Determine if the validation rule passes.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value || ! in_array($value, array_keys(Hotstream::$roles))) {
            $fail(__('The :attribute must be a valid role.', ['attribute' => $attribute]));
        }
    }
}
