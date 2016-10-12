<?php

namespace App\FrontModule\Presenters;

use App\Model\Eshop\Cart;
use App\Model\Products\Product;
use Doctrine\ORM\EntityManager;
use Nette\Application\UI\Form;

class ProductPresenter extends FrontPresenter
{
    /** @var EntityManager @inject */
    public $entityManager;

    /** @var Cart @inject */
    public $cart;

    /** @var Product */
    private $product;

    public function actionDetail($id)
    {
        $repository = $this->entityManager->getRepository(Product::class);
        $this->product = $repository->find($id);
    }

    public function renderDetail()
    {
        $template = $this->getTemplate();
        $template->product = $this->product;
    }

    public function createComponentAddToCartForm()
    {
        $form = new Form();
        $form->addInteger('quantity', 'Počet')
            ->setType('number')
            ->setDefaultValue(1)
            ->addRule(\Nette\Forms\Form::RANGE, 'Vyberte počet kusů', [1, 100]);
        $form->addSubmit('submit', 'Do košíku');
        $form->onSuccess[] = [$this, 'processAddToCartForm'];
        return $form;
    }

    public function processAddToCartForm($form, $values)
    {
        $this->cart->add($this->product, $values->quantity);
        $this->flashMessage('Produkt byl úspěšně vložen do košíku', 'success');
        $this->redirect('this');
    }
}
