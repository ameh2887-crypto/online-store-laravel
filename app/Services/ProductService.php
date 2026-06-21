<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function getPaginatedProducts(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return Product::query()
            ->when($search, function ($query, $search) {
                $query->search($search);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);
        return $product->fresh();
    }

    public function deleteProduct(Product $product): bool
    {
        return $product->delete();
    }
}