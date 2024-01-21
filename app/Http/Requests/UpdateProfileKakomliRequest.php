<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileKakomliRequest extends FormRequest
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
            'nama' => 'required|string|max:50',
            'email' => 'required|email:rfc,dns',
            'password' => 'nullable|min:8',
            'confirm_pass' => 'required_if:password,string|same:password',
            'photo_profile' => 'nullable|file|image|mimes:png,jpg,jpeg'
        ];
    }
}
