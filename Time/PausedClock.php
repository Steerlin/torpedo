<?php

namespace Torpedo\Time;

use DateTimeInterface;

final class PausedClock implements Clock
{

    /**
     * @var DateTimeInterface
     */
    private $pausedOn;

    /**
     * PausedClock constructor.
     * @param DateTimeInterface $pausedOn
     */
    public function __construct(DateTimeInterface $pausedOn)
    {
        $this->pausedOn = $pausedOn;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCurrentDateTime()
    {
        return $this->pausedOn;
    }
}
