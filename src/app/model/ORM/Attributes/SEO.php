<?php
/**
 * Created by PhpStorm.
 * (c) 2016 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Model\ORM\Attributes;

use Doctrine\ORM\Mapping as ORM;

trait SEO
{
    /**
     * @ORM\Column(type="string",name="seo_description",nullable=true)
     * @var string
     */
    private $seoDescription;

    /**
     * @ORM\Column(type="string",name="seo_keywords",nullable=true)
     * @var string
     */
    private $seoKeywords;

    /**
     * @ORM\Column(type="string",name="seo_title",nullable=true)
     * @var string
     */
    private $seoTitle;
}
