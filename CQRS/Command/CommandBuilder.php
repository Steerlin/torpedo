<?php


namespace Torpedo\CQRS\Command;


interface CommandBuilder
{

    /**
     * @return Command
     */
    public function build();

}
