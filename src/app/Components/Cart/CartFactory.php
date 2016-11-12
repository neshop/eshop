<?php

namespace App\Components\Cart;

interface CartFactory
{
    /** @return Cart */
    public function create();
}
