<?php

namespace App\Components\RegistrationForm;

use App\Components\BaseForm\BaseFormFactory;
use App\Model\Users\User;
use App\Model\Users\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Kdyby\Doctrine\EntityManager;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\Strings;

class RegistrationForm extends Control
{
    /** @var BaseFormFactory */
    private $baseFormFactory;

    /** @var EntityManager */
    private $entityManager;

    /** @var UserRepository */
    private $userRepository;

    public $onRegistrationError;
    public $onRegistrationErrorUserExists;
    public $onRegistrationSuccess;

    /**
     * @param BaseFormFactory $baseFormFactory
     * @param EntityManager $entityManager
     * @param UserRepository $userRepository
     */
    public function __construct(
        BaseFormFactory $baseFormFactory,
        EntityManager $entityManager,
        UserRepository $userRepository
    ) {
        parent::__construct();

        $this->baseFormFactory = $baseFormFactory;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    protected function createComponentForm()
    {
        $form = $this->baseFormFactory->create();

        $form->addText('email', 'E-mail')
            ->setType('email')
            ->setRequired()
            ->addRule(Form::EMAIL, 'Zadejte prosím platný e-mail');

        $form->addPassword('password', 'Heslo')
            ->setRequired()
            ->addRule(Form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků', 6);

        $form->addPassword('passwordVerify', 'Heslo znova')
            ->setRequired()
            ->addRule(Form::EQUAL, 'Hesla musí být stejná', $form['password']);


        $form->addSubmit('send', 'Registrovat');

        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    public function processForm($form, $values)
    {
        try {
            $email = Strings::normalize($values['email']);

            $user = new User($email, $values['password']);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->onRegistrationSuccess($form);
        } catch (UniqueConstraintViolationException $e) {
            $this->onRegistrationErrorUserExists($form);
        }
    }

    public function render()
    {
        $template = $this->template;
        $template->setFile(__DIR__ . '/RegistrationForm.latte');
        $template->render();
    }
}
