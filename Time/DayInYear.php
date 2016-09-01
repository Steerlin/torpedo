<?php


namespace Torpedo\Time;


use Torpedo\Exception\InvalidArgumentException;

final class DayInYear implements \JsonSerializable
{
    private $day;

    public function __construct(int $day)
    {
        $this->guardValid($day);

        $this->day = $day;
    }

    public static function fromDayAndMonth(int $day, int $month)
    {
        //take a leapyear for calculation
        $date = new \DateTime();
        $date->setDate(2012, $month, $day);

        //check for valid values, not really necessary but compliant with previous class
        if ($month != intval($date->format('n'))) {
            throw new InvalidArgumentException('Invalid DayInYear: ' . $day . '-' . $month);
        }

        return new self(intval($date->format('z')));
    }

    private function guardValid(int $day)
    {
        if ($day < 0 || $day > 366) {
            throw new InvalidArgumentException('Invalid DayInYear: ' . $day);
        }
    }

    public static function current(): DayInYear
    {
        $currentDate = new \DateTime();

        //change to leapyear to be consistent for each year
        $currentDate->setDate(2012, intval($currentDate->format('n')), intval($currentDate->format('j')));

        return new self(intval($currentDate->format('z')));
    }

    public function isEarlierThen(DayInYear $other)
    {
        return $this->day < $other->getDay();
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function jsonSerialize()
    {
        $date = \DateTime::createFromFormat('Y z', '2012 ' . strval($this->day));

        return [
            'day' => intval($date->format('j')),
            'month' => intval($date->format('n'))
        ];
    }

    public function isLessThenOrEqualTo(DayInYear $dayInYear): bool
    {
        return $this->day <= $dayInYear->getDay();
    }

    public function isGreaterThenOrEqualTo(DayInYear $dayInYear): bool
    {
        return $this->day >= $dayInYear->getDay();
    }
}
