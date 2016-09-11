<?php

namespace App\FrontModule\Presenters;

use App\Components\BuyFormFactory;
use App\Model\Categories\Category;
use App\Model\Products\Product;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Tracy\Debugger;

class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /** @var EntityManager @inject */
    public $entityManager;

    /** @var BuyFormFactory @inject */
    public $buyFormFactory;

    /** @var Product */
    private $product;

    public function actionDefault()
    {
        $repository = $this->entityManager->getRepository(Product::class);
        $product = $repository->findOneBy([]);
        $this->product = $product;
    }

    public function renderDefault()
    {
        $template = $this->getTemplate();
        $template->product = $this->product;
    }

    public function createComponentBuyForm()
    {
        $control = $this->buyFormFactory->create();
        return $control;
    }
}
