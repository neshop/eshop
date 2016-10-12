<?php

namespace App\Components;

interface LoginFormFactory
{
    /** @return LoginForm */
    public function create();
}
