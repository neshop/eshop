<?php

namespace App\Components;

trait CartInfoTrait
{
    /** @var CartInfoFactory @inject */
    public $cartInfoFactory;

    public function createComponentCartInfo()
    {
        $control = $this->cartInfoFactory->create();
        return $control;
    }
}