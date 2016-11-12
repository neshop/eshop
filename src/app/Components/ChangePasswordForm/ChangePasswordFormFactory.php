<?php

namespace App\Components\ChangePasswordForm;

use App\Model\Users\User;

interface ChangePasswordFormFactory
{
    /**
     * @param User $user
     * @return ChangePasswordForm
     */
    public function create(User $user);
}
