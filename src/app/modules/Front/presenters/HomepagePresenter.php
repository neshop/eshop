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

    public function actionDefault()
    {
        /** @var NestedTreeRepository $categoryRepository */
        $categoryRepository = $this->entityManager->getRepository(Category::class);

        $tree = $categoryRepository->getNodesHierarchy();

        $template = $this->getTemplate();
        $template->categoryTree = $tree;
    }

}
