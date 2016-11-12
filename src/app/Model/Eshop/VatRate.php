<?php

namespace App\Model\Eshop;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\UniversallyUniqueIdentifier;
use Nette\SmartObject;

/**
 * Class VatRate
 * @package App\Model\Eshop
 * @ORM\Entity
 * @ORM\Table(name="vat_rate")
 */
class VatRate
{
    use SmartObject;
    use UniversallyUniqueIdentifier;

    /**
     * @var string
     * @ORM\Column(name="name",type="string",length=255,nullable=false)
     */
    private $name;

    /**
     * @var float
     * @ORM\Column(type="float",nullable=false)
     */
    private $rate;
}
