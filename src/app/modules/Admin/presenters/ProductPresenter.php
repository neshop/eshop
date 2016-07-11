<?php
/**
 * Created by PhpStorm.
 * (c) 2016 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\AdminModule\Presenters;

use App\Components\ProductFormFactory;
use App\Presenters\SecuredPresenter;

class ProductPresenter extends SecuredPresenter
{
    /** @var ProductFormFactory @inject */
    public $productFormFactory;

    protected function createComponentProductForm()
    {
        $control = $this->productFormFactory->create(null);
        $control->onSuccess[] = function ($form, $product) {
            $this->flashMessage('Produkt byl úspěšně vytvořen.', 'success');
            $this->redirect('this');
        };

        return $control;
    }
}