<?php

namespace App\Rules;

use App\Models\Employee;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckEmployeeId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $employee = Employee::where('id', $value)->first();
        if (!$employee) {
            $fail('The :attribute you entered does not correspond to a employee manager ID.');
        }
    }
}
