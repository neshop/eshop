<?php

namespace App\Components;

interface CategoryTreeFactory
{
    /** @return CategoryTree  */
    public function create();
}
