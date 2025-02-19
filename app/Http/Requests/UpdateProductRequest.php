<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'sku' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products')->ignore($this->route('id')),
            ],
            'name' => 'nullable|string|max:255',
            'unique_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ];
    }
}
