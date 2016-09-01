<?php


namespace Torpedo\EventSourcing;


use Torpedo\Uuid\Identifier;

final class EventId extends Identifier
{

    public static function getPrefix()
    {
        return 'Event';
    }
}
