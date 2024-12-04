<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\HttpClientException;

class LoginRequest extends FormRequest
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
            "email"=>"required|email",
            "password"=>"required|min:5",
        ];
    }
    public function messages():array
    {
        return [
          "email.required"=>"the email is required",
          "password.min"=>"minimum 5 characters",
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpClientException(response()->json([
            "message"=>$validator->messages()->first()
        ]));
    }
}
