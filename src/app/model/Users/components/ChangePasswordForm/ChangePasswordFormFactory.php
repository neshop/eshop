<?php
/**
 * Created by PhpStorm.
 * (c) 2015 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Components;

use App\Model\Users\User;

interface ChangePasswordFormFactory
{
    /**
     * @param User $user
     * @return ChangePasswordForm
     */
    public function create(User $user);
}