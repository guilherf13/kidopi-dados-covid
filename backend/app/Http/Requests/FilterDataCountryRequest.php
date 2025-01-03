<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FilterDataCountryRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ],400));
    }

    
    public function rules(): array
    {
        return [
            'country' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'country.required' => 'O campo país é obrigatório.',
        ];
    }
}
