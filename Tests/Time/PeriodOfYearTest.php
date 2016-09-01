<?php


namespace Torpedo\Tests\Time;


use Torpedo\Exception\InvalidArgumentException;
use Torpedo\Time\DayInYear;
use Torpedo\Time\PeriodOfYear;

final class PeriodOfYearTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function should_throw_when_till_isEarlierThen_from()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        new PeriodOfYear(DayInYear::fromDayAndMonth(5, 12), DayInYear::fromDayAndMonth(20, 5));
    }

    /**
     * @test
     */
    public function should_jsonSerialize()
    {
        $expectedJson = '{"from":{"day":20,"month":5},"till":{"day":5,"month":12}}';
        $periodInYear = new PeriodOfYear(DayInYear::fromDayAndMonth(20, 5), DayInYear::fromDayAndMonth(5, 12));
        $this->assertEquals($expectedJson, json_encode($periodInYear));
    }

    /**
     * @test
     */
    public function should_answer_contains_correctly()
    {
        $periodInYear = new PeriodOfYear(DayInYear::fromDayAndMonth(20, 5), DayInYear::fromDayAndMonth(5, 12));
        $this->assertTrue($periodInYear->contains(new DayInYear(200)));
        $this->assertTrue($periodInYear->contains(new DayInYear(300)));
        $this->assertFalse($periodInYear->contains(new DayInYear(50)));
        $this->assertTrue($periodInYear->contains(new DayInYear(250)));
        $this->assertTrue($periodInYear->contains(DayInYear::fromDayAndMonth(20, 5)));
        $this->assertFalse($periodInYear->contains(DayInYear::fromDayAndMonth(20, 1)));
    }

    /**
     * @test
     */
    public function should_answer_overlapsWith_correctly()
    {
        $basePeriod = new PeriodOfYear(DayInYear::fromDayAndMonth(5, 5), DayInYear::fromDayAndMonth(25, 5));
        $before = new PeriodOfYear(DayInYear::fromDayAndMonth(1, 5), DayInYear::fromDayAndMonth(3, 5));
        $frontOverlapping = new PeriodOfYear(DayInYear::fromDayAndMonth(1, 5), DayInYear::fromDayAndMonth(10, 5));
        $inside = new PeriodOfYear(DayInYear::fromDayAndMonth(10, 5), DayInYear::fromDayAndMonth(15, 5));
        $backOverlapping = new PeriodOfYear(DayInYear::fromDayAndMonth(15, 5), DayInYear::fromDayAndMonth(28, 5));
        $after = new PeriodOfYear(DayInYear::fromDayAndMonth(15, 6), DayInYear::fromDayAndMonth(28, 6));

        $this->assertTrue($basePeriod->overlapsWith($basePeriod)); // self
        $this->assertFalse($basePeriod->overlapsWith($before));
        $this->assertTrue($basePeriod->overlapsWith($frontOverlapping));
        $this->assertTrue($basePeriod->overlapsWith($inside));
        $this->assertTrue($basePeriod->overlapsWith($backOverlapping));
        $this->assertFalse($basePeriod->overlapsWith($after));
    }

}
