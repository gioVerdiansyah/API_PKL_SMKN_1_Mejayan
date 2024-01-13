<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $id = $this->route('siswa');
        return [
            'nama' => [
                'required',
                'string',
                Rule::unique('users', 'name')->ignore($id, 'id')
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id, 'id')
            ],
            'nis' => [
                'required',
                'string',
                Rule::unique('users', 'nis')->ignore($id, 'id')
            ],
            'jurusan' => ['required', Rule::in(\App\Models\Jurusan::pluck('id')->toArray())],
            'kelas' => ['required', Rule::in(\App\Models\Kelas::pluck('id')->toArray())],
            'jenis_kelamin' => ['required', Rule::in(['P', 'L'])],
            'alamat' => 'nullable|string',
            'password' => 'nullable|min:6',
            'no_hp' => 'nullable|string|gt:0',
            'no_hp_ortu' => 'nullable|string|gt:0',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'absen' => 'required|integer|digits:2'
        ];
    }
}
