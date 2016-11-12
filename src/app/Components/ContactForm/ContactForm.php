<?php

namespace App\Components\ContactForm;

use App\Components\BaseControl\BaseControl;
use App\Components\BaseForm\BaseFormFactory;

class ContactForm extends BaseControl
{
    /** @var BaseFormFactory */
    private $baseFormFactory;

    /**
     * ContactForm constructor.
     * @param BaseFormFactory $baseFormFactory
     */
    public function __construct(BaseFormFactory $baseFormFactory)
    {
        parent::__construct();

        $this->baseFormFactory = $baseFormFactory;
    }


    public function createComponentForm()
    {
        $form = $this->baseFormFactory->create();
        $form->addText('name', 'Jméno');
        $form->addText('email', 'E-mail')
            ->setRequired(true);
        $form->addText('phone', 'Telefon');
        $form->addTextArea('message', 'Zpráva')
            ->setRequired(true);
        $form->addSubmit('send', 'Odeslat');

        return $form;
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ . '/ContactForm.latte');
        $template->render();
    }
}
