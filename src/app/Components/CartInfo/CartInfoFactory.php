<?php

namespace App\Components\CartInfo;

interface CartInfoFactory
{
    /** @return CartInfo */
    public function create();
}
