<?php

namespace App\Model\Categories;

use App\Model\ORM\Attributes\SEO;
use App\Model\ORM\Attributes\UUID;
use App\Model\Products\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Nette\Object;
use Nette\Utils\ArrayHash;

/**
 * Class Category
 * @package App\Model\Categories
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @ORM\Table(name="categories")
 */
class Category extends Object
{
    use UUID;
    use SEO;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @ORM\Column(type="string",name="title",nullable=false)
     * @var string
     */
    private $title;

    /**
     * @var Product[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Model\Products\Product",inversedBy="categories")
     */
    private $products;

    /**
     * Category constructor.
     * @param string $title
     * @param Category $parent
     */
    public function __construct($title, $parent = null)
    {
        $this->title = $title;
        if ($parent instanceof Category) {
            $this->parent = $parent;
        }

        $this->products = new ArrayCollection();
    }

    public function addProduct(Product $product)
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }
    }

    public function removeProduct(Product $product)
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function render()
    {
        return ArrayHash::from([
            'title' => $this->title,
            'seo_title' => $this->seoTitle,
            'seo_description' => $this->seoDescription,
            'seo_keywords' => $this->seoKeywords,
        ]);
    }
}
