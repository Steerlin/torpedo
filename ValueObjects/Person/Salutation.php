<?php

namespace Torpedo\ValueObjects\Person;

use Torpedo\Exception\InvalidArgumentException;
use Torpedo\ValueObjects\String\StringLiteral;

class Salutation extends StringLiteral
{
    const MISTER = "De heer";
    const MISS = "Mevrouw";

    /**
     * @var array
     */
    private static $availableSalutations = [
        self::MISTER,
        self::MISS
    ];

    /**
     * Salutation constructor.
     * @var string $value
     */
    public function __construct($value)
    {
        $this->guardValidSalutation($value);
        parent::__construct($value);
    }

    public static function mister() : Salutation
    {
        return new static(self::MISTER);
    }

    public static function miss() : Salutation
    {
        return new static(self::MISS);
    }

    /**
     * @param $value
     */
    private function guardValidSalutation($value)
    {
        if (!in_array($value, self::$availableSalutations)) {
            throw InvalidArgumentException::notOneOf($value, self::$availableSalutations);
        }
    }

}