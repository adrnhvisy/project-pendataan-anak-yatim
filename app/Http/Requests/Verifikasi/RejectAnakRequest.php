<?php

namespace App\Http\Requests\Verifikasi;

use Illuminate\Foundation\Http\FormRequest;

class RejectAnakRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'catatan' => 'required|string|min:10|max:500',
        ];
    }
}