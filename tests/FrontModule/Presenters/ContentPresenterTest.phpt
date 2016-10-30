<?php

namespace Test\FrontModule\Presenters;

use Testbench\TPresenter;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

class ContentPresenterTest extends TestCase
{
    use TPresenter;

    public function testRenderDefault()
    {
        $this->checkAction('Front:Content:contact');
    }
}

(new ContentPresenterTest())->run();
