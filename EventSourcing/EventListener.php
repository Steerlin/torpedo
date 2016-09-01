<?php


namespace Torpedo\EventSourcing;


interface EventListener
{

    public function notifyThat(EventStream $eventStream);

}
