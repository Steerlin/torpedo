<?php

namespace Torpedo\CQRS\Command;

interface CommandDeserializer
{
    /**
     * @param mixed $serialized
     * @return Command
     * @throws CanNotDeserialize
     */
    public function deserialize($serialized);
}
