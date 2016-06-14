<?php
/**
 * Created by PhpStorm.
 * (c) 2016 - Josef Drabek <rydercz@gmail.com>
 */

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