<?php

namespace App\Model;

use App\Model\Users\User;
use Nette;

class LostPasswordResetMessageSender extends Nette\Object
{
    /** @var Nette\Application\UI\ITemplateFactory */
    private $templateFactory;

    /** @var Nette\Mail\IMailer */
    private $mailer;

    /** @var Nette\Application\LinkGenerator */
    private $linkGenerator;

    /** @var MessageSenderSettings */
    private $messageSenderSettings;

    /**
     * @param Nette\Application\UI\ITemplateFactory $templateFactory
     * @param Nette\Application\LinkGenerator $linkGenerator
     * @param MessageSenderSettings $messageSenderSettings
     * @param Nette\Mail\IMailer $mailer
     */
    public function __construct(
        Nette\Application\UI\ITemplateFactory $templateFactory,
        Nette\Application\LinkGenerator $linkGenerator,
        MessageSenderSettings $messageSenderSettings,
        Nette\Mail\IMailer $mailer
    ) {
        $this->messageSenderSettings = $messageSenderSettings;
        $this->templateFactory = $templateFactory;
        $this->linkGenerator = $linkGenerator;
        $this->mailer = $mailer;
    }

    /**
     * @param User $user
     */
    public function send(User $user)
    {
        $template = $this->templateFactory->createTemplate();
        $template->setFile($this->messageSenderSettings->getTemplateDir() . 'LostPasswordResetMessage.latte');
        $template->_control = $this->linkGenerator;
        $template->token = $user->getLostPasswordResetToken();


        $message = new Nette\Mail\Message();
        $message->setFrom($this->messageSenderSettings->getFromEmail(), $this->messageSenderSettings->getFromName());
        $message->setSubject('Zapomenuté heslo');
        $message->addTo($user->getEmail());
        $message->setHtmlBody($template);

        $this->mailer->send($message);
    }
}
