<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuruPrintAbsensiSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kelompok' => "required|string|exists:kelompoks,nama_kelompok",
            'tipe' => 'required|in:daftar-hadir,kehadiran',
            'bulan' => 'required|date_format:m-Y',
        ];
    }
}
