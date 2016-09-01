<?php


namespace Torpedo\EventSourcing;


interface Projector
{
    public function project(EventStream $stream);

    public function erase();
}