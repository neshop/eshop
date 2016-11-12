<?php

namespace App\Components\CartInfo;

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
