<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
            'nama' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'nis' => 'required|string|unique:users,nis',
            'jurusan'=> ['required', Rule::in(\App\Models\Jurusan::pluck('id')->toArray())],
            'kelas'=> ['required', Rule::in(\App\Models\Kelas::pluck('id')->toArray())],
            'jenis_kelamin' => ['required', Rule::in(['P', 'L'])],
            'alamat' => 'nullable|string',
            'password' => 'required|min:6',
            'no_hp' => 'nullable|string|gt:0',
            'no_hp_ortu' => 'nullable|string|gt:0',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'absen' => 'required|integer'
        ];
    }
}
