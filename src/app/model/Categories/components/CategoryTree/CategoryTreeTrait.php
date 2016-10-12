<?php

namespace App\Components;

trait CategoryTreeTrait
{
    /** @var CategoryTreeFactory @inject */
    public $categoryTreeFactory;

    public function createComponentCategoryTree()
    {
        $control = $this->categoryTreeFactory->create();
        return $control;
    }
}
