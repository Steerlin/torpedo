<?php

namespace Torpedo\ValueObjects\String;

use JsonSerializable;

class StringLiteral implements JsonSerializable
{
    /**
     * @var string
     */
    protected $value;

    /**
     * StringLiteral constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = (string)$value;
    }

    /**
     * @param StringLiteral $other
     * @return bool
     */
    public function equals(StringLiteral $other)
    {
        return $this->value == $other->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    function jsonSerialize()
    {
        return $this->__toString();
    }

    /**
     * @param $values
     * @return StringLiteral
     */
    public static function map($values)
    {
        $stringLiterals = [];
        foreach ($values as $value) {
            $stringLiterals[] = new static($value);
        }
        return $stringLiterals;
    }
}