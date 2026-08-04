<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'bidang_id' => ['nullable', 'exists:bidang,id'],
            'nama' => ['required', 'string', 'max:150'],
            'nip' => ['nullable', 'string', 'max:30', 'unique:pegawai,nip,' . $this->route('pegawai')?->id],
            'jabatan' => ['required', 'string', 'max:150'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'email' => ['nullable', 'email', 'max:150'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ];
    }
}
