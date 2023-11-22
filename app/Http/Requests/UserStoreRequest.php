<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'nik' => 'required|string',
            'jurusan'=> ['required', Rule::in(['RPL', 'TKR', 'TO', 'TBSM', 'APHP'])],
            'kelas'=> ['required', Rule::in(['X', 'XI', 'XII'])],
            'jenis_kelamin' => ['required', Rule::in(['P', 'L'])],
            'alamat' => 'required|string',
            'no_hp' => 'required|string|gt:0',
            'no_hp_ortu' => 'required|string|gt:0',
            'tempat_dudi' => 'required|string',
            'pemimpin_dudi' => 'required|string',
            'no_telp_dudi' => 'required|string',
            'alamat_dudi' => 'required|string',
            'koordinat' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json($validator->errors(), 422);

        throw new ValidationException($validator, $response);
    }
}
