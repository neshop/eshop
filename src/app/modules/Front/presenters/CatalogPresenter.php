<?php

namespace App\FrontModule\Presenters;

use App\Components\CartInfoTrait;
use App\Components\CategoryTreeTrait;
use App\Model\Categories\Category;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Kdyby\Doctrine\EntityManager;
use Tracy\Debugger;

class CatalogPresenter extends FrontPresenter
{
    use CategoryTreeTrait;

    /** @var EntityManager @inject */
    public $entityManager;

    /** @var Category */
    private $category;

    public function actionCategory($id)
    {
        /** @var NestedTreeRepository $repository */
        $repository = $this->entityManager->getRepository(Category::class);

        $category = $repository->find($id);

        if (!$category)
        {
            // todo not found
        }

        $this->category = $category;
    }

    public function renderCategory()
    {
        $template = $this->getTemplate();
        $template->category = $this->category->render();
    }
}