<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class project_valedate extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
return [
    'title'          => ['required', 'string', 'max:35'],
    'description'    => ['nullable', 'string'],
    'project_status' => ['required', 'string', 'in:planning,active,on_hold,completed'],
];
    }
}
