<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenghuniRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status_penghuni' => 'required|in:tetap,kontrak',
            'nomor_telepon' => 'required|string|max:20',
            'status_pernikahan' => 'required|in:menikah,belum_menikah',
        ];
    }

    public function messages(): array
    {
        return [
            'foto_ktp.uploaded' => 'Foto KTP gagal diunggah, kemungkinan karena ukuran file terlalu besar (Maks 2MB).',
            'foto_ktp.max' => 'Ukuran foto KTP tidak boleh lebih dari 2MB.',
            'foto_ktp.image' => 'File yang diunggah harus berupa gambar.',
            'foto_ktp.mimes' => 'Format foto KTP harus berupa jpeg, png, atau jpg.',
        ];
    }
}
