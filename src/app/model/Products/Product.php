<?php
/**
 * Created by PhpStorm.
 * (c) 2016 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Model\Products;

use App\Model\ORM\Attributes\SEO;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\UniversallyUniqueIdentifier;
use Nette\SmartObject;

/**
 * Class Product
 * @package App\Model\Products
 * @ORM\Entity()
 * @ORM\Table(name="product")
 */
class Product
{
    use SmartObject;
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

    /**
     * Product constructor.
     * @param string $name
     * @param string $description
     * @param bool $active
     */
    public function __construct($name, $description, $active)
    {
        $this->name = $name;
        $this->description = $description;
        $this->active = $active;
    }

    /**
     * @param string $name
     * @param string $description
     */
    public function changeTexts($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function changeState($newState)
    {
        $this->active = $newState ? true : false;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }



    public function toForm()
    {
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'active' => $this->active,
        ];

        $data = array_merge($data, $this->seoToForm());

        return $data;
    }
}