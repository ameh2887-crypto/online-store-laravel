<?php

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;
use Illuminate\View\View;

class ProductCard extends Component
{
    public function __construct(
        public Product $product
    ) {}

    public function render(): View
    {
        return view('components.product-card');
    }
}