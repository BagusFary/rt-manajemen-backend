<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRumahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nomor_rumah' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('rumah', 'nomor_rumah')->ignore($this->route('rumah')),
            ],
            'status_rumah' => 'sometimes|required|in:dihuni,tidak_dihuni',
        ];
    }
}
