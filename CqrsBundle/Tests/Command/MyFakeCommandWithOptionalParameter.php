<?php

namespace Torpedo\CqrsBundle\Tests\Command;

use Torpedo\CQRS\Command\Command;

final class MyFakeCommandWithOptionalParameter implements Command
{
    private $thingId;
    private $optionalThing;

    public function __construct($thingId, $optionalThing = null)
    {
        $this->thingId = $thingId;
        $this->optionalThing = $optionalThing;
    }
}