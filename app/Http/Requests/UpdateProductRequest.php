<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'sku'         => [
                'required',
                'string',
                Rule::unique('products', 'sku')->ignore($this->product), // Ignore produk saat ini
            ],
            'is_active'   => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Nama produk wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'sku.required'   => 'SKU wajib diisi.',
            'sku.unique'     => 'SKU sudah digunakan produk lain.',
        ];
    }
}