<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePayrollRequest extends FormRequest
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
            'employee_id' => 'required',
            'employment_contract' => 'required',
            'salary' => 'required',
            'pph_21_allowance' => 'required|numeric|integer|min:0',
            'pph_21_deduction' => 'required|numeric|integer|min:0',
            'health_insurance_contribution' => 'required|numeric|integer|min:0',
            'other_family_health_insurance_contribution' => 'required|numeric|integer|min:0',
            'total_deduction' => 'required|numeric|integer|min:0',
            'net_salary' => 'required|numeric|integer|min:0',
            'period' => 'required|date_format:m-Y',
            'account_number' => 'required|numeric',
            'payment_date' => 'required|date_format:d-m-Y'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'wajib diisi.',
            'numeric' => 'hanya boleh diisi angka.',
            'date_format' => 'format tidak valid'
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
