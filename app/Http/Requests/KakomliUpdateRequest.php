<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KakomliUpdateRequest extends FormRequest
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
        $id = $this->route('kakomli');
        return [
            'guru_id' => 'required|uuid|exists:gurus,id',
            'jurusan' => 'required|uuid',
            'nama' => 'required|string|max:255|unique:kakomlis,nama,' . $id . ',id',
            'email' => 'required|email|unique:kakomlis,email,' . $id . ',id',
            'no_hp' => 'required|regex:/^62\d+$/',
            'password' => 'nullable|string|min:8',
            'photo_profile' => 'nullable|file|image'
        ];
    }
}
