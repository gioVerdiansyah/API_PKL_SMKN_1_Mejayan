<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelompokSiswaUpdateRequest extends FormRequest
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
        $id = $this->route('kelompok_siswa');
        return [
            'nama_kelompok' => 'required|max:30|unique:kelompoks,nama_kelompok,' . $id . ',id',
            'guru_id' => 'required|string|uuid|exists:gurus,id',
            'dudi_id' => 'required|string|uuid|unique:kelompoks,dudi_id,' . $id .',id|exists:dudis,id',
            'anggota' => 'required|array|min:1',
            'anggota.*' => 'uuid|exists:users,id'
        ];
    }
}