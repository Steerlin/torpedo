<?php


namespace Torpedo\Tests\ValueObjects\Web;


use InvalidArgumentException;
use Torpedo\ValueObjects\Web\EmailAddress;

final class EmailAddressTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function should_not_throw_on_smets_davy_at_nep()
    {
        new EmailAddress('smets_davy@nep');
        new EmailAddress('info@steventeerlinck.be');
        new EmailAddress('steven.teerlinck@one-agency.be');
        new EmailAddress('label++@one-agency.be');
    }

    /**
     * @test
     */
    public function should_throw_on_invalid_email_addresses()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        new EmailAddress('qsdf');
    }

}
