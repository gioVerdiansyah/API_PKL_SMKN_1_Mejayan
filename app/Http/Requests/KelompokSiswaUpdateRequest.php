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
            'guru_id' => 'required|string|uuid|exists:gurus,id',
            'dudi_id' => 'required|string|uuid|unique:kelompoks,dudi_id,' . $id .',id|exists:dudis,id',
            'anggota' => 'required|array|min:1',
            'anggota.*' => 'uuid|exists:users,id'
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kelompok.unique' => "Nama kelompok sudah di gunakan, baik Anda atau kakomli lain!"
        ];
    }
}
