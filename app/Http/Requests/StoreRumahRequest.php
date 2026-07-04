<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRumahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nomor_rumah' => 'required|string|max:50|unique:rumah,nomor_rumah',
            'status_rumah' => 'required|in:dihuni,tidak_dihuni',
        ];
    }
}
