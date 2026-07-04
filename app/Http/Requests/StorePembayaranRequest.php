<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePembayaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rumah_id' => 'required|exists:rumah,id',
            'penghuni_id' => 'required|exists:penghuni,id',
            'jenis_iuran' => 'required|in:satpam,kebersihan',
            'bulan' => 'required_without:bayar_setahun|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000',
            'bayar_setahun' => 'nullable|boolean',
        ];
    }
}
