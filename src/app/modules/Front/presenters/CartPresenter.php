<?php

namespace App\FrontModule\Presenters;

use App\Model\Eshop\Cart;
use Tracy\Debugger;

class CartPresenter extends FrontPresenter
{
    /** @var Cart @inject */
    public $cart;

    public function renderDefault()
    {
        $template = $this->getTemplate();
        $template->cartItems = $this->cart->render();
    }

    public function handleClear()
    {
        $this->cart->clear();
        $this->flashMessage('Košík byl úspěšně smazán', 'success');
        $this->redirect('Homepage:');
    }
}
