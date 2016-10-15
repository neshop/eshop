<?php

namespace App\Model\ORM\Attributes;

use Doctrine\ORM\Mapping as ORM;

trait UUID
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @var string
     */
    private $id;

    /**
     * @return string
     */
    final public function getId()
    {
        return $this->id;
    }

    public function __clone()
    {
        $this->id = null;
    }
}
