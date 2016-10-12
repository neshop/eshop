<?php

namespace App\Model\Eshop;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="currency")
 */
class Currency
{
    /**
     * @ORM\Column(type="string",nullable=false,unique=true)
     * @ORM\Id()
     */
    private $iso;

    /**
     * @ORM\Column(type="string",nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string",nullable=false)
     */
    private $abbr;

    /**
     * Currency constructor.
     * @param $iso
     * @param $name
     * @param $abbr
     */
    public function __construct($iso, $name, $abbr)
    {
        $this->iso = $iso;
        $this->name = $name;
        $this->abbr = $abbr;
    }

    /**
     * @return mixed
     */
    public function getAbbr()
    {
        return $this->abbr;
    }
}
