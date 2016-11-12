<?php

namespace App\Components\RegistrationForm;

interface RegistrationFormFactory
{
    /** @return RegistrationForm */
    public function create();
}
