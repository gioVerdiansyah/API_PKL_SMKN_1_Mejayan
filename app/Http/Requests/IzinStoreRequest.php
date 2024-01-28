<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class IzinStoreRequest extends FormRequest
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
            'tipe_izin'=> 'required|in:Izin,Sakit,Dispensasi',
            'alasan' => 'required|string|max:1000',
            'awal_izin' => 'required|date',
            'akhir_izin' => 'required|date',
            'bukti' => 'required|file|mimes:png,jpg,jpeg,pdf',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        $messages = [];
        $i = 0;
        foreach ($errors as $field => $errorMessages) {
            $formattedMessages = [];
            foreach ($errorMessages as $errorMessage) {
                $i++;
                $formattedMessages[] = $i . ". {$errorMessage}";
            }
            $messages[] = implode(', ', $formattedMessages);
        }

        $response = response()->json(['success' => false, 'message' => "Validasi Error: " . implode(', ', $messages)]);


        throw new ValidationException($validator, $response);
    }
}
