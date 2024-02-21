<?php

namespace App\Http\Requests;

use App\Rules\CheckEmployeeId;
use App\Rules\CheckManagerId;
use App\Rules\ComplexPassword;
use Illuminate\Foundation\Http\FormRequest;

class TaskValidation extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string','max:30'],
            'description' => ['required','string'],
            'employee_id' => ['required','numeric',new CheckEmployeeId],
            'status' => ['required', 'string', 'in:todo,inprogress,pending,completed,onhold,canceled,deferred']
        ];
    }
}
