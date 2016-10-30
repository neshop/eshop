<?php

namespace Test\Model\Eshop;

require_once __DIR__ . '/../../bootstrap.php';

use App\Model\Eshop\Delivery;
use Nette\Application\ApplicationException;
use Nette\InvalidArgumentException;
use Testbench\TCompiledContainer;
use Tester\Assert;
use Tester\TestCase;

class DeliveryTest extends TestCase
{
    use TCompiledContainer;

    protected function setUp()
    {
        parent::setUp();
        $this->getContainer();
    }

    public function testCreate()
    {
        $delivery = new Delivery('xxx', 'Delivery');
        Assert::type(Delivery::class, $delivery);

        Assert::exception(function () {
            new Delivery(null, 'Delivery');
        }, InvalidArgumentException::class);

        Assert::exception(function () {
            new Delivery('xxx', null);
        }, InvalidArgumentException::class);

        Assert::exception(function () use ($delivery) {
            $x = clone $delivery;
        }, ApplicationException::class);
    }
}

(new DeliveryTest())->run();
