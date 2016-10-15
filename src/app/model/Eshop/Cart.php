<?php

namespace App\Model\Eshop;

use App\Model\Products\Product;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;
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

    public function setQuantity($productId, $quantity)
    {
        if (array_key_exists($productId, $this->items)) {
            if ($quantity <= 0) {
                unset($this->items[$productId]);
            } else {
                $item = $this->items[$productId];
                $item->changeQuantity($quantity);
            }

            $this->save();
        }
    }

    public function add(Product $product, $quantity)
    {
        $productId = (string) $product->getId();

        if (array_key_exists($productId, $this->items)) {
            $item = $this->items[$productId];
            $item->changeQuantity($item->getQuantity() + $quantity);
        } else {
            $item = new CartItem($product, $quantity);
            $this->items[$productId] = $item;
        }

        if ($item->getQuantity() <= 0) {
            unset($this->items[$productId]);
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
            $output[] = ArrayHash::from([
                'productId' => (string) $item->getProduct()->getId(),
                'productName' => $item->getProduct()->getName(),
                'productPrice' => $item->getProduct()->getPrice(),
                'quantity' => $item->getQuantity(),
                'price' => $item->getTotalPrice(),
            ]);
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
                    $product = $productRepository->find($item->productId);

                    $this->items[$item->productId] = new CartItem($product, $item->quantity);
                }
            }
        }
    }
}
