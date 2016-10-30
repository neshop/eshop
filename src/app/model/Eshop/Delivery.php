<?php

namespace App\Model\Eshop;

use Doctrine\ORM\Mapping as ORM;
use Nette\Application\ApplicationException;
use Nette\InvalidArgumentException;
use Nette\SmartObject;

/**
 * Class Delivery
 * @package App\Model\Eshop
 * @ORM\Entity()
 */
class Delivery
{
    use SmartObject;

    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(name="id",type="string")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name",type="string",nullable=false)
     */
    private $name;

    /**
     * Delivery constructor.
     * @param string $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('$id cannot be empty');
        }

        if (empty($name)) {
            throw new InvalidArgumentException('$name cannot be empty');
        }

        $this->id = $id;
        $this->name = $name;
    }

    public function __clone()
    {
        throw new ApplicationException('Cannot clone delivery entity');
    }
}
