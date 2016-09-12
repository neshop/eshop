<?php

namespace App\Components;

interface CartFactory
{
    /** @return Cart */
    public function create();
}