<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateGuruRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'oldPass' => 'nullable|string',
            'newPass' => 'required_with:oldPass,string,min:8',
            'confirmPass' => 'required_with:oldPass|same:newPass',
            'photo_guru' => "nullable|file|image|mimes:png,jpg,jpeg|max:2048"
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

        $response = response()->json(['ubahPass' => ['success' => false, 'message' => "Validasi Error: " . implode(', ', $messages)]], 422);

        throw new ValidationException($validator, $response);
    }
}
