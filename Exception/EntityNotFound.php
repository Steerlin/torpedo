<?php

namespace Torpedo\Exception;

use Exception;
use Torpedo\Uuid\Identifier;

final class EntityNotFound extends Exception
{
    public static function forType($type, Identifier $identifier = null)
    {
        $message = "Could not find entity of type $type.";
        if ($identifier) {
            $message .= "Searched by identifier " . (string)$identifier;
        }
        return new static($message);
    }
}