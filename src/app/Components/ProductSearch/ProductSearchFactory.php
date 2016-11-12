<?php

namespace App\Components\ProductSearch;

interface ProductSearchFactory
{
    /** @return ProductSearch */
    public function create();
}
