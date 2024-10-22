<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrintAbsensiPendataanRequest extends FormRequest
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
            'nama_kelompok' => "required|string|exists:kelompoks,nama_kelompok",
            'tipe' => 'required|in:daftar-hadir,kehadiran',
            'bulan' => 'required|date_format:m-Y',
        ];
    }
}
