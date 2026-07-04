<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenghuniRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'sometimes|required|string|max:255',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status_penghuni' => 'sometimes|required|in:tetap,kontrak',
            'nomor_telepon' => 'sometimes|required|string|max:20',
            'status_pernikahan' => 'sometimes|required|in:menikah,belum_menikah',
        ];
    }
}