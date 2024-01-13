<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DudiStoreRequest extends FormRequest
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
            'nama' => ['required', 'string', 'unique:dudis,nama'],
            'pemimpin' => ['required', 'string'],
            'no_telp' => ['nullable', 'string'],
            'email' => ['nullable', 'email:rfc,dns'],
            'alamat' => ['required', 'string'],
            'koordinat' => ['required', 'regex:/^-?\d{1,2}\.\d+, -?\d{1,3}\.\d+$/'],
            'radius' => ['required', 'integer'],
            'senin' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'selasa' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'rabu' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'kamis' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'jumat' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'sabtu' => ['nullable', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'minggu' => ['nullable', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'ji_senin' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'ji_selasa' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'ji_rabu' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'ji_kamis' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'ji_jumat' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'ji_sabtu' => ['nullable', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'ji_minggu' => ['nullable', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],

        ];
    }

    public function messages()
    {
        return [
            'senin.required' => 'Jam masuk Senin wajib diisi.',
            'senin.regex' => 'Format jam masuk Senin tidak valid.',
            'ji_senin.required' => 'Jam istirahat Senin wajib diisi.',
            'ji_senin.regex' => 'Format jam istirahat Senin tidak valid.',
            'selasa.required' => 'Jam masuk Selasa wajib diisi.',
            'selasa.regex' => 'Format jam masuk Selasa tidak valid.',
            'ji_selasa.required' => 'Jam istirahat Selasa wajib diisi.',
            'ji_selasa.regex' => 'Format jam istirahat Selasa tidak valid.',
            'rabu.required' => 'Jam masuk Rabu wajib diisi.',
            'rabu.regex' => 'Format jam masuk Rabu tidak valid.',
            'ji_rabu.required' => 'Jam istirahat Rabu wajib diisi.',
            'ji_rabu.regex' => 'Format jam istirahat Rabu tidak valid.',
            'kamis.required' => 'Jam masuk Kamis wajib diisi.',
            'kamis.regex' => 'Format jam masuk Kamis tidak valid.',
            'ji_kamis.required' => 'Jam istirahat Kamis wajib diisi.',
            'ji_kamis.regex' => 'Format jam istirahat Kamis tidak valid.',
            'jumat.required' => 'Jam masuk Jumat wajib diisi.',
            'jumat.regex' => 'Format jam masuk Jumat tidak valid.',
            'ji_jumat.required' => 'Jam istirahat Jumat wajib diisi.',
            'ji_jumat.regex' => 'Format jam istirahat Jumat tidak valid.',
            'sabtu.regex' => 'Format jam masuk Sabtu tidak valid.',
            'ji_sabtu.regex' => 'Format jam istirahat Sabtu tidak valid.',
            'minggu.regex' => 'Format jam masuk Minggu tidak valid.',
            'ji_minggu.regex' => 'Format jam istirahat Minggu tidak valid.',
        ];
    }
}
