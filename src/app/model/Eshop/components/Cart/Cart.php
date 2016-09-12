<?php

namespace App\Components;

class Cart extends BaseControl
{
    /** @var \App\Model\Eshop\Cart @inject */
    private $cart;

    /**
     * Cart constructor.
     * @param \App\Model\Eshop\Cart $cart
     */
    public function __construct(\App\Model\Eshop\Cart $cart)
    {
        parent::__construct();

        $this->cart = $cart;
    }

    public function render()
    {
        $template = $this->getTemplate();

        if ($this->cart->isEmpty())
        {
            $template->setFile(__DIR__ . '/empty.latte');
        }
        else
        {
            $template->setFile(__DIR__ . '/Cart.latte');
            $template->cartItems = $this->cart->render();
        }

        $template->render();
    }

    public function handleClear()
    {
        $this->cart->clear();
        $this->flashMessage('Košík byl úspěšně smazán', 'success');
        $this->redirect('Homepage:');
    }
}