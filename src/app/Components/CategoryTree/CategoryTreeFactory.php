<?php

namespace App\Components\CategoryTree;

interface CategoryTreeFactory
{
    /** @return CategoryTree  */
    public function create();
}
