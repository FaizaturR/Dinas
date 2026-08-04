<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGaleriRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:200'],
            'kategori' => ['required', 'in:foto,prestasi'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'keterangan' => ['nullable', 'string'],
            'tanggal' => ['required', 'date'],
        ];
    }
}
