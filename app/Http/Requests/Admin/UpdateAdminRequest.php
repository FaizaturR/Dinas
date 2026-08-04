<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:admin,email,' . $this->route('kelolaAdmin')?->id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'in:admin,superadmin'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email sudah dipakai oleh admin lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}