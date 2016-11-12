<?php

namespace App\Components\LostPasswordForm;

interface LostPasswordFormFactory
{
    /** @return LostPasswordForm */
    public function create();
}
