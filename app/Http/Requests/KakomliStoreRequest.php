<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KakomliStoreRequest extends FormRequest
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
            'jurusan' => 'required|uuid',
            'nama' => 'required|string|max:255|unique:kakomlis,nama',
            'email' => 'required|email|unique:kakomlis,email',
            'nip' => 'required|integer',
            'no_hp' => 'required|regex:/^62\d+$/'
        ];
    }
}
