<?php

namespace App\Components\ContactForm;

interface ContactFormFactory
{
    /**
     * @return ContactForm
     */
    public function create();
}
