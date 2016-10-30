<?php

namespace App\FrontModule\Presenters;

use Analytics\Components\GoogleAnalyticsFactory;
use App\Components\CartInfoTrait;
use App\Model\Products\ProductSearchFactory;
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
