<?php

namespace App\Components\BuyForm;

interface BuyFormFactory
{
    /**
     * @return BuyForm
     */
    public function create();
}
