<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Http\FormRequest;

class task_validate extends FormRequest
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
    'title'              => ['required', 'string', 'max:35'],
    'priority'           => ['required', 'string', 'in:low,medium,high,urgent'],
    'deadline'           => ['nullable', 'date_format:Y-m-d', 'after_or_equal:today'],
    'user_id'            => ['nullable', 'exists:login,id'],
    'status'             => ['sometimes', 'string', 'in:pending,in_progress,completed'],
    'is_recurring'       => ['boolean'],
    'recurrence_pattern' => ['nullable', 'string'],
];
    }
}
