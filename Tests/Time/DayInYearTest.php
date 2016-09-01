<?php


namespace Torpedo\Tests\Time;


use Torpedo\Exception\InvalidArgumentException;
use Torpedo\Time\DayInYear;

final class DayInYearTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function should_throw_when_constructed_with_invalid_day_0()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        DayInYear::fromDayAndMonth(0, 5);
    }

    /**
     * @test
     */
    public function should_throw_when_constructed_with_invalid_day_32()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        DayInYear::fromDayAndMonth(32, 5);
    }

    /**
     * @test
     */
    public function should_throw_when_constructed_with_invalid_month_0()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        DayInYear::fromDayAndMonth(20, 0);
    }

    /**
     * @test
     */
    public function should_throw_when_constructed_with_invalid_month_13()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        DayInYear::fromDayAndMonth(20, 13);
    }

}
