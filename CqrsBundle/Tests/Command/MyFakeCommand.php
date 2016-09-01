<?php

namespace Torpedo\CqrsBundle\Tests\Command;

use Torpedo\CQRS\Command\Command;

final class MyFakeCommand implements Command
{
    private $thingId;
    private $thingDate;
    private $listOfThings;

    public function __construct($thingId, $thingDate, array $listOfThings)
    {
        $this->thingId = $thingId;
        $this->thingDate = $thingDate;
        $this->listOfThings = $listOfThings;
    }
}