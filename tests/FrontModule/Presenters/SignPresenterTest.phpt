<?php

namespace Test\FrontModule\Presenters;

use Testbench\TPresenter;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

class SignPresenterTest extends TestCase
{
    use TPresenter;

    public function testRenderIn()
    {
        $this->checkAction('Front:Sign:in');
    }

    public function testRenderUp()
    {
        $this->checkAction('Front:Sign:up');
    }

    public function testRenderLostPassword()
    {
        $this->checkAction('Front:Sign:lostPassword');
    }
}

(new SignPresenterTest())->run();
