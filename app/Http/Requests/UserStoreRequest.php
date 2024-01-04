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
            'jenis_kelamin' => ['required', Rule::in(['P', 'L'])],
            'alamat' => 'required|string',
            'no_hp' => 'required|string|gt:0',
            'no_hp_ortu' => 'required|string|gt:0',
            'tempat_dudi' => 'required|string',
            'pemimpin_dudi' => 'required|string',
            'no_telp_dudi' => 'required|string',
            'alamat_dudi' => 'required|string',
            'koordinat' => 'required|string',
            'senin_awal' => 'required|date_format:H:i',
            'senin_akhir' => 'required|date_format:H:i|after:senin_awal',
            'selasa_awal' => 'required|date_format:H:i',
            'selasa_akhir' => 'required|date_format:H:i|after:selasa_awal',
            'rabu_awal' => 'required|date_format:H:i',
            'rabu_akhir' => 'required|date_format:H:i|after:rabu_awal',
            'kamis_awal' => 'required|date_format:H:i',
            'kamis_akhir' => 'required|date_format:H:i|after:kamis_awal',
            'jumat_awal' => 'required|date_format:H:i',
            'jumat_akhir' => 'required|date_format:H:i|after:jumat_awal',
            'saptu_awal' => 'nullable|date_format:H:i',
            'saptu_akhir' => 'nullable|date_format:H:i|after:saptu_awal',
            'minggu_awal' => 'nullable|date_format:H:i',
            'minggu_akhir' => 'nullable|date_format:H:i|after:minggu_awal',
            'ji_senin_awal' => 'required|date_format:H:i',
            'ji_senin_akhir' => 'required|date_format:H:i|after:ji_senin_awal',
            'ji_selasa_awal' => 'required|date_format:H:i',
            'ji_selasa_akhir' => 'required|date_format:H:i|after:ji_selasa_awal',
            'ji_rabu_awal' => 'required|date_format:H:i',
            'ji_rabu_akhir' => 'required|date_format:H:i|after:ji_rabu_awal',
            'ji_kamis_awal' => 'required|date_format:H:i',
            'ji_kamis_akhir' => 'required|date_format:H:i|after:ji_kamis_awal',
            'ji_jumat_awal' => 'required|date_format:H:i',
            'ji_jumat_akhir' => 'required|date_format:H:i|after:ji_jumat_awal',
            'ji_saptu_awal' => 'nullable|date_format:H:i',
            'ji_saptu_akhir' => 'nullable|date_format:H:i|after:ji_saptu_awal',
            'ji_minggu_awal' => 'nullable|date_format:H:i',
            'ji_minggu_akhir' => 'nullable|date_format:H:i|after:ji_minggu_awal',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json($validator->errors(), 422);

        throw new ValidationException($validator, $response);
    }
}
