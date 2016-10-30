<?php

namespace Analytics\Components;

use Nette\SmartObject;

class GoogleAnalyticsFactory
{
    use SmartObject;

    /** @var boolean */
    private $isDebugMode;

    /** @var string */
    private $site;

    /** @var string */
    private $key;

    public function __construct($isDebugMode, $site, $key)
    {
        $this->isDebugMode = $isDebugMode;
        $this->site = $site;
        $this->key = $key;
    }

    /** @return GoogleAnalytics */
    public function create()
    {
        return new GoogleAnalytics($this->isDebugMode, $this->site, $this->key);
    }
}
