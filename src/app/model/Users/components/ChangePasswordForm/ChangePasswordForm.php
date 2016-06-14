<?php

namespace App\Components;

use App\Model\Users\User;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Nette\Application\UI\Form;


class ChangePasswordForm extends Nette\Application\UI\Control
{
    /** @var BaseFormFactory */
    private $baseFormFactory;

    /** @var EntityManager */
    private $entityManager;

    /** @var User */
    private $user;

    public $onSuccess;

    /**
     * ChangePasswordForm constructor.
     * @param BaseFormFactory $baseFormFactory
     * @param EntityManager $entityManager
     * @param User $user
     */
    public function __construct(User $user, BaseFormFactory $baseFormFactory, EntityManager $entityManager)
    {
        parent::__construct();

        $this->baseFormFactory = $baseFormFactory;
        $this->entityManager = $entityManager;
        $this->user = $user;
    }

    protected function createComponentForm()
    {
        $form = $this->baseFormFactory->create();
        $form->addPassword('password', 'Nové heslo')
            ->setRequired()
            ->addRule(Form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků', 6);

        $form->addPassword('passwordVerify', 'Nové heslo znova')
            ->setRequired()
            ->addRule(Form::EQUAL, 'Hesla musí být stejná', $form['password']);

        $form->addSubmit('send', 'Změnit heslo');

        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    public function processForm(Form $form, $values)
    {
        $this->user->changePassword($values->password);
        $this->entityManager->flush();

        $this->onSuccess();
    }

    public function render()
    {
        $template = $this->template;
        $template->setFile(__DIR__ . '/ChangePasswordForm.latte');
        $template->render();
    }
}