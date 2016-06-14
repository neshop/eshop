<?php
/**
 * Created by PhpStorm.
 * (c) 2015 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Components;


interface LostPasswordFormFactory
{
    /** @return LostPasswordForm */
    public function create();
}