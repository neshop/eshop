<?php

namespace App\Model\Customers;

use App\Model\ORM\Attributes\UUID;
use App\Model\Users\User;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers")
 */
class Customer
{
    use UUID;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Model\Users\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(name="name",type="text")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="surname",type="text")
     */
    private $surname;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;

    /**
     * Customer constructor.
     * @param User $user
     * @param string $name
     * @param string $surname
     */
    public function __construct(User $user, $name, $surname)
    {
        $this->user = $user;
        $this->name = $name;
        $this->surname = $surname;
        $this->createdAt = new DateTime();
    }
}
