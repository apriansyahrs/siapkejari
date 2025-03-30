<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEmployeeRequest extends FormRequest
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
            'username' => 'required|alpha_num|unique:employees,username',
            'password' => 'required|min:8',
            'nik' => 'required|numeric|digits:16',
            'email' => 'required|email|unique:employees,email',
            'birth_place' => 'required',
            'birth_date' => 'required|date_format:d-m-Y',
            'position_id' => 'required',
            'marital_status' => 'required',
            'npwp' => 'required',
            'phone_number' => 'required|numeric',
            'health_insurance_number' => 'required|numeric',
            'health_insurance_id' => 'required',
            'number_of_dependants' => 'required|numeric|integer|min:0',
            'account_number' => 'numeric',
            'employment_contract' => 'required',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'wajib diisi.',
            'unique' => ':attr sudah terdaftar.',
            'min' => 'minimal :min karakter.',
            'numeric' => 'hanya diperbolehkan angka.',
            'digits' => 'panjang karakter maksimal :digits digit.',
            'date_format' => 'Format tidak valid.',
            'email' => 'Format tidak valid.',
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
