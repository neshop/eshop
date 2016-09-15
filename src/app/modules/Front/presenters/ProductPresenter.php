<?php

namespace App\FrontModule\Presenters;

use App\Model\Products\Product;
use Doctrine\ORM\EntityManager;

class ProductPresenter extends FrontPresenter
{
    /** @var EntityManager @inject */
    public $entityManager;

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
}