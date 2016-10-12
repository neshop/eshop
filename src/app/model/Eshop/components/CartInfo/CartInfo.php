<?php

namespace App\Components;

use App\Model\Eshop\Cart as CartEntity;

class CartInfo extends BaseControl
{
    /** @var CartEntity */
    private $cart;

    /**
     * CartInfo constructor.
     * @param CartEntity $cart
     */
    public function __construct(CartEntity $cart)
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
