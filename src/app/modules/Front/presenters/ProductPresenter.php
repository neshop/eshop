<?php

namespace App\FrontModule\Presenters;

use App\Components\BaseFormFactory;
use App\Components\CategoryTreeTrait;
use App\Model\Eshop\Cart;
use App\Model\Products\Product;
use Doctrine\ORM\EntityManager;
use Nette\Application\UI\Form;
use Nette\Http\IResponse;
use Tomaj\Form\Renderer\BootstrapInlineRenderer;

class ProductPresenter extends FrontPresenter
{
    use CategoryTreeTrait;

    /** @var EntityManager @inject */
    public $entityManager;

    /** @var Cart @inject */
    public $cart;

    /** @var Product */
    private $product;

    /** @var BaseFormFactory @inject */
    public $baseFormFactory;

    public function actionDetail($productId)
    {
        $repository = $this->entityManager->getRepository(Product::class);
        $this->product = $repository->find($productId);

        if (!$this->product) {
            $this->error(sprintf('Product "%s" not found', $productId), IResponse::S404_NOT_FOUND);
        }
    }

    public function renderDetail()
    {
        $template = $this->getTemplate();
        $template->product = $this->product;
    }

    public function createComponentAddToCartForm()
    {
        $form = $this->baseFormFactory->create();
        $form->setRenderer(new BootstrapInlineRenderer());
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
