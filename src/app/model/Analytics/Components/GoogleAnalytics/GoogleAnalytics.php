<?php

namespace Analytics\Components;

use App\Components\BaseControl;

class GoogleAnalytics extends BaseControl
{
    /** @var boolean */
    private $isDebugMode;

    /** @var string */
    private $site;

    /** @var string */
    private $key;

    public function __construct($isDebugMode, $site, $key)
    {
        parent::__construct();

        $this->isDebugMode = $isDebugMode;
        $this->site = $site;
        $this->key = $key;
    }

    public function render()
    {
        if ($this->isDebugMode) {
            return;
        }

        $template = $this->getTemplate();
        $template->site = $this->site;
        $template->key = $this->key;
        $template->setFile(__DIR__ . '/GoogleAnalytics.latte');
        $template->render();
    }
}
