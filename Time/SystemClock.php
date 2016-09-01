<?php

namespace Torpedo\Time;

use DateTimeImmutable;
use DateTimeInterface;

final class SystemClock implements Clock
{
    /**
     * @return DateTimeInterface
     */
    public function getCurrentDateTime()
    {
        return new DateTimeImmutable('now');
    }
}
