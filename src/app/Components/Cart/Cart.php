<?php

namespace App\Components\Cart;

use App\Components\BaseControl\BaseControl;
use App\Components\BaseForm\BaseFormFactory;
use Nette\Application\UI\Form;
use Tracy\Debugger;

class Cart extends BaseControl
{
    /** @var \App\Model\Eshop\Cart @inject */
    private $cart;

    /** @var BaseFormFactory */
    private $baseFormFactory;

    /**
     * Cart constructor.
     * @param \App\Model\Eshop\Cart $cart
     * @param BaseFormFactory $baseFormFactory
     */
    public function __construct(\App\Model\Eshop\Cart $cart, BaseFormFactory $baseFormFactory)
    {
        parent::__construct();

        $this->cart = $cart;
        $this->baseFormFactory = $baseFormFactory;
    }


    public function createComponentCartForm()
    {
        $form = $this->baseFormFactory->create();
        $form->addSubmit('recount', 'Přepočítat');
        $form->onSuccess[] = [$this, 'onRecount'];

        return $form;
    }

    public function isEmpty()
    {
        return $this->cart->isEmpty();
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ . '/Cart.latte');
        $template->cartItems = $this->cart->render();
        $template->render();
    }

    public function handleClear()
    {
        $this->cart->clear();
        $this->flashMessage('Košík byl úspěšně smazán', 'success');
        $this->redirect('Homepage:');
    }

    public function onRecount(Form $form, $values)
    {
        foreach ($form->getHttpData($form::DATA_TEXT | $form::DATA_KEYS, 'item_count[]') as $productId => $quantity) {
            $this->cart->setQuantity($productId, $quantity);
        }
    }
}
