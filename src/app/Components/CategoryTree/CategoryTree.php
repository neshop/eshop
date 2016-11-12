<?php

namespace App\Components\CategoryTree;

use App\Components\BaseControl\BaseControl;
use App\Model\Categories\Category;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Kdyby\Doctrine\EntityManager;

class CategoryTree extends BaseControl
{
    /** @var NestedTreeRepository */
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct();

        $this->repository = $entityManager->getRepository(Category::class);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->categoryTree = $this->repository->getNodesHierarchy();
        $template->setFile(__DIR__ . '/CategoryTree.latte');
        $template->render();
    }
}
