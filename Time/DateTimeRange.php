<?php


namespace Torpedo\Time;


use Torpedo\Exception\InvalidArgumentException;

class DateTimeRange implements \JsonSerializable
{
    /**
     * @var \DateTime
     */
    private $from;

    /**
     * @var \DateTime
     */
    private $till;

    /**
     * @param \DateTime $from
     * @param \DateTime $till
     * @throws InvalidArgumentException
     */
    public function __construct(\DateTime $from, \DateTime $till)
    {
        if ($till < $from) {
            throw new InvalidArgumentException("The from DateTime can not be later than the till DateTime.");
        }

        $this->from = $from;
        $this->till = $till;
    }

    /**
     * @return \DateTime
     */
    public function getFrom()
    {
        return clone $this->from;
    }

    /**
     * @return \DateTime
     */
    public function getTill()
    {
        return clone $this->till;
    }

    /**
     * @return bool
     */
    public function isWithinSingleDay()
    {
        return $this->from->format('Y-m-d') == $this->till->format('Y-m-d');
    }

    public function equals(DateTimeRange $other)
    {
        return $this->getFrom() == $other->getFrom() && $this->getTill() == $other->getTill();
    }

    function jsonSerialize()
    {
        return [
            'from' => $this->from->format('c'),
            'till' => $this->till->format('c')
        ];
    }

    public function contains(\DateTime $dateTime): bool
    {
        return $this->from <= $dateTime && $this->till >= $dateTime;
    }
}
