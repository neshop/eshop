<?php

namespace App\FrontModule\Presenters;

use App\Components\CartInfo\CartInfoTrait;
use App\Components\GoogleAnalytics\GoogleAnalyticsFactory;
use App\Components\ProductSearch\ProductSearchFactory;
use App\Presenters\BasePresenter;

class FrontPresenter extends BasePresenter
{
    use CartInfoTrait;

    /** @var GoogleAnalyticsFactory @inject */
    public $googleAnalyticsFactory;

    /** @var ProductSearchFactory @inject */
    public $productSearchFactory;

    public function createComponentGoogleAnalytics()
    {
        return $this->googleAnalyticsFactory->create();
    }

    public function createComponentProductSearch()
    {
        return $this->productSearchFactory->create();
    }
}
