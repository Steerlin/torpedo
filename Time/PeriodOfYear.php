<?php


namespace Torpedo\Time;


use Torpedo\Exception\InvalidArgumentException;

final class PeriodOfYear implements \JsonSerializable
{

    private $from;
    private $till;

    public function __construct(DayInYear $from, DayInYear $till)
    {
        if ($till->isEarlierThen($from)) {
            throw new InvalidArgumentException("Invalid PeriodOfYear: " . $from->getDay() . '-' . $till->getDay());
        }

        $this->from = $from;
        $this->till = $till;
    }

    function jsonSerialize()
    {
        return [
            'from' => $this->from,
            'till' => $this->till,
        ];
    }

    public function getFrom(): DayInYear
    {
        return $this->from;
    }

    public function getTill(): DayInYear
    {
        return $this->till;
    }

    public function overlapsWith(PeriodOfYear $other): bool
    {
        return $this->contains($other->from) || $this->contains($other->till);
    }

    public function contains(DayInYear $dayInYear): bool
    {
        return
            $this->from->isLessThenOrEqualTo($dayInYear) &&
            $this->till->isGreaterThenOrEqualTo($dayInYear);
    }
}
