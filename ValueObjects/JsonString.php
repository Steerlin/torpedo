<?php


namespace Torpedo\ValueObjects;


use Torpedo\ValueObjects\String\StringLiteral;

final class JsonString extends StringLiteral
{

    public static function empty()
    {
        return new self('{}');
    }

    public function jsonSerialize($assoc = false)
    {
        return json_decode($this->__toString(), $assoc);
    }

}
