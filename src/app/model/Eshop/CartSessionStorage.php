<?php

namespace App\Model\Eshop;

use Nette\Http\Session;
use Nette\SmartObject;

class CartSessionStorage implements ICartStorage
{
    use SmartObject;

    /** @var \Nette\Http\SessionSection */
    private $sessionSection;

    /**
     * CartSessionStorage constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->sessionSection = $session->getSection('eshop.cart');
    }

    public function save($data)
    {
        $this->sessionSection->items = $data;
    }

    public function load()
    {
        return $this->sessionSection->items;
    }
}