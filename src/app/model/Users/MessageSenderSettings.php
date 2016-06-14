<?php

namespace App\Model;

use Nette;

class MessageSenderSettings extends Nette\Object
{
    /** @var string */
    private $fromName;

    /** @var string */
    private $fromEmail;

    /** @var string */
    private $templateDir;

    /**
     * MessageSenderSettings constructor.
     * @param string $fromName
     * @param string $fromEmail
     * @param string $templateDir
     */
    public function __construct($fromName, $fromEmail, $templateDir)
    {
        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
        $this->templateDir = $templateDir;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * @return string
     */
    public function getTemplateDir()
    {
        return $this->templateDir;
    }

}