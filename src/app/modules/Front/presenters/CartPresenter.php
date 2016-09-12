<?php

namespace App\FrontModule\Presenters;

use App\Components\CartFactory;

class CartPresenter extends FrontPresenter
{
    /** @var CartFactory @inject */
    public $cartFactory;

    public function createComponentCart()
    {
        $control = $this->cartFactory->create();
        return $control;
    }
}
