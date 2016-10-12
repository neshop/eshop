<?php

namespace App\Components;

use Nette\Application\UI\Form;
use Nette\Forms\IFormRenderer;
use Nette\Localization\ITranslator;

class BaseForm extends BaseControl implements BaseFormFactory
{
    /** @var IFormRenderer */
    private $renderer;

    /** @var ITranslator */
    private $translator;

    public function __construct(IFormRenderer $renderer = null, ITranslator $translator = null)
    {
        parent::__construct();

        $this->renderer = $renderer;
        $this->translator = $translator;
    }

    /**
     * @return BaseForm
     */
    public function create()
    {
        $form = new Form();
        $form->setRenderer($this->renderer);
        $form->setTranslator($this->translator);
        $form->addProtection('Odešlete prosím formulář znova.');

        return $form;
    }
}
