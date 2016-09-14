<?php
/**
 * Created by PhpStorm.
 * (c) 2016 - Josef Drabek <rydercz@gmail.com>
 */

namespace App\Components;

use App\Model\Categories\Category;
use App\Model\Eshop\Currency;
use App\Model\Products\Product;
use Doctrine\ORM\EntityManager;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Tracy\Debugger;

class ProductForm extends BaseControl
{
    /** @var BaseFormFactory */
    private $baseFormFactory;

    /** @var Product */
    private $product;

    /** @var EntityManager */
    private $entityManager;

    public $onSuccess = [];

    /** @var NestedTreeRepository */
    private $categoryRepository;

    /** @var array|Category[] */
    private $categories = [];

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
        $this->categoryRepository = $entityManager->getRepository(Category::class);
    }


    public function createComponentForm()
    {
        $form = $this->baseFormFactory->create();

        $categories = [];

        /** @var Category $category */
        foreach ($this->categoryRepository->findAll() as $category)
        {
            $this->categories[$category->getId()] = $category;
            $categories[$category->getId()] = $category->getTitle();
        }

        $form->addText('name', 'Název')
            ->setRequired(true);

        $form->addTextArea('description', 'Popisek')
            ->setRequired(true);

        $form->addTextArea('ingredients', 'Složení')
            ->setRequired(true);

        $form->addText('seoTitle', 'SEO title');
        $form->addText('seoKeywords', 'SEO keywords');
        $form->addText('seoDescription', 'SEO description');

        $form->addCheckbox('active', 'Aktivní');

        $form->addText('price', 'Cena Kč');

        $form->addMultiSelect('categories', 'Kategorie', $categories);

        $form->addSubmit('submit', 'Uložit');

        $form->onSuccess[] = [$this, 'processForm'];

        if ($this->product)
        {
            $form->setDefaults($this->product->toForm());
        }

        return $form;
    }

    public function processForm($form, $values)
    {
        /** @var Currency $currency */
        $currency = $this->entityManager->find(Currency::class, 'CZK');

        if ($this->product)
        {
            $product = $this->product;
            $product->changeTexts($values->name, $values->description, $values->ingredients);
            $product->changeState($values->active);
            $product->changePrice($values->price, $currency);
        }
        else
        {
            $product = new Product(
                $values->name,
                $values->description,
                $values->active,
                $values->ingredients,
                $values->price,
                $currency
            );
            $this->entityManager->persist($product);
        }

        $categories = [];

        foreach ($values->categories as $categoryId)
        {
            $categories[] = $this->categories[$categoryId];
        }

        $product->categorize($categories);
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