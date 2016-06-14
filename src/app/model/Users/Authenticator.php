<?php
/**
 * Created by PhpStorm.
 * (c) 2016 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Model\Users;

use Nette;
use Nette\Security\AuthenticationException;

class Authenticator extends Nette\Object implements Nette\Security\IAuthenticator
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * Authenticator constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(array $credentials)
    {
        list ($email, $password) = $credentials;

        $user = $this->userRepository->findByEmail($email);
        if (!$user)
        {
            throw new AuthenticationException('Uživatel nebyl nalezen', self::IDENTITY_NOT_FOUND);
        }

        if (!$user->verifyPassword($password))
        {
            throw new AuthenticationException('Špatné heslo', self::INVALID_CREDENTIAL);
        }

        return $user;
    }

}