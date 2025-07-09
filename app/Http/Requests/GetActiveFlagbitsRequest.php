<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetActiveFlagbitsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trans_id' => 'required|integer|min:1',
            'api_key' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'trans_id.required' => 'Transaction ID is required',
            'trans_id.integer' => 'Transaction ID must be an integer',
            'trans_id.min' => 'Transaction ID must be greater than 0',
        ];
    }

    /**
     * Get validated data with custom key mapping
     */
    public function validatedData(): array
    {
        $validated = $this->validated();
        return [
            'trans_id' => $validated['trans_id'],
            'api_key' => $this->input('api_key'), // Handle optional api_key
        ];
    }
}
