<?php
/**
 * Created by PhpStorm.
 * (c) 2016 - Josef Drabek <rydercz@gmail.com>
 */

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