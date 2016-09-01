<?php

namespace Torpedo\Tests\ValueObjects\Binary;


use Torpedo\ValueObjects\Binary\BinaryOption;

class BinaryOptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function should_return_correct_bool()
    {
        $this->assertTrue((new BinaryOption("true"))->equals(new BinaryOption("Y")));
        $this->assertTrue((new BinaryOption("true"))->getBoolean() == true);
        $this->assertTrue((new BinaryOption("TRUE"))->getBoolean() == true);
        $this->assertTrue((new BinaryOption("N"))->getBoolean() == false);

        $this->assertTrue((new BinaryOption("0"))->getBoolean() == false);
        $this->assertTrue((new BinaryOption("1"))->getBoolean() == true);
        $this->assertTrue((new BinaryOption(1))->getBoolean() == true);
        $this->assertTrue((new BinaryOption(true))->getBoolean() == true);
    }
}