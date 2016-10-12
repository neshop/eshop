<?php

namespace App\Components;

use Nette\Application\UI\Form;

interface BaseFormFactory
{
    /**
     * @return Form
     */
    public function create();
}
