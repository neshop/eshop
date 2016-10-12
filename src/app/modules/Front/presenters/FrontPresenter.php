<?php

namespace App\FrontModule\Presenters;

use Analytics\Components\GoogleAnalytics;
use App\Components\CartInfoTrait;
use App\Presenters\BasePresenter;

class FrontPresenter extends BasePresenter
{
    use CartInfoTrait;

    /** @var GoogleAnalytics @inject */
    public $googleAnalytics;

    public function createComponentGoogleAnalytics()
    {
        return $this->googleAnalytics;
    }
}
