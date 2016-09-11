<?php

namespace App\FrontModule\Presenters;

use App\Components\CategoryTreeTrait;
use App\Model\Eshop\Cart;
use App\Model\Products\Product;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette;
use Tracy\Debugger;

class HomepagePresenter extends Nette\Application\UI\Presenter
{
    use CategoryTreeTrait;

    /** @var EntityManager @inject */
    public $entityManager;

    /** @var Cart @inject */
    public $cart;

    public function renderDefault()
    {
        $cart = $this->cart;

        /** @var EntityRepository $repository */
        //$repository = $this->entityManager->getRepository(Product::class);
        //$product = $repository->findOneBy([]);

        //$cart->add($product, 1);
        //$cart->add($product, 1);*/

        Debugger::barDump($cart->getInfo());

        $template = $this->getTemplate();
        $template->cartInfo = $cart->getInfo();
    }
}
