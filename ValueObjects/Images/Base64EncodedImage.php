<?php

namespace Torpedo\ValueObjects\Images;

use Torpedo\ValueObjects\String\StringLiteral;

class Base64EncodedImage extends StringLiteral
{
    public function decode() {
        return base64_decode($this->value);
    }
}