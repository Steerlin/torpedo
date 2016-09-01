<?php


namespace Torpedo\CqrsBundle\CommandBus;


interface SerialisedCommandRepository
{

    public function add(SerialisedCommand $serialisedCommand);

    public function findFirstToDo(string $queueName): SerialisedCommand;

    public function remove(SerialisedCommand $serialisedCommand);
}
