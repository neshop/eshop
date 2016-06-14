<?php
/**
 * Created by PhpStorm.
 * (c) 2015 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Presenters;

use Nette;

abstract class SecuredPresenter extends BasePresenter
{
    /**
     * Checks authorization.
     * @return void
     */
    public function checkRequirements($element)
    {
        parent::checkRequirements($element);

        if (!$this->getUser()->isLoggedIn()) {

            if ($this->getUser()->getLogoutReason() == Nette\Security\IUserStorage::INACTIVITY) {
                $this->flashMessage('Došlo k odhlášení z důvodu dlouhé neaktivity. Přihlašte se prosím znova.', 'info');
            }

            $this->redirect('Sign:in', array(
                'backlink' => $this->storeRequest()
            ));
        }
    }
}