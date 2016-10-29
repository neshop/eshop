<?php

namespace App\Model\Products;

interface ProductSearchFactory
{
    /** @return ProductSearch */
    public function create();
}
