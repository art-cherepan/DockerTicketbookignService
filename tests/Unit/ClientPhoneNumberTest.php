<?php

namespace App\Tests\Unit;

use App\Domain\Booking\Entity\Exception\NonValidClientPhoneException;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use PHPUnit\Framework\TestCase;

class ClientPhoneNumberTest extends TestCase
{
    public function testInvalidClientPhoneNumber(): void
    {
        self::expectException(NonValidClientPhoneException::class);

        new ClientPhoneNumber('+7914521145');
    }
}
