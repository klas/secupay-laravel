<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemoveFlagbitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trans_id' => 'required|integer|min:1',
            'flagbit_id' => 'required|integer|min:1|max:15',
            'api_key' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'trans_id.required' => 'Transaction ID is required',
            'trans_id.integer' => 'Transaction ID must be an integer',
            'trans_id.min' => 'Transaction ID must be greater than 0',
            'flagbit_id.required' => 'Flagbit ID is required',
            'flagbit_id.integer' => 'Flagbit ID must be an integer',
            'flagbit_id.min' => 'Flagbit ID must be greater than 0',
            'flagbit_id.max' => 'Flagbit ID must be between 1 and 15'
        ];
    }

    public function validatedData(): array
    {
        $validated = $this->validated();
        return [
            'trans_id' => $validated['trans_id'],
            'flagbit_id' => $validated['flagbit_id'],
            'api_key' => $this->input('api_key'),
        ];
    }
}
