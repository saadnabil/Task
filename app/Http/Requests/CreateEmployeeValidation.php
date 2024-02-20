<?php

namespace App\Http\Requests;

use App\Rules\CheckManagerId;
use App\Rules\ComplexPassword;
use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeValidation extends FormRequest
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
            'first_name' => ['required','string','max:30'],
            'last_name' => ['required','string','max:30'],
            'salary' => ['required','numeric','min:1'],
            'image' => ['required','file','mimes:png,jpg,jpeg'],
            'email' => ['required','email'],
            'password' => ['required', new ComplexPassword],
            'manager_id' => ['required','numeric',new CheckManagerId],
        ];
    }
}
