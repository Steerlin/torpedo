<?php

namespace Torpedo\Mail;

use Swift_Mailer;
use Swift_Mime_Message;
use Torpedo\ValueObjects\Web\EmailAddress;

class SwiftMailer implements Mailer
{
    /**
     * @var Swift_Mailer
     */
    private $mailHandler;

    /**
     * SwiftMailer constructor.
     * @param Swift_Mailer $mailHandler
     */
    public function __construct(\Swift_Mailer $mailHandler)
    {
        $this->mailHandler = $mailHandler;
    }

    /**
     * @param EmailAddress $sender
     * @param EmailAddress $recipient
     * @param string $subject
     * @param string $body
     */
    public function sendSingleMessage(EmailAddress $sender, EmailAddress $recipient, $subject, $body)
    {
        $this->sendBulkMessage($sender, [$recipient], $subject, $body);
    }

    /**
     * @param EmailAddress $sender
     * @param EmailAddress[] $recipients
     * @param string $subject
     * @param string $body
     */
    public function sendBulkMessage(EmailAddress $sender, array $recipients, $subject, $body)
    {
        $stringRecipients = array_map(
            function (EmailAddress $emailAddress) {
                return (string)$emailAddress;
            },
            $recipients
        );

        /** @var Swift_Mime_Message $message */
        $message = $this->mailHandler->createMessage();
        $message->setFrom((string)$sender);
        $message->setTo($stringRecipients);
        $message->setBody($body);
        $this->mailHandler->send($message);
    }
}