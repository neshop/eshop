<?php

namespace App\Components;

interface RegistrationFormFactory
{
    /** @return RegistrationForm */
    public function create();
}
