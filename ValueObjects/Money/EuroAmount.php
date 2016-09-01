<?php


namespace Torpedo\ValueObjects\Money;


use JsonSerializable;
use Torpedo\Exception\InvalidArgumentException;

class EuroAmount implements JsonSerializable
{
    const CURRENCY = "EUR";

    /**
     * @var int
     */
    private $amount;

    public function __construct(float $amount)
    {
        $this->validate($amount);
        $this->amount = (int) round($amount * 100);
    }

    private function validate(float $amount)
    {
        if (!is_numeric($amount)) {
            throw new InvalidArgumentException('Price amount should be numeric, got: ' . $amount);
        }
    }

    /**
     * @return EuroAmount
     */
    public static function zero()
    {
        return new self(0);
    }

    /**
     * @param EuroAmount $euroPrice
     * @return EuroAmount
     */
    public function add(EuroAmount $euroPrice)
    {
        return new self(round(($this->amount + $euroPrice->amount) / 100, 2));
    }

    /**
     * @param EuroAmount $other
     * @return bool
     */
    public function equals(EuroAmount $other)
    {
        return round($this->amount, 2) == round($other->amount, 2);
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return round($this->amount / 100, 2);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getAmount();
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->getAmount();
    }

}