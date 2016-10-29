<?php

namespace App\FrontModule\Presenters;

use App\Components\ContactFormFactory;

class ContentPresenter extends FrontPresenter
{
    /** @var ContactFormFactory @inject */
    public $contactFormFactory;

    public function createComponentContactForm()
    {
        return $this->contactFormFactory->create();
    }
}
