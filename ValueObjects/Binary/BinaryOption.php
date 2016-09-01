<?php

namespace Torpedo\ValueObjects\Binary;

use JsonSerializable;

class BinaryOption implements JsonSerializable
{
    /**
     * @var bool
     */
    protected $value;

    /**
     * BinaryOption constructor.
     * @param string|bool|integer $value
     */
    public function __construct($value)
    {
        if (gettype($value) == "string") {
            $this->value = (strcasecmp($value, "Y") == 0 || strcasecmp($value, "T") == 0 || strcasecmp($value, "TRUE") == 0 || strcasecmp($value, "1") == 0);
        }
        else {
            $this->value = (bool)$value;
        }
    }

    /**
     * @param BinaryOption $other
     * @return bool
     */
    public function equals(BinaryOption $other)
    {
        return $this->value == $other->value;
    }

    public function getBoolean() : bool
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value ? "true" : "false";
    }

    /**
     * @return bool
     */
    function jsonSerialize()
    {
        return $this->value;
    }
}