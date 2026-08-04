<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengaduanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'kategori' => ['required', 'in:sarana_prasarana,kepegawaian,pelayanan,lainnya'],
            'judul' => ['required', 'string', 'max:200'],
            'isi' => ['required', 'string'],
            'lampiran' => ['nullable', 'array', 'max:3'],
            'lampiran.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }
}