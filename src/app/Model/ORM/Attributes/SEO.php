<?php

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

    public function setSEO($title, $keywords, $description)
    {
        $this->seoTitle = $title;
        $this->seoKeywords = $keywords;
        $this->seoDescription = $description;
    }

    protected function seoToForm()
    {
        return [
            'seoTitle' => $this->seoTitle,
            'seoKeywords' => $this->seoKeywords,
            'seoDescription' => $this->seoDescription,
        ];
    }
}
