<?php

namespace App\Components;

interface LostPasswordFormFactory
{
    /** @return LostPasswordForm */
    public function create();
}
