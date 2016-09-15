<?php

namespace App\FrontModule\Presenters;

use App\Components\CartInfoTrait;
use App\Components\CategoryTreeTrait;
use App\Components\ProductForm;
use App\Model\Categories\Category;
use App\Model\Products\Product;
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

    /** @var Product[] */
    private $products = [];

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

        $productRepo = $this->entityManager->getRepository(Product::class);

        $qb = $productRepo->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p')
            ->where(':category MEMBER OF p.categories')
            ->setParameter('category', $category);

        $this->products = $qb->getQuery()->getResult();

        //Debugger::barDump($products);
    }

    public function renderCategory()
    {
        $template = $this->getTemplate();
        $template->category = $this->category->render();

        $products = [];

        /** @var Product $product */
        foreach ($this->products as $product)
        {
            $products[] = $product->renderListing();
        }

        $template->products = $products;
    }
}