<?php

namespace App\Model\Eshop;

interface ICartStorage
{
    public function save($data);

    public function load();
}