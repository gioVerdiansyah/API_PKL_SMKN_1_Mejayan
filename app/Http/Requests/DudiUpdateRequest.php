<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DudiUpdateRequest extends FormRequest
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
            'nama' => ['required', 'string', 'unique:dudis,nama,' . $this->route('dudi') . ',id'],
            'pemimpin' => ['required', 'string'],
            'no_telp' => ['nullable', 'string'],
            'email' => ['nullable', 'email:rfc,dns'],
            'alamat' => ['required', 'string'],
            'koordinat' => ['required', 'regex:/^-?\d{1,2}\.\d+, -?\d{1,3}\.\d+$/'],
            'radius' => ['required', 'integer'],
        ];
    }
}
