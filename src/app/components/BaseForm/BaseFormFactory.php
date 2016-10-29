<?php

namespace App\Components;

use Nette\Forms\IFormRenderer;
use Nette\Localization\ITranslator;

class BaseFormFactory
{
    /** @var IFormRenderer */
    private $renderer;

    /** @var ITranslator */
    private $translator;

    public function __construct(IFormRenderer $renderer = null, ITranslator $translator = null)
    {
        $this->renderer = $renderer;
        $this->translator = $translator;
    }

    /**
     * @return BaseForm
     */
    public function create()
    {
        $form = new BaseForm();
        $form->setRenderer($this->renderer);
        $form->setTranslator($this->translator);
        $form->addProtection('Odešlete prosím formulář znova.');

        return $form;
    }
}
