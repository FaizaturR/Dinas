<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGaleriRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    
    public function rules(): array
    {
        return [
            'kategori' => ['required', 'in:foto,prestasi'],
            'judul' => ['required', 'string', 'max:200'],
            'tanggal' => ['required', 'date'],
            'gambar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
