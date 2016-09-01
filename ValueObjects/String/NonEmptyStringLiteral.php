<?php

namespace Torpedo\ValueObjects\String;

use Torpedo\Exception\InvalidArgumentException;

class NonEmptyStringLiteral extends StringLiteral
{
    public function __construct($value)
    {
        $this->validate($value);
        parent::__construct($value);
    }

    protected function validate($value)
    {
        if (!preg_match('/\S/', $value)) {
            throw new InvalidArgumentException("Instance of class " . __CLASS__ . " can't be empty.");
        }
    }
}