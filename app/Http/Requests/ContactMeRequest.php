<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class ContactMeRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|email:rfc,dns',
            'message' => 'required|string|max:5000'
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
