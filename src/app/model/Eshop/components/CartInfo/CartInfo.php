<?php

namespace App\Components;

use App\Model\Eshop\Cart;

class CartInfo extends BaseControl
{
    /** @var Cart */
    private $cart;

    /**
     * CartInfo constructor.
     * @param Cart $cart
     */
    public function __construct(Cart $cart)
    {
        parent::__construct();

        $this->cart = $cart;
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->cartInfo = $this->cart->getInfo();
        $template->setFile(__DIR__ . '/CartInfo.latte');
        $template->render();
    }
}
