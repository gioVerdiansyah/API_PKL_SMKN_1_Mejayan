<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreAPIRequest extends FormRequest
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
            'siswa_id' => 'required|array',
            'siswa_id.*' => 'required|string|uuid|unique:users,id',
            'senin' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'selasa' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'rabu' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'kamis' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'jumat' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'sabtu' => ['nullable', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
            'minggu' => ['nullable', 'regex:/^([01]\d|2[0-3]):([0-5]\d)\s?-\s?([01]\d|2[0-3]):([0-5]\d)$/'],
        ];
    }

    public function messages()
    {
        return [
            'senin.required' => 'Jam masuk Senin wajib diisi.',
            'senin.regex' => 'Format jam masuk Senin tidak valid.',
            'selasa.required' => 'Jam masuk Selasa wajib diisi.',
            'selasa.regex' => 'Format jam masuk Selasa tidak valid.',
            'rabu.required' => 'Jam masuk Rabu wajib diisi.',
            'rabu.regex' => 'Format jam masuk Rabu tidak valid.',
            'kamis.required' => 'Jam masuk Kamis wajib diisi.',
            'kamis.regex' => 'Format jam masuk Kamis tidak valid.',
            'jumat.required' => 'Jam masuk Jumat wajib diisi.',
            'jumat.regex' => 'Format jam masuk Jumat tidak valid.',
            'sabtu.regex' => 'Format jam masuk Sabtu tidak valid.',
            'minggu.regex' => 'Format jam masuk Minggu tidak valid.',
        ];
    }
}
