<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ubah dari false ke true
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'sku'         => ['required', 'string', 'unique:products,sku'],
            'is_active'   => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Nama produk wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric'  => 'Harga harus berupa angka.',
            'sku.required'   => 'SKU wajib diisi.',
            'sku.unique'     => 'SKU sudah digunakan produk lain.',
        ];
    }
}