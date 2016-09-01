<?php


namespace Torpedo\Tests\ValueObjects\Money;


use Torpedo\ValueObjects\Money\EuroAmount;

final class EuroAmountTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function should_round_properly()
    {
        $this->assertTrue((new EuroAmount(20.41))->equals(new EuroAmount(20.41)));
        $this->assertTrue((new EuroAmount(20.4099999999999))->equals(new EuroAmount(20.41)));
        $this->assertTrue((new EuroAmount(20.40500000))->equals(new EuroAmount(20.41)));
        $this->assertTrue((new EuroAmount(20.404999999))->equals(new EuroAmount(20.40)));
    }


}
