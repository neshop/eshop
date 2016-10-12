<?php

namespace App\FrontModule\Presenters;

use Analytics\Components\GoogleAnalytics;
use App\Components\CartInfoTrait;
use App\Model\Products\ProductSearchFactory;
use App\Presenters\BasePresenter;

class FrontPresenter extends BasePresenter
{
    use CartInfoTrait;

    /** @var GoogleAnalytics @inject */
    public $googleAnalytics;

    /** @var ProductSearchFactory @inject */
    public $productSearchFactory;

    public function createComponentGoogleAnalytics()
    {
        return $this->googleAnalytics;
    }

    public function createComponentProductSearch()
    {
        return $this->productSearchFactory->create();
    }
}
