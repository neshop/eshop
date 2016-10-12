<?php

namespace App\AdminModule\Presenters;

use App\Components\ProductFormFactory;
use App\Model\Products\Product;
use App\Presenters\SecuredPresenter;
use Kdyby\Doctrine\EntityManager;
use Ublaboo\DataGrid\DataGrid;

class ProductPresenter extends SecuredPresenter
{
    /** @var ProductFormFactory @inject */
    public $productFormFactory;

    /** @var EntityManager @inject */
    public $entityManager;

    /** @var Product */
    private $product;

    public function actionEditProduct($id)
    {
        $repository = $this->entityManager->getRepository(Product::class);
        $this->product = $repository->find($id);
    }

    protected function createComponentProductForm()
    {
        $control = $this->productFormFactory->create($this->product);
        $control->onSuccess[] = function ($form, $product) {
            $this->flashMessage('Produkt byl úspěšně vytvořen.', 'success');
            $this->redirect('this');
        };

        return $control;
    }

    protected function createComponentProductGrid($name)
    {
        //DataGrid::$icon_prefix = 'glyphicon glyphicon-';

        $grid = new DataGrid($this, $name);

        $repository = $this->entityManager->getRepository(Product::class);

        $grid->setDataSource($repository->createQueryBuilder('p'));

        $grid->addColumnText('name', 'Název')
            ->setSortable(true);

        $grid->addColumnNumber('price', 'Cena CZK')
            ->setSortable(true);

        $grid->addColumnStatus('active', 'Stav')
            ->setSortable(true)
            ->setCaret(false)
            ->addOption(1, 'Aktivní')
                ->setIcon('check')
                ->setClass('btn-success')
            ->endOption()
            ->addOption(0, 'Neaktivní')
                ->setIcon('close')
                ->setClass('btn-danger')
            ->endOption()
            ->onChange[] = [$this, 'changeStatus'];

        $grid->addAction('edit', 'Upravit', 'Product:editProduct')
            ->setClass('btn btn-default')
            ->setIcon('pencil');

        return $grid;
    }

    public function changeStatus($id, $newState)
    {
        $repository = $this->entityManager->getRepository(Product::class);
        $product = $repository->find($id);

        $product->changeState($newState);

        $this->entityManager->flush();

        $this->flashMessage('Stav položky byl úspěšně změněn.', 'success');

        if ($this->isAjax()) {
            $this->redrawControl('flashes');
            $this['productGrid']->redrawItem($id);
        }
    }
}
