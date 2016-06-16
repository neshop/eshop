<?php

namespace App\FrontModule\Presenters;

use App\Model\Categories\Category;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Kdyby\Doctrine\EntityManager;
use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /** @var EntityManager @inject */
    //public $entityManager;

    public function actionDefault()
    {
        /*
        $food = new Category('Food');
        $fruits = new Category('Fruits', $food);
        $vegetables = new Category('Vegetables', $food);

        $oranges = new Category('Oranges', $fruits);
        $bananas = new Category('Bananas', $fruits);

        $carrots = new Category('Carrots', $vegetables);
        $potatoes = new Category('Potatoes', $vegetables);

        $this->entityManager->persist($food);
        $this->entityManager->persist($fruits);
        $this->entityManager->persist($vegetables);

        $this->entityManager->persist($oranges);
        $this->entityManager->persist($bananas);

        $this->entityManager->persist($carrots);
        $this->entityManager->persist($potatoes);

        $this->entityManager->flush();
        */
    }

    public function renderDefault()
    {
        /** @var NestedTreeRepository $repo */
        /*
        $repo = $this->entityManager->getRepository(Category::class);
        $htmlTree = $repo->childrenHierarchy(
            null,
            false,
            array(
                'decorate' => true,
                'representationField' => 'slug',
                'html' => true,
            )
        );

        echo $htmlTree;
        */
    }
}
