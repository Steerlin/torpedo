<?php

namespace Torpedo\Time;

use JsonSerializable;

class Year implements JsonSerializable
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function toInt()
    {
        return intval($this->value);
    }

    function jsonSerialize()
    {
        return $this->toInt();
    }
}