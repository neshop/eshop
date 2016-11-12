<?php

namespace App\FrontModule\Presenters;

use App\Components\CategoryTree\CategoryTreeTrait;
use App\Model\Categories\Category;
use App\Model\Products\Product;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Kdyby\Doctrine\EntityManager;
use Nette\Http\IResponse;

class CatalogPresenter extends FrontPresenter
{
    use CategoryTreeTrait;

    /** @var EntityManager @inject */
    public $entityManager;

    /** @var Category */
    private $category;

    /** @var Product[] */
    private $products = [];

    public function actionCategory($categoryId)
    {
        /** @var NestedTreeRepository $repository */
        $repository = $this->entityManager->getRepository(Category::class);

        $category = $repository->find($categoryId);

        if (!$category) {
            $this->error(sprintf('Category "%s" not found', $categoryId), IResponse::S404_NOT_FOUND);
        }

        $this->category = $category;

        $productRepo = $this->entityManager->getRepository(Product::class);

        $this->products = $productRepo->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p')
            ->where(':category MEMBER OF p.categories')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function renderCategory()
    {
        $template = $this->getTemplate();
        $template->category = $this->category->render();

        $products = [];

        /** @var Product $product */
        foreach ($this->products as $product) {
            $products[] = $product->renderListing();
        }

        $template->products = $products;
    }
}
