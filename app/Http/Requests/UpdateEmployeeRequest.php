<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateEmployeeRequest extends FormRequest
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
            'name' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date_format:d-m-Y',
            'position_id' => 'required',
            'marital_status' => 'required',
            'npwp' => 'required',
            'phone_number' => 'required|numeric',
            'health_insurance_number' => 'required|numeric',
            'health_insurance_id' => 'required|numeric',
            'number_of_dependants' => 'required|numeric|integer|min:0',
            'account_number' => 'numeric',
            'employment_contract' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'wajib diisi.',
            'date_format' => 'format tidak valid.',
            'numeric' => 'hanya boleh diisi angka.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'failed',
            'errors' => $validator->errors()
        ]));
    }
}
