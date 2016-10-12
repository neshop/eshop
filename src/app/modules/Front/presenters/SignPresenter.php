<?php

namespace App\FrontModule\Presenters;

use App\Components\ChangePasswordFormFactory;
use App\Components\LoginFormFactory;
use App\Components\LostPasswordFormFactory;
use App\Components\RegistrationFormFactory;
use App\Model\Users\User;
use App\Model\Users\UserRepository;
use App\Presenters\BasePresenter;
use Kdyby\Doctrine\EntityManager;
use Nette\Application\ApplicationException;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Utils\Strings;

class SignPresenter extends FrontPresenter
{
    /** @var LoginFormFactory @inject */
    public $loginFormFactory;

    /** @var RegistrationFormFactory @inject */
    public $registrationFormFactory;

    /** @var LostPasswordFormFactory @inject */
    public $lostPasswordFormFactory;

    /** @var ChangePasswordFormFactory @inject */
    public $changePasswordFormFactory;

    /** @var UserRepository @inject */
    public $userRepository;

    /** @var EntityManager @inject */
    public $entityManager;

    /** @persistent */
    public $backlink;

    /** @var User */
    private $user;

    protected function createComponentLoginForm()
    {
        $control = $this->loginFormFactory->create();
        $control->onLoginSuccess[] = function (Form $form) {
            $this->flashMessage('Přihlášení bylo úspěšné!', 'success');
            $this->restoreRequest($this->backlink);
            $this->redirect('Homepage:');
        };
        $control->onLoginError[] = function (Form $form, AuthenticationException $e) {
            $this->flashMessage($e->getMessage(), 'danger');
        };
        return $control;
    }

    protected function createComponentRegistrationForm()
    {
        $control = $this->registrationFormFactory->create();
        $control->onRegistrationSuccess[] = function (Form $form) {
            $this->flashMessage('Registrace byla úspěšná!', 'success');
            $this->redirect('Homepage:');
        };
        $control->onRegistrationError = function (Form $form) {
            $this->flashMessage('Při registraci došlo k chybě. Zkuste to prosím později', 'danger');
        };
        $control->onRegistrationErrorUserExists = function (Form $form) {
            $this->flashMessage('Tento e-mail je již zaregistrován. Zvolte prosím jiný nebo se přihlašte', 'danger');
        };
        return $control;
    }

    protected function createComponentLostPasswordForm()
    {
        $control = $this->lostPasswordFormFactory->create();
        $control->onLostPasswordFormError = function ($message) {
            if (!Strings::length($message)) {
                $message = 'Došlo k neznámé chybě. Zkuste to prosím později';
            }
            $this->flashMessage($message, 'danger');
        };
        $control->onLostPasswordFormSuccess = function () {
            $message = 'Další informace vám byly odeslány na zadaný e-mail. Zkontrolujte prosím svůj e-mail.';
            $this->flashMessage($message, 'success');
            $this->redirect('this');
        };
        return $control;
    }

    public function actionResetPassword($token)
    {
        try {
            if (!$token) {
                throw new BadTokenException;
            }

            $user = $this->userRepository->findByLostPasswordResetToken($token);
            if (!$user) {
                throw new BadTokenException;
            }

            if (!$user->hasValidLostPasswordToken()) {
                throw new BadTokenException;
            }

            $this->user = $user;

        } catch (BadTokenException $e) {
            $this->flashMessage('Neplatný odkaz nebo vypršela platnost odkaz. Zkuste to prosím znovu.', 'danger');
            $this->redirect('Homepage:');
        }
    }

    protected function createComponentPasswordResetForm()
    {
        $control = $this->changePasswordFormFactory->create($this->user);
        $control->onSuccess = function () {
            $this->flashMessage('Vaše heslo bylo úspěšně změněno. Nyní se můžete přihlásit', 'success');
            $this->redirect('Sign:in');
        };
        return $control;
    }

    public function actionOut()
    {
        $this->getUser()->logout();
        $this->flashMessage('Odhlášení bylo úspěšné!', 'success');
        $this->redirect('Sign:in');
    }
}

class BadTokenException extends ApplicationException {}