<?php

namespace App\Components;

interface BuyFormFactory
{
    /**
     * @return BuyForm
     */
    public function create();
}