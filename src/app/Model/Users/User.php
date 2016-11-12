<?php

namespace App\Model\Users;

use App\Model\Users\LostPasswordResetMessageSender;
use App\Model\ORM\Attributes\UUID;
use Doctrine\ORM\Mapping as ORM;
use Nette;
use Nette\Utils\DateTime;
use Nette\Utils\Random;

/**
 * Class User
 * @package App\Model\Users
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends Nette\Object implements Nette\Security\IIdentity
{
    use UUID;

    /**
     * @var string
     * @ORM\Column(name="email",type="string",length=255,unique=true,nullable=false)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="password",type="string",length=100,nullable=false)
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(name="lost_password_reset_token",type="string",length=100,unique=true,nullable=true)
     */
    protected $lostPasswordResetToken;

    /**
     * @var DateTime
     * @ORM\Column(name="lost_password_reset_token_life_time",type="datetime",nullable=true)
     */
    protected $lostPasswordResetTokenLifeTime;

    /**
     * User constructor.
     * @param string $email
     * @param string $password
     */
    public function __construct($email, $password)
    {
        $this->setEmail($email);
        $this->setPassword($password);
    }

    protected function setEmail($email)
    {
        $email = Nette\Utils\Strings::normalize($email);
        if (!Nette\Utils\Validators::isEmail($email)) {
            throw new \InvalidArgumentException;
        }
        $this->email = $email;
    }

    protected function setPassword($password)
    {
        $this->password = Nette\Security\Passwords::hash($password);
    }

    public function verifyPassword($password)
    {
        return Nette\Security\Passwords::verify($password, $this->password);
    }

    /**
     * @param LostPasswordResetMessageSender $lostPasswordResetMessageSender
     */
    public function generateLostPasswordTokenAndSend(LostPasswordResetMessageSender $lostPasswordResetMessageSender)
    {
        $token = Random::generate(40, '0-9a-zA-Z');
        $lifeTime = new DateTime();
        $lifeTime->modify('+24hour');

        $this->lostPasswordResetToken = $token;
        $this->lostPasswordResetTokenLifeTime = $lifeTime;

        $lostPasswordResetMessageSender->send($this);
    }

    /**
     * @param string $newPassword
     */
    public function changePassword($newPassword)
    {
        $this->setPassword($newPassword);
        $this->lostPasswordResetToken = null;
        $this->lostPasswordResetTokenLifeTime = null;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getLostPasswordResetToken()
    {
        return $this->lostPasswordResetToken;
    }

    /**
     * @return bool
     */
    public function hasValidLostPasswordToken()
    {
        return (
            !is_null($this->lostPasswordResetTokenLifeTime)
            && $this->lostPasswordResetTokenLifeTime > new DateTime()
        );
    }

    public function getRoles()
    {
        return [];
    }
}
