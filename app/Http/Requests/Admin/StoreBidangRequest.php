<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBidangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:150'],
            'tugas' => ['nullable', 'string'],
            'fungsi' => ['nullable', 'string'],
        ];
    }
}
