<?php

namespace App\Presenters;

use App\Model\Users\User;
use Nette\Application\UI\Presenter;
use Nette\Security\IIdentity;

abstract class BasePresenter extends Presenter
{
    /**
     * @return IIdentity|User|NULL
     */
    protected function getUserEntity()
    {
        return $this->getUser()->getIdentity();
    }
}
