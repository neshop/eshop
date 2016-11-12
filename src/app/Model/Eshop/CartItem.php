<?php

namespace App\Model\Eshop;

use App\Model\Products\Product;

class CartItem implements \JsonSerializable
{
    /** @var Product */
    private $product;

    /** @var int */
    private $quantity;

    /**
     * CartItem constructor.
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, $quantity)
    {
        $this->product = $product;
        $this->changeQuantity($quantity);
    }

    /**
     * @param int $newQuantity
     */
    public function changeQuantity($newQuantity)
    {
        if ($newQuantity <= 0) {
            throw new \InvalidArgumentException;
        }

        $this->quantity = $newQuantity;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getTotalPrice()
    {
        return $this->quantity * $this->product->getPrice();
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    public function jsonSerialize()
    {
        return [
            'productId' => $this->product->getId(),
            'quantity' => $this->quantity,
        ];
    }
}
