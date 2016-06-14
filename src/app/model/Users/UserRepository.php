<?php
/**
 * Created by PhpStorm.
 * (c) 2016 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Model\Users;

use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette;

class UserRepository extends Nette\Object
{
    /** @var EntityRepository */
    private $userRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->userRepository = $entityManager->getRepository(User::class);
    }

    /**
     * @param string $email
     * @return null|User
     */
    public function findByEmail($email)
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }

    /**
     * @param string $token
     * @return null|User
     */
    public function findByLostPasswordResetToken($token)
    {
        return $this->userRepository->findOneBy(['lostPasswordResetToken' => $token]);
    }
}