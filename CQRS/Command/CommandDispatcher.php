<?php

namespace Torpedo\CQRS\Command;

interface CommandDispatcher
{
    /**
     * @param Command $command
     */
    public function dispatch(Command $command);
}
