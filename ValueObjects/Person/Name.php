<?php

namespace Torpedo\ValueObjects\Person;

use JsonSerializable;

class Name implements JsonSerializable
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @param $firstName
     * @param $lastName
     */
    public function __construct($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @param Name $other
     * @return bool
     */
    public function equals(Name $other)
    {
        return $this->firstName == $other->firstName && $this->lastName == $other->lastName;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }

    public function displayName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}