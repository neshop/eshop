<?php

namespace App\Components;

use Nette\Application\UI\Control;
use Nette\Forms\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\User;

class LoginForm extends Control
{
    /** @var User */
    private $user;

    /** @var BaseFormFactory */
    private $baseFormFactory;

    public $onLoginSuccess;
    public $onLoginError;

    public function __construct(BaseFormFactory $baseFormFactory, User $user)
    {
        parent::__construct();
        $this->baseFormFactory = $baseFormFactory;
        $this->user = $user;
    }

    protected function createComponentForm()
    {
        $form = $this->baseFormFactory->create();

        $form->addText('email', 'E-mail')
            ->setRequired('Vyplňte prosím platný e-mail')
            ->addRule(Form::EMAIL, 'Vyplňte prosím platný e-mail');

        $form->addPassword('password', 'Heslo')
            ->setRequired('Vyplňte prosím heslo');

        $form->addSubmit('send', 'Přihlásit se');

        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    public function processForm($form, $values)
    {
        try {
            $this->user->login($values['email'], $values['password']);
            $this->onLoginSuccess($form);
        } catch (AuthenticationException $e) {
            $this->onLoginError($form, $e);
        }
    }

    public function render()
    {
        $template = $this->template;
        $template->setFile(__DIR__ . '/LoginForm.latte');
        $template->render();
    }
}
