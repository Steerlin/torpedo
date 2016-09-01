<?php


namespace Torpedo\ValueObjects\IntegerValue;


use InvalidArgumentException;

class IntegerValue implements \JsonSerializable
{

    private $value;

    public function __construct(int $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->toInt();
    }

    private function validate($value)
    {
        if ($value < $this->getMinimumValue() || $value > $this->getMaximumValue()) {
            throw new InvalidArgumentException("The value of the integer used in " . __CLASS__ . ", has to be between " . $this->getMinimumValue() . " and " . $this->getMaximumValue());
        }
    }

    public function getMinimumValue() : int
    {
        return PHP_INT_MIN;
    }

    public function getMaximumValue() : int
    {
        return PHP_INT_MAX;
    }

    function jsonSerialize()
    {
        return $this->toInt();
    }
}
