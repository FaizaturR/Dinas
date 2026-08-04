<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTanggapanRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'isi_tanggapan' => ['required', 'string'],
            'status' => ['required', 'in:diajukan,diproses,ditanggapi,ditutup'],
        ];
    }
}
