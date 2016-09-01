<?php


namespace Torpedo\EventSourcing;



interface EventPublisher
{
    public function publish(EventStream $eventStream);

}
