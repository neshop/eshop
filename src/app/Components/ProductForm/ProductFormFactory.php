<?php

namespace App\Components\ProductForm;

use App\Model\Products\Product;

interface ProductFormFactory
{
    /**
     * @param Product $product
     * @return ProductForm
     */
    public function create(Product $product = null);
}
