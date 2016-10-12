<?php

namespace App\Components;

use App\Model\Products\Product;

interface ProductFormFactory
{
    /**
     * @param Product $product
     * @return ProductForm
     */
    public function create(Product $product = null);
}
