<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengeluaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'deskripsi' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pengeluaran' => 'required|date',
        ];
    }
}
