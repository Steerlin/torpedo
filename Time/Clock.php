<?php

namespace Torpedo\Time;

use DateTimeInterface;

interface Clock
{
    /**
     * @return DateTimeInterface
     */
    public function getCurrentDateTime();
}
