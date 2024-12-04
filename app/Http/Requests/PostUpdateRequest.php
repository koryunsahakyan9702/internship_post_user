<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\HttpClientException;

class PostUpdateRequest extends FormRequest
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
            "title"=>"required|string|min:3"
        ];
    }
    public function messages():array
    {
        return [
            "title.required"=>"the title is required",
            "title.min"=>"minimum 3 characters"

        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpClientException(response()->json([
            "message"=>$validator->messages()->first()
        ]));
    }
}
