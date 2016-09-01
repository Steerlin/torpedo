<?php


namespace Torpedo\CQRS\Command;


interface CommandBus
{
    public function queue(Command $command);

    /**
     * Dispatches the next command on the queue, or waits until a new command is available
     * @return void
     */
    public function dispatchNext();

}