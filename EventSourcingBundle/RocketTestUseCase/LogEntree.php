<?php


namespace Torpedo\EventSourcingBundle\RocketTestUseCase;


final class LogEntree implements \JsonSerializable
{
    private $from;
    private $to;

    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    function jsonSerialize()
    {
        return [
            'to' => $this->to,
            'from' => $this->from,
        ];
    }
}
