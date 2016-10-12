<?php

namespace App\Model\Eshop;

use App\Model\Products\Product;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\SmartObject;
use Nette\Utils\Json;

class Cart
{
    use SmartObject;

    /** @var ICartStorage */
    private $storage;

    /** @var CartItem[] */
    private $items = [];

    /** @var EntityManager */
    private $entityManager;

    /**
     * Cart constructor.
     * @param EntityManager $entityManager
     * @param ICartStorage $storage
     */
    public function __construct(EntityManager $entityManager, ICartStorage $storage)
    {
        $this->entityManager = $entityManager;
        $this->storage = $storage;
        $this->load();
    }

    public function add(Product $product, $quantity)
    {
        if (array_key_exists($product->getId(), $this->items)) {
            $item = $this->items[$product->getId()];
            $item->changeQuantity($item->getQuantity() + $quantity);
        } else {
            $item = new CartItem($product, $quantity);
            $this->items[$product->getId()] = $item;
        }

        if ($item->getQuantity() <= 0) {
            unset($this->items[$product->getId()]);
        }

        $this->save();
    }

    public function isEmpty()
    {
        return empty($this->items);
    }

    public function clear()
    {
        $this->items = [];
        $this->save();
    }

    public function getInfo()
    {
        $price = 0;
        $items = 0;

        /** @var CartItem $item */
        foreach ($this->items as $item) {
            $price += $item->getTotalPrice();
            $items += $item->getQuantity();
        }

        return [
            'price' => $price,
            'items' => $items,
        ];
    }

    public function render()
    {
        $output = [];

        /** @var CartItem $item */
        foreach ($this->items as $item) {
            $output[] = [
                'product_name' => $item->getProduct()->getName(),
                'product_price' => $item->getProduct()->getPrice(),
                'quantity' => $item->getQuantity(),
                'price' => $item->getTotalPrice(),
            ];
        }

        return $output;
    }

    private function save()
    {
        $data = Json::encode($this->items);
        $this->storage->save($data);
    }

    private function load()
    {
        /** @var EntityRepository $productRepository */
        $productRepository = $this->entityManager->getRepository(Product::class);

        $data = $this->storage->load();

        if ($data) {
            $items = Json::decode($data);

            if ($items) {
                foreach ($items as $item) {
                    // TODO zoptimalizovat
                    /** @var Product $product */
                    $product = $productRepository->find($item->id_product);

                    $this->items[$item->id_product] = new CartItem($product, $item->quantity);
                }
            }
        }
    }
}
