<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePositionRequest extends FormRequest
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
            'salary' => 'required|numeric|integer|min:0',
            'is_active' => 'required|boolean',
            'is_enabled_shift' => 'required|boolean',
            'working_hour_id' => 'required_if_declined:is_enabled_shift'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'wajib diisi.',
            'numeric' => 'hanya diperbolehkan angka',
            'required_if_declined' => 'wajib diisi.',
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
