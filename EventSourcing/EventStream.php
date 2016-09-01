<?php


namespace Torpedo\EventSourcing;

use Countable;
use Iterator;

interface EventStream extends Iterator, Countable
{
    /**
     * @return DomainEvent
     */
    public function current();

    /**
     * @return string
     */
    public function key();

    /**
     * @return void
     */
    public function next();

    /**
     * @return bool
     */
    public function valid();

    /**
     * @return void
     */
    public function rewind();
}