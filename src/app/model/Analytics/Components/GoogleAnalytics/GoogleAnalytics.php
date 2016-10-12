<?php

namespace Analytics\Components;

use App\Components\BaseControl;
use Tracy\Debugger;

class GoogleAnalytics extends BaseControl
{
    /** @var boolean */
    private $isEnabled;

    /** @var string */
    private $site;

    /** @var string */
    private $key;

    public function __construct($isDebugMode, $site, $key)
    {
        parent::__construct();
        $this->isEnabled = !$isDebugMode;
        $this->site = $site;
        $this->key = $key;
    }

    public function render()
    {
        var_dump($this->isEnabled);
        if (!$this->isEnabled) {
            return;
        }

        $template = $this->getTemplate();
        $template->site = $this->site;
        $template->key = $this->key;
        $template->setFile(__DIR__ . '/GoogleAnalytics.latte');
        $template->render();
    }
}
