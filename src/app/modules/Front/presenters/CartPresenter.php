<?php

namespace App\FrontModule\Presenters;

use App\Components\OrderForm;

class CartPresenter extends FrontPresenter
{
    /** @var OrderForm @inject */
    public $orderForm;

    public function createComponentCart()
    {
        return $this->orderForm;
    }
}
