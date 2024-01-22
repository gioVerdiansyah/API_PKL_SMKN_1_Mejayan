<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengurusPklStoreRequest extends FormRequest
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
            'nama' => 'required|string|unique:gurus,nama',
            'email' => 'required|email|unique:gurus,email',
            'gelar' => 'required|string',
            'password' => 'nullable|string|min:8',
            'deskripsi' => 'required|string',
            'photo_guru' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
