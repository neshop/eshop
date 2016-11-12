<?php

namespace App\Components\OrderForm;

use App\Components\BaseControl\BaseControl;
use App\Components\BaseForm\BaseFormFactory;
use App\Components\Cart\CartFactory;

class OrderForm extends BaseControl
{
    /** @var CartFactory */
    private $cartFactory;

    /** @var BaseFormFactory */
    private $baseFormFactory;

    /**
     * OrderForm constructor.
     * @param CartFactory $cartFactory
     * @param BaseFormFactory $baseFormFactory
     */
    public function __construct(CartFactory $cartFactory, BaseFormFactory $baseFormFactory)
    {
        parent::__construct();

        $this->cartFactory = $cartFactory;
        $this->baseFormFactory = $baseFormFactory;
    }


    public function createComponentCart()
    {
        $control = $this->cartFactory->create();
        return $control;
    }

    public function render()
    {
        $template = $this->getTemplate();

        if ($this['cart']->isEmpty()) {
            $template->setFile(__DIR__ . '/empty.latte');
        } else {
            $template->setFile(__DIR__ . '/OrderForm.latte');
        }

        $template->render();
    }
}
