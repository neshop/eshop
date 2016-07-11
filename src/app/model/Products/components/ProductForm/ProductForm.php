<?php
/**
 * Created by PhpStorm.
 * (c) 2016 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Components;

use App\Model\Products\Product;
use Doctrine\ORM\EntityManager;

class ProductForm extends BaseControl
{
    /** @var BaseFormFactory */
    private $baseFormFactory;

    /** @var Product */
    private $product;

    /** @var EntityManager */
    private $entityManager;

    public $onSuccess = [];

    /**
     * ProductForm constructor.
     * @param BaseFormFactory $baseFormFactory
     * @param EntityManager $entityManager
     * @param Product $product
     */
    public function __construct(BaseFormFactory $baseFormFactory, EntityManager $entityManager, Product $product = null)
    {
        parent::__construct();

        $this->baseFormFactory = $baseFormFactory;
        $this->entityManager = $entityManager;
        $this->product = $product;
    }


    public function createComponentForm()
    {
        $form = $this->baseFormFactory->create();

        $form->addText('name', 'Název')
            ->setRequired(true);

        $form->addTextArea('description', 'Popisek')
            ->setRequired(true);

        $form->addText('seoTitle', 'SEO title');
        $form->addText('seoKeywords', 'SEO keywords');
        $form->addText('seoDescription', 'SEO description');

        $form->addCheckbox('active', 'Aktivní');

        $form->addText('price', 'Cena Kč');

        $form->addSubmit('submit', 'Uložit');

        $form->onSuccess[] = [$this, 'processForm'];

        if ($this->product)
        {
            $form->setValues($this->product->toForm());
        }

        return $form;
    }

    public function processForm($form, $values)
    {
        if ($this->product)
        {
            $product = $this->product;
        }
        else
        {
            $product = new Product($values->name, $values->description, $values->active);
            $this->entityManager->persist($product);
        }

        $product->setSEO($values->seoTitle, $values->seoKeywords, $values->seoDescription);

        $this->entityManager->flush();

        $this->onSuccess($form, $product);
    }

    public function render()
    {
        $template = $this->template;
        $template->setFile(__DIR__ . '/ProductForm.latte');
        $template->render();
    }
}