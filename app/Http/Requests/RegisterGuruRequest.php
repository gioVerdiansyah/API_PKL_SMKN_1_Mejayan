<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterGuruRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:gurus,nama'],
            'no_hp' => 'nullable|string|gt:0|regex:/^62\d+$/',
            'gelar' => ['required', 'string', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:gurus,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'same:password', 'min:8'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'poto_guru' => ['nullable', 'image','mimes:png,jpeg,jpg' ,'max:15000'],
            'jurusan_id' => ['required', 'integer', 'unique:gurus,jurusan_id']
        ];
    }

    public function messages(){
        return [
            'jurusan_id.required' => "Pilihlah ketua jurusan",
            'jurusan_id.unique' => "Jurusan ini sudah di pakai oleh guru lain!"
        ];
    }
}
