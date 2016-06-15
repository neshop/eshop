<?php
/**
 * Created by PhpStorm.
 * (c) 2016 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Model\Products;

use App\Model\ORM\Attributes\SEO;
use Doctrine\ORM\Mapping AS ORM;
use Kdyby\Doctrine\Entities\Attributes\UniversallyUniqueIdentifier;

/**
 * Class Product
 * @package App\Model\Products
 * @ORM\Entity()
 * @ORM\Table(name="product")
 */
class Product
{
    use UniversallyUniqueIdentifier;
    use SEO;

    /**
     * @ORM\Column(type="string",name="name",nullable=false)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="text",name="description",nullable=true)
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="boolean",name="is_active",nullable=false)
     * @var boolean
     */
    private $active;
}