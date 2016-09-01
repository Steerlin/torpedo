<?php


namespace Torpedo\Exception;


class InvalidArgumentException extends \InvalidArgumentException
{
    public static function doesNotImplement($class, $interface)
    {
        return new static("Object of class $class should implement $interface");
    }

    public static function notOneOf($given, $available)
    {
        return new static("'$given' is not not a valid argument. Should be one of ['" . implode(',',
                $available) . "'].");
    }
}