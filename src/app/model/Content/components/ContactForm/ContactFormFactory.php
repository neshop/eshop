<?php

namespace App\Components;

interface ContactFormFactory
{
    /**
     * @return ContactForm
     */
    public function create();
}
