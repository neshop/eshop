<?php

namespace App\Components;

use Nette\Forms\Form;

class BuyForm extends BaseControl
{
    /** @var BaseFormFactory */
    private $baseFormFactory;

    /**
     * BuyForm constructor.
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

        $form->addGroup('Objednávka');
        $form->addInteger('count', 'Počet')
            ->setDefaultValue(1)
            ->setRequired('Vyplňte prosím, kolik chcete kusů')
            ->addRule(Form::RANGE, 'Je možné zakoupit 1-5 kusů', [1, 5]);


        $form->addGroup('Kontaktní údaje');

        $form->addText('email', 'E-mail')
            ->setType('email')
            ->setDefaultValue('@')
            ->setRequired('Vložte prosím platný e-mail.')
            ->addRule(Form::EMAIL, 'Vložte prosím platný e-mail.');

        $form->addText('phone', 'Telefon')
            ->setType('phone')
            ->setRequired('Vložte prosím telefonní číslo.');

        $form->addText('ico', 'IČ');
        $form->addText('dic', 'DIČ');


        $form->addGroup('Doručovací adresa');

        $deliveryAddress = $form->addContainer('deliveryAddress');
        $deliveryAddress->addText('name', 'Jméno a příjmení')
            ->setRequired(true);
        
        $deliveryAddress->addText('street', 'Ulice včetně ČP')
            ->setRequired(true);
        
        $deliveryAddress->addText('city', 'Město')
            ->setRequired(true);
        
        $deliveryAddress->addText('postal', 'PSČ')
            ->setRequired(true);

        $form->addCheckbox('some_address', 'Fakturační adresa je stejná jako doručovací')
            ->setDefaultValue(true)
            ->addCondition(Form::EQUAL, true)
            ->toggle('invoiceAddress', false);


        $form->addGroup('Fakturační adresa');

        $invoiceAddress = $form->addContainer('invoiceAddress');
        $invoiceAddress->addText('name', 'Jméno a příjmení')
            ->setRequired(true);


        $invoiceAddress->addText('street', 'Ulice včetně ČP')
            ->setRequired(true);

        $invoiceAddress->addText('city', 'Město')
            ->setRequired(true);

        $invoiceAddress->addText('postal', 'PSČ')
            ->setRequired(true);
        

        $form->addSubmit('submit', 'Odeslat');

        return $form;
    }

    public function render()
    {
        $template = $this->template;
        $template->setFile(__DIR__ . '/BuyForm.latte');
        $template->render();
    }
}
