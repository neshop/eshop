<?php

namespace App\Components\ProductSearch;

use App\Components\BaseControl\BaseControl;
use App\Components\BaseForm\BaseFormFactory;
use Kdyby\Doctrine\EntityManager;
use Nette\Utils\Strings;
use Tomaj\Form\Renderer\BootstrapInlineRenderer;

class ProductSearch extends BaseControl
{
    /** @var BaseFormFactory */
    private $baseFormFactory;

    /** @var EntityManager */
    private $entityManager;

    private $searchPhrase;

    private $result;

    /**
     * ProductSearch constructor.
     * @param BaseFormFactory $baseFormFactory
     * @param EntityManager $entityManager
     */
    public function __construct(BaseFormFactory $baseFormFactory, EntityManager $entityManager)
    {
        parent::__construct();

        $this->baseFormFactory = $baseFormFactory;
        $this->entityManager = $entityManager;
    }

    public function createComponentSearchForm()
    {
        $form = $this->baseFormFactory->create();
        $form->setRenderer(new BootstrapInlineRenderer());
        $form->setAction($this->presenter->link('Product:search'));
        $form->addText('search', 'Hledat')
            ->setRequired(true);
        $form->addSubmit('submit', 'Hledat');
        $form->onSuccess[] = [$this, 'onSearch'];

        return $form;
    }

    public function onSearch($form, $values)
    {
        $searchPhrase = Strings::trim($values->search);
        $this->searchPhrase = $searchPhrase;

        $result = $this->entityManager->getRepository(Product::class)->createQueryBuilder('P')
            ->where('LOWER(P.name) LIKE :search')
            ->setParameter('search', '%' . Strings::lower($searchPhrase) . '%')
            ->getQuery()
            ->getResult();

        $this->result = $result;
    }

    public function renderForm()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ . '/ProductSearchForm.latte');
        $template->render();
    }

    public function renderResult()
    {
        $products = [];
        /** @var Product $product */
        foreach ($this->result as $product) {
            $products[] = $product->renderListing();
        }

        $template = $this->getTemplate();
        $template->searchPhrase = $this->searchPhrase;
        $template->products = $products;
        $template->setFile(__DIR__ . '/ProductSearchResult.latte');
        $template->render();
    }
}
