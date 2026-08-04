<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSakipRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    
    public function rules(): array
    {
        return [
            'kategori' => ['required', 'in:renstra_pk,lkjip,iku'],
            'judul' => ['required', 'string', 'max:200'],
            'tahun' => ['required', 'digits:4', 'integer', 'min:2000', 'max:2100'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
