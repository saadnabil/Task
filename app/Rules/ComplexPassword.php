<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ComplexPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $password = $value;

        // Define complexity requirements
        $minLength = 8;
        $requiresUppercase = true;
        $requiresLowercase = true;
        $requiresNumeric = true;
        $requiresSpecialChar = true;

        // Check minimum length
        if (strlen($password) < $minLength) {
            $fail("The $attribute must be at least $minLength characters.");
            return;
        }

        // Check for uppercase letters
        if ($requiresUppercase && !preg_match('/[A-Z]/', $password)) {
            $fail("The $attribute must contain at least one uppercase letter.");
            return;
        }

        // Check for lowercase letters
        if ($requiresLowercase && !preg_match('/[a-z]/', $password)) {
            $fail("The $attribute must contain at least one lowercase letter.");
            return;
        }

        // Check for numeric characters
        if ($requiresNumeric && !preg_match('/\d/', $password)) {
            $fail("The $attribute must contain at least one numeric digit.");
            return;
        }

        // Check for special characters
        if ($requiresSpecialChar && !preg_match('/[^a-zA-Z0-9]/', $password)) {
            $fail("The $attribute must contain at least one special character.");
            return;
        }
    }
}
