<?php

namespace App\Components\LostPasswordForm;

use App\Components\BaseForm\BaseFormFactory;
use App\Model\Users\LostPasswordResetMessageSender;
use App\Model\Users\UserRepository;
use Kdyby\Doctrine\EntityManager;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\Strings;

class LostPasswordForm extends Control
{
    /** @var BaseFormFactory */
    private $baseFormFactory;

    /** @var UserRepository */
    private $userRepository;

    /** @var LostPasswordResetMessageSender */
    private $lostPasswordResetMessageSender;

    /** @var EntityManager */
    private $entityManager;

    public $onLostPasswordFormSuccess;
    public $onLostPasswordFormError;

    public function __construct(
        BaseFormFactory $baseFormFactory,
        UserRepository $userRepository,
        LostPasswordResetMessageSender $lostPasswordResetMessageSender,
        EntityManager $entityManager
    ) {
        parent::__construct();
        $this->baseFormFactory = $baseFormFactory;
        $this->userRepository = $userRepository;
        $this->lostPasswordResetMessageSender = $lostPasswordResetMessageSender;
        $this->entityManager = $entityManager;
    }

    public function createComponentForm()
    {
        $form = $this->baseFormFactory->create();
        $form->addText('email', 'Zadejte svůj e-mail')
            ->setType('email')
            ->addRule(Form::EMAIL, 'Zadejte prosím platný e-mail')
            ->setRequired(true);
        $form->addSubmit('send', 'Obnovit heslo');
        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    public function processForm($form, $values)
    {
        $email = Strings::normalize($values->email);

        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            $this->onLostPasswordFormError('Zadaný e-mail neznáme. Zaregistrujte se prosím.');
            return;
        }

        $user->generateLostPasswordTokenAndSend($this->lostPasswordResetMessageSender);
        $this->entityManager->flush();
        $this->onLostPasswordFormSuccess();
    }

    public function render()
    {
        $template = $this->template;
        $template->setFile(__DIR__ . '/LostPasswordForm.latte');
        $template->render();
    }
}
