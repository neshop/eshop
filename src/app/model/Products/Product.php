<?php
/**
 * Created by PhpStorm.
 * (c) 2016 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Model\Products;

use App\Model\Eshop\Currency;
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
     * @ORM\Column(type="text",name="ingredients",nullable=true)
     * @var string
     */
    private $ingredients;

    /**
     * @ORM\Column(type="boolean",name="is_active",nullable=false)
     * @var boolean
     */
    private $active;

    /**
     * @ORM\Column(type="float",name="price",nullable=false)
     * @var float
     */
    private $price;

    /**
     * @var Currency
     * @ORM\ManyToOne(targetEntity="App\Model\Eshop\Currency")
     * @ORM\JoinColumn(name="id_currency", referencedColumnName="iso")
     */
    private $currency;

    /**
     * Product constructor.
     * @param string $name
     * @param string $description
     * @param bool $active
     * @param string $ingredients
     * @param float $price
     * @param Currency $currency
     */
    public function __construct($name, $description, $active, $ingredients, $price, Currency $currency)
    {
        $this->name = $name;
        $this->description = $description;
        $this->active = $active;
        $this->ingredients = $ingredients;
        $this->price = $price;
        $this->currency = $currency;
    }

    /**
     * @param string $name
     * @param string $description
     * @param string $ingredients
     */
    public function changeTexts($name, $description, $ingredients)
    {
        $this->name = $name;
        $this->description = $description;
        $this->ingredients = $ingredients;
    }

    public function changeState($newState)
    {
        $this->active = $newState ? true : false;
    }

    public function changePrice($price, Currency $currency)
    {
        $this->price = $price;
        $this->currency = $currency;
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

    public function getPrice()
    {
        return $this->price;
    }

    public function getCurrency()
    {
        return $this->currency;
    }


    public function toForm()
    {
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'active' => $this->active,
            'ingredients' => $this->ingredients,
            'price' => $this->price,
        ];

        $data = array_merge($data, $this->seoToForm());

        return $data;
    }
}