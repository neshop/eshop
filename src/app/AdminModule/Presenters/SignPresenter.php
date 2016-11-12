<?php

namespace App\AdminModule\Presenters;

use App\Components\LoginForm\LoginFormFactory;
use App\Presenters\BasePresenter;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

class SignPresenter extends BasePresenter
{
    /** @var LoginFormFactory @inject */
    public $loginFormFactory;

    /** @persistent */
    public $backlink;

    protected function createComponentLoginForm()
    {
        $control = $this->loginFormFactory->create();
        $control->onLoginSuccess[] = function (Form $form) {
            $this->flashMessage('Přihlášení bylo úspěšné!', 'success');
            $this->restoreRequest($this->backlink);
            $this->redirect('Dashboard:');
        };
        $control->onLoginError[] = function (Form $form, AuthenticationException $e) {
            $this->flashMessage($e->getMessage(), 'danger');
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
