<?php

namespace Torpedo\Mail;

use Torpedo\ValueObjects\Web\EmailAddress;

interface Mailer
{
    /**
     * @param EmailAddress $sender
     * @param EmailAddress $recipient
     * @param string $subject
     * @param string $body
     */
    public function sendSingleMessage(EmailAddress $sender, EmailAddress $recipient, $subject, $body);

    /**
     * @param EmailAddress $sender
     * @param EmailAddress[] $recipients
     * @param string $subject
     * @param string $body
     */
    public function sendBulkMessage(EmailAddress $sender, array $recipients, $subject, $body);
}