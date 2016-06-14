<?php
/**
 * Created by PhpStorm.
 * (c) 2015 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Components;

use Nette\Application\UI\Form;

interface BaseFormFactory
{
    /**
     * @return Form
     */
    public function create();
}