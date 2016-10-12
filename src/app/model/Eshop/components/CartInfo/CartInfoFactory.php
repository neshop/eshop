<?php

namespace App\Components;

interface CartInfoFactory
{
    /** @return CartInfo */
    public function create();
}
