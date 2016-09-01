<?php

namespace Torpedo\ValueObjects\Web;

use InvalidArgumentException;

class EmailAddress implements \JsonSerializable
{
    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @param string $emailAddress
     */
    public function __construct($emailAddress)
    {
        $emailAddress = trim((string) $emailAddress);
        $validator = new EmailAddressValidator($emailAddress, EmailAddressValidator::RFC_5322);
        if (!$validator->isValid()) {
            throw new InvalidArgumentException('Invalid EmailAddress: ' . $emailAddress);
        }
        $this->emailAddress = $emailAddress;
    }

    public static function toerismeLimburg()
    {
        return new self('info@toerismewerkt.be');
    }

    /**
     * Returns the local part of the email address
     * @return string
     */
    public function getLocalPart()
    {
        $parts = explode('@', $this->emailAddress);
        return $parts[0];
    }

    /**
     * Returns the domain part of the email address
     * @return string
     */
    public function getDomainPart()
    {
        $parts = \explode('@', $this->emailAddress);
        return $parts[1];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->emailAddress;
    }

    /**
     * @param EmailAddress $other
     * @return bool
     */
    public function equals(EmailAddress $other)
    {
        return $this->emailAddress == $other->emailAddress;
    }

    /**
     * @return string
     */
    function jsonSerialize()
    {
        return $this->__toString();
    }
}